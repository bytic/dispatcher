<?php

namespace Nip\Dispatcher\Resolver\ClassResolver;

/**
 * Class NameFormatter
 * @package Nip\Dispatcher\Resolver\ClassResolver
 */
class NameFormatter
{

    /**
     * @param $module
     * @param $controller
     * @param $action
     * @return array
     */
    public static function formatArray($module, $controller, $action)
    {
        return [
            'module' => self::formatModuleName($module),
            'controller' => self::formatControllerName($controller),
            'action' => self::formatActionName($action),
        ];
    }
    /**
     * @param string $name
     * @return mixed
     */
    public static function formatModuleName($name)
    {
        $name = $name ? $name : 'default';

        return inflector()->camelize($name);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public static function formatControllerName($name)
    {
        $name = $name ? $name : 'index';

        return static::getControllerName($name);
    }

    /**
     * @param $controller
     * @return mixed
     */
    protected static function getControllerName($controller)
    {
        return inflector()->classify($controller);
    }

    /**
     * @param boolean $name
     * @return mixed
     */
    public static function formatActionName($name)
    {
        $name = inflector()->camelize($name);
        $name[0] = strtolower($name[0]);

        return $name;
    }
}
