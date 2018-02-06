<?php

namespace Nip\Dispatcher\Tests;

use Nip\Dispatcher\Dispatcher;
use Nip\Dispatcher\Commands\Command;
use Nip\Dispatcher\Exceptions\InvalidCommandException;

use League\Pipeline\PipelineInterface;
use Nip\Dispatcher\Resolver\Pipeline\PipelineBuilder;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class DispatcherTest
 * @package Nip\Dispatcher\Tests
 */
class DispatcherTest extends AbstractTest
{

    /**
     * @var Dispatcher
     */
    protected $object;


    public function testEmptyCommand()
    {
        $command = new Command();

        self::expectException(InvalidCommandException::class);
        $this->object->dispatchCommand($command);
    }

    public function testClosure()
    {
        $command = new Command();
        $command->setAutoInitRequest(true);
        $command->getRequest()->query->set('variable', 'value');
        $command->setAction(
            function (RequestInterface $request, ResponseInterface $response) {
                return $response->setContent($request->query->get('variable'));
            }
        );

        $response = $this->object->dispatchCommand($command)->getResponse();
        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertSame('value', $response->getContent());
    }

    protected function setUp()
    {
        parent::setUp();
        $this->object = new Dispatcher();
    }
}
