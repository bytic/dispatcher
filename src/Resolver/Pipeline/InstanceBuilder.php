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
use Nip\Dispatcher\Resolver\Pipeline\Stages\InstanceReturnStage;
use Nip\Dispatcher\Resolver\Pipeline\Stages\MethodCallStage;
use Nip\Dispatcher\Resolver\Pipeline\Stages\ModuleControllerStage;
use Nip\Dispatcher\Resolver\Pipeline\Stages\RequestStage;

/**
 * Class InstanceBuilder
 * @package Nip\Dispatcher\Resolver\Pipeline
 */
class InstanceBuilder extends AbstractBuilder
{
    public function __construct()
    {
        $this->add(new ClosureStage());
        $this->add(new RequestStage());
        $this->add(new ModuleControllerStage());
        $this->add(new ClassInstanceStage());
        $this->add(new MethodCallStage());
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
                    return !$command->hasActionParam('instance');
                }
            );
        }
        return parent::build($processor);
    }
}
