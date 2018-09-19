<?php

namespace Nip\Dispatcher\Tests\Resolver\ClassResolver;

use Nip\Dispatcher\Resolver\ClassResolver\NameGenerator;
use Nip\Dispatcher\Tests\AbstractTest;

/**
 * Class NameGeneratorTest
 * @package Nip\Dispatcher\Tests\Resolver\ClassResolver
 */
class NameGeneratorTest extends AbstractTest
{
    /**
     * @dataProvider generateClassesData
     * @param $module
     * @param $controller
     * @param $generated
     */
    public function testGenerateClasses($module, $controller, $generated)
    {
        $classes = NameGenerator::generateClasses($module, $controller);

        self::assertSame($generated, $classes);
    }

    /**
     * @return array
     */
    public function generateClassesData()
    {
        return [
            ['organizers', 'events', ['Modules\Organizers\Controllers\EventsController', 'Organizers_EventsController']]
        ];
    }
}
