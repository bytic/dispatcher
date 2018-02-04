<?php

namespace Nip\Dispatcher\Resolver\Pipeline;

use League\Pipeline\PipelineBuilder as AbstractBuilder;
use Nip\Dispatcher\Resolver\Pipeline\Stages\ActionCallStage;
use Nip\Dispatcher\Resolver\Pipeline\Stages\ClassInstanceStage;
use Nip\Dispatcher\Resolver\Pipeline\Stages\ClosureStage;
use Nip\Dispatcher\Resolver\Pipeline\Stages\ModuleControllerStage;
use Nip\Dispatcher\Resolver\Pipeline\Stages\RequestStage;

/**
 * Class MethodsPipeline
 * @package Nip\Dispatcher\Resolver\Pipeline
 */
class PipelineBuilder extends AbstractBuilder
{
    public function __construct()
    {
        $this->add(new ClosureStage());
        $this->add(new RequestStage());
        $this->add(new ModuleControllerStage());
        $this->add(new ClassInstanceStage());
        $this->add(new ActionCallStage());
    }
}
