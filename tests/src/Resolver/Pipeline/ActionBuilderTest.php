<?php

namespace Nip\Dispatcher\Tests\Resolver\Pipeline;

use League\Pipeline\Pipeline;
use Modules\Frontend\Controllers\BaseTraitController;
use Nip\Dispatcher\Commands\Command;
use Nip\Dispatcher\Resolver\Cache\ResolverCache;
use Nip\Dispatcher\Resolver\Pipeline\ActionBuilder;
use Nip\Dispatcher\Tests\AbstractTest;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ActionBuilderTest
 * @package Nip\Dispatcher\Tests\Resolver\Pipeline
 */
class ActionBuilderTest extends AbstractTest
{
    public function testBuildCommand()
    {
        $builder = new ActionBuilder();
        $pipeline = $builder->build();

        self::assertInstanceOf(Pipeline::class, $pipeline);
    }

    public function testRequestModuleController()
    {
        $builder = new ActionBuilder();
        $pipeline = $builder->build();

        $command = new Command();
        $command->setAutoInitRequest(true);
        $command->getRequest(true)
            ->setModuleName('Frontend')
            ->setControllerName('BaseTrait');

        $response = $pipeline->process($command)->getReturn();
        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertEquals('index response', $response->getContent());
    }

    public function testGetFromCache()
    {
        $builder = new ActionBuilder();
        $pipeline = $builder->build();

        $command = new Command();
        $command->setAutoInitRequest(true);
        $command->getRequest(true)
            ->setModuleName('Frontend')
            ->setControllerName('BaseFakeTrait');

        ResolverCache::setFromAction(
            ['module' => 'Frontend', 'controller' => 'BaseFakeTrait'],
            BaseTraitController::class
        );

        $response = $pipeline->process($command)->getReturn();
        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertEquals('index response', $response->getContent());
    }
}
