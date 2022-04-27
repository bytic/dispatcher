<?php
declare(strict_types=1);

namespace Nip\Dispatcher\Resolver\ClassResolver;

use Nip\Utility\Traits\SingletonTrait;

/**
 * Class NameGenerator
 * @package Nip\Dispatcher\Resolver\ClassResolver
 */
class NameGenerator
{
    use SingletonTrait;

    protected array $namespaces = [];


    /**
     * @param $module
     * @param $controller
     * @return array
     */
    public static function generateClasses($module, $controller)
    {
        $module = NameFormatter::formatModuleName($module);
        $controller = NameFormatter::formatControllerName($controller);

        $return = self::instance()->generateControllerNamespacedVariations($module, $controller);
        $return[] =  self::generateControllerString($module, $controller);
        return $return;
    }

    /**
     * @param $module
     * @param $controller
     * @return string
     */
    public static function generateControllerNamespaced($module, $controller, $namespace = null)
    {
        $name = static::generateModuleNameNamespace($module, $namespace);
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
     * @param $namespace
     */
    public function addNamespace($namespace)
    {
        $this->namespaces[] = $namespace;
    }

    public function addNamespaces(array $namespaces)
    {
        foreach ($namespaces as $namespace) {
            $this->addNamespace($namespace);
        }
    }

    protected function __construct($namespaces = [''])
    {
        $this->namespaces = $namespaces;
    }

    /**
     * @param $module
     * @return string
     */
    protected static function generateModuleNameNamespace($module, $namespace = null)
    {
        $namespace = $namespace ?: reset(self::instance()->namespaces);
        $name = $namespace . 'Modules\\';
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

    protected function generateControllerNamespacedVariations(mixed $module, mixed $controller): array
    {
        $return = [];
        foreach ($this->namespaces as $namespace) {
            $return[] = static::generateControllerNamespaced($module, $controller, $namespace);
        }
        return $return;
    }


}
