<?php

namespace Nip\Dispatcher\Resolver\Cache;

use Nip\Utility\Traits\SingletonTrait;

/**
 * Class ResolverCache
 * @package Nip\Dispatcher\Resolver\Cache
 */
class ResolverCache
{
    use SingletonTrait;

    /**
     * @var DefinitionsCollection
     */
    protected $definitions;

    /**
     * ResolverCache constructor.
     * @param DefinitionsCollection $definitions
     */
    protected function __construct(DefinitionsCollection $definitions = null)
    {
        $definitions = $definitions instanceof DefinitionsCollection ? $definitions : new DefinitionsCollection([]);
        $this->definitions = $definitions;
        $this->loadCache();
    }

    /**
     * @param array $action
     * @return string
     */
    public static function keyFromAction($action)
    {
        $module = isset($action['module']) ? $action['module'] : '';
        $controller = isset($action['controller']) ? $action['controller'] : '';
        return $module . '-' . $controller;
    }

    /**
     * @param array $action
     * @return mixed|null
     */
    public static function resolveFromAction($action)
    {
        $key = static::keyFromAction($action);
        return static::resolveFromKey($key);
    }

    /**
     * @param array $action
     * @param $class
     * @return mixed|null
     */
    public static function setFromAction($action, $class)
    {
        $resolver = static::instance();
        $key = static::keyFromAction($action);
        $resolver->definitions->set($key, $class);
    }

    /**
     * @param array $action
     * @param $class
     * @return mixed|null
     */
    public static function save()
    {
        $resolver = static::instance();
        FileManager::write($resolver->definitions);
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public static function resolveFromKey($key)
    {
        $resolver = static::instance();
        if ($resolver->definitions->has($key)) {
            return $resolver->definitions->get($key);
        }
        return null;
    }

    protected function loadCache()
    {
        if (FileManager::hasCacheFile()) {
            FileManager::read($this->definitions);
        }
    }
}
