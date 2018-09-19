<?php

namespace Nip\Dispatcher\Resolver\ClassResolver;

/**
 * Class NameGenerator
 * @package Nip\Dispatcher\Resolver\ClassResolver
 */
class NameGenerator
{
    /**
     * @param $module
     * @param $controller
     * @return array
     */
    public static function generateClasses($module, $controller)
    {
        $module = NameFormatter::formatModuleName($module);
        $controller = NameFormatter::formatControllerName($controller);
        return [
            self::generateControllerNamespaced($module, $controller),
            self::generateControllerString($module, $controller)
        ];
    }

    /**
     * @param $module
     * @param $controller
     * @return string
     */
    public static function generateControllerNamespaced($module, $controller)
    {
        $name = static::generateModuleNameNamespace($module);
        $name .= '\Controllers\\';
        $name .= static::formatControllerName($controller);

        return $name;
    }


    /**
     * @param $module
     * @param $controller
     * @return string
     */
    public static function generateControllerString($module, $controller)
    {
        return $module . "_" . $controller . "Controller";
    }

    /**
     * @param $module
     * @return string
     */
    protected static function generateModuleNameNamespace($module)
    {
        $name = self::getRootNamespace() . 'Modules\\';
        $module = strtolower($module) == 'default' ? 'Frontend' : $module;
        $name .= $module;
        return $name;
    }

    /**
     * @param string $name
     * @return mixed
     */
    protected static function formatControllerName($name)
    {
        $name = str_replace('_', '\\', $name) . "Controller";

        return $name;
    }
    /**
     * @return string
     */
    protected static function getRootNamespace()
    {
        if (function_exists('app')) {
            return app('app')->getRootNamespace();
        }
        return '';
    }
}
