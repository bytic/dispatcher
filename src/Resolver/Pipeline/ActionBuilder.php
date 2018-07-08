<?php

namespace Nip\Dispatcher\Resolver\Pipeline;

use League\Pipeline\InterruptibleProcessor;
use League\Pipeline\PipelineBuilder as AbstractBuilder;
use League\Pipeline\PipelineInterface;
use League\Pipeline\ProcessorInterface;
use Nip\Dispatcher\Commands\Command;
use Nip\Dispatcher\Resolver\Pipeline\Stages\ActionCallStage;
use Nip\Dispatcher\Resolver\Pipeline\Stages\ClassInstanceStage;
use Nip\Dispatcher\Resolver\Pipeline\Stages\ClosureStage;
use Nip\Dispatcher\Resolver\Pipeline\Stages\ModuleControllerStage;
use Nip\Dispatcher\Resolver\Pipeline\Stages\RequestStage;

/**
 * Class ActionBuilder
 * @package Nip\Dispatcher\Resolver\Pipeline
 */
class ActionBuilder extends AbstractBuilder
{
    public function __construct()
    {
        $this->add(new ClosureStage());
        $this->add(new RequestStage());
        $this->add(new ModuleControllerStage());
        $this->add(new ClassInstanceStage());
        $this->add(new ActionCallStage());
    }

    /**
     * Build a new Pipeline object
     *
     * @param  ProcessorInterface|null $processor
     *
     * @return PipelineInterface
     */
    public function build(ProcessorInterface $processor = null): PipelineInterface
    {
        if ($processor == null) {
            $processor = new InterruptibleProcessor(
                function (Command $command) {
                    return !$command->hasReturn();
                }
            );
        }
        return parent::build($processor);
    }
}
