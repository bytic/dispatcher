<?php

namespace Nip\Dispatcher\Tests;

use Nip\Dispatcher\Commands\Command;
use Nip\Dispatcher\Dispatcher;
use Nip\Dispatcher\Exceptions\InvalidCommandException;
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
        $command->getRequest(true)->query->set('variable', 'value');
        $command->setAction(
            function (RequestInterface $request, ResponseInterface $response) {
                return $response->setContent($request->query->get('variable'));
            }
        );

        $response = $this->object->dispatchCommand($command)->getReturn();
        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertSame('value', $response->getContent());
    }

    public function testRequestModuleController()
    {
        $command = new Command();
        $command->setAutoInitRequest(true);
        $command->getRequest(true)
            ->setModuleName('frontend')
            ->setControllerName('baseTrait');

        $response = $this->object->dispatchCommand($command)->getReturn();
        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertEquals('index response', $response->getContent());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->object = new Dispatcher();
    }
}
