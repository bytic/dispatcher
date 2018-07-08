<?php

namespace Nip\Dispatcher\Resolver;

use League\Pipeline\InterruptibleProcessor;
use League\Pipeline\Pipeline;
use Nip\Dispatcher\Commands\Command;
use Nip\Dispatcher\Exceptions\ForwardException;
use Nip\Dispatcher\Resolver\Pipeline\ActionBuilder;
use Nip\Dispatcher\Resolver\Pipeline\Stages\StageInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Trait HasResolverPipelineTrait
 * @package Nip\Dispatcher\Resolver
 */
trait HasResolverPipelineTrait
{
    /**
     * @var Pipeline[]
     */
    protected $resolverPipeline = [];

    /**
     * @param Command $command
     * @return Command
     * @throws ForwardException
     */
    protected function processCommand(Command $command)
    {
        $pipeline = $this->getResolverPipeline();
        return $pipeline->process($command);
    }

    /**
     * @param string $type
     * @return Pipeline
     */
    public function getResolverPipeline($type = ActionBuilder::class)
    {
        if (!isset($this->resolverPipeline[$type])) {
            $this->initResolverPipeline($type);
        }
        return $this->resolverPipeline[$type];
    }

    /**
     * @param string $type
     */
    protected function initResolverPipeline($type)
    {
        $this->resolverPipeline[$type] = $this->getResolverBuilder($type)->build();
    }

    /**
     * @param $type
     * @return ActionBuilder
     */
    protected function getResolverBuilder($type)
    {
        return (new $type());
    }
}
