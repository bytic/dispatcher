<?php

namespace Nip\Dispatcher\Resolver;

use League\Pipeline\InterruptibleProcessor;
use Nip\Dispatcher\Commands\Command;
use Nip\Dispatcher\Exceptions\ForwardException;
use Nip\Dispatcher\Resolver\Pipeline\PipelineBuilder;
use Nip\Dispatcher\Resolver\Pipeline\Stages\StageInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Trait HasResolverPipelineTrait
 * @package Nip\Dispatcher\Resolver
 */
trait HasResolverPipelineTrait
{
    /**
     * @var null|PipelineBuilder
     */
    protected $callPipelineBuilder = null;

    /**
     * @param Command $command
     * @return Command
     * @throws ForwardException
     */
    protected function processCommand(Command $command)
    {
        $pipeline = $this->buildCallPipeline();
        return $pipeline->process($command);
    }

    /**
     * @return \League\Pipeline\PipelineInterface|\League\Pipeline\Pipeline
     */
    protected function buildCallPipeline()
    {
        return $this->getCallPipelineBuilder()->build();
    }

    /**
     * @return PipelineBuilder
     */
    public function getCallPipelineBuilder()
    {
        if ($this->callPipelineBuilder === null) {
            $this->initCallPipeline();
        }
        return $this->callPipelineBuilder;
    }

    /**
     * @param StageInterface $stage
     */
    public function addCallPipeline(StageInterface $stage)
    {
        $this->getCallPipelineBuilder()->add($stage);
    }

    /**
     * @param PipelineBuilder $callPipelineBuilder
     */
    public function setCallPipelineBuilder(PipelineBuilder $callPipelineBuilder): void
    {
        $this->callPipelineBuilder = $callPipelineBuilder;
    }


    public function initCallPipeline()
    {
        $this->callPipelineBuilder = (new PipelineBuilder);
    }
}
