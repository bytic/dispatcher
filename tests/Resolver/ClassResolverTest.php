<?php

namespace Nip\Dispatcher\Tests\Resolver;

use Modules\Frontend\Controllers\BaseTraitController;
use Nip\Dispatcher\Resolver\ClassResolver;
use Nip\Dispatcher\Tests\AbstractTest;

/**
 * Class ClassResolverTest
 * @package Nip\Dispatcher\Tests\Resolver
 */
class ClassResolverTest extends AbstractTest
{
    public function testGenerateParamsNamespaced()
    {
        $controller = ClassResolver::resolveFromParams('frontend', 'BaseTrait');
        self::assertInstanceOf(BaseTraitController::class, $controller);
    }
}
