<?php

namespace Nip\Dispatcher\Resolver;

use Nip\Controllers\Controller;
use Nip\Dispatcher\Resolver\ClassResolver\NameGenerator;

/**
 * Class ClassResolver
 * @package Nip\Dispatcher\Resolver
 */
class ClassResolver
{

    /**
     * @param $module
     * @param $controller
     * @return Controller
     */
    public static function resolveFromParams($module, $controller)
    {
        $classes = NameGenerator::generateClasses($module, $controller);
        return self::resolveFromClasses($classes);
    }

    /**
     * @param $controllerNames
     * @return Controller|null
     */
    public static function resolveFromClasses($controllerNames)
    {
        foreach ($controllerNames as $class) {
            if (self::validController($class)) {
                return self::newController($class);
            }
        }
        return null;
    }

    /**
     * @param $class
     * @return bool
     */
    protected static function validController($class)
    {
        return class_exists($class);
    }

    /**
     * @param string $class
     * @return Controller
     */
    public static function newController($class)
    {
        $controller = new $class();
        return $controller;
    }
}
