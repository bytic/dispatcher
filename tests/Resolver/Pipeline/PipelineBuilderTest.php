<?php

namespace Nip\Dispatcher\Tests\Resolver\Pipeline;

use League\Pipeline\Pipeline;
use League\Pipeline\PipelineInterface;
use Nip\Dispatcher\Resolver\Pipeline\ActionBuilder;
use Nip\Dispatcher\Tests\AbstractTest;

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

    /**
     * @return PipelineInterface|Pipeline
     */
    protected function buildPipeline()
    {
        $builder = new ActionBuilder();
        return $builder->build();
    }
}
