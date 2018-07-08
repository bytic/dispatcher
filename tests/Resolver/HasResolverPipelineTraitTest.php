<?php

namespace Nip\Dispatcher\Tests\Resolver;

use League\Pipeline\Pipeline;
use Nip\Dispatcher\Resolver\Pipeline\ActionBuilder;
use Nip\Dispatcher\Resolver\Pipeline\InstanceBuilder;
use Nip\Dispatcher\Tests\AbstractTest;
use Nip\Dispatcher\Dispatcher;

/**
 * Class HasResolverPipelineTraitTest
 * @package Nip\Dispatcher\Tests\Resolver
 */
class HasResolverPipelineTraitTest extends AbstractTest
{

    public function testGetResolverPipeline()
    {
        $dispatcher = new Dispatcher();

        $defaultPipeline = $dispatcher->getResolverPipeline();
        self::assertInstanceOf(Pipeline::class, $defaultPipeline);

        $actionPipeline = $dispatcher->getResolverPipeline(ActionBuilder::class);
        self::assertInstanceOf(Pipeline::class, $actionPipeline);
        self::assertSame($defaultPipeline, $actionPipeline);

        $instancePipeline = $dispatcher->getResolverPipeline(InstanceBuilder::class);
        self::assertInstanceOf(Pipeline::class, $instancePipeline);
    }
}
