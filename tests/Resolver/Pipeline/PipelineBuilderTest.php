<?php

namespace Nip\Dispatcher\Tests\Resolver\Pipeline;

use League\Pipeline\Pipeline;
use League\Pipeline\PipelineInterface;
use Nip\Dispatcher\Commands\Command;
use Nip\Dispatcher\Exceptions\InvalidCommandException;
use Nip\Dispatcher\Resolver\Pipeline\PipelineBuilder;
use Nip\Dispatcher\Tests\AbstractTest;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class PipelineBuilderTest
 * @package Nip\Dispatcher\Tests\Commands
 */
class PipelineBuilderTest extends AbstractTest
{

    public function testBuildCommand()
    {
        $pipeline = $this->buildPipeline();

        self::assertInstanceOf(Pipeline::class, $pipeline);
    }

    public function testEmptyCommand()
    {
        $pipeline = $this->buildPipeline();
        $command = new Command();

        self::expectException(InvalidCommandException::class);
        $pipeline->process($command);
    }

    public function testClosure()
    {
        $pipeline = $this->buildPipeline();

        $command = new Command();
        $command->setAutoInitRequest(true);
        $command->getRequest()->query->set('variable', 'value');
        $command->setAction(
            function (RequestInterface $request, ResponseInterface $response) {
                return $response->setContent($request->query->get('variable'));
            }
        );

        $response = $pipeline->process($command)->getResponse();
        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertSame('value', $response->getContent());
    }

    /**
     * @return PipelineInterface|Pipeline
     */
    protected function buildPipeline()
    {
        $builder = new PipelineBuilder();
        return $builder->build();
    }
}
