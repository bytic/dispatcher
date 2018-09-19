<?php

namespace Nip\Dispatcher\Resolver\Cache;

/**
 * Class FileManager
 * @package Nip\Dispatcher\Resolver\Cache
 */
class FileManager
{
    /**
     * @param DefinitionsCollection $definitionCollection
     * @param null $path
     */
    public static function write($definitionCollection, $path = null)
    {
        $path = $path ? $path : static::filePath();
        $content = '<?php return ' . var_export($definitionCollection->all(), true) . ';';
        file_put_contents($path, $content);
    }

    /**
     * @param DefinitionsCollection $definitionCollection
     * @param null $path
     */
    public static function read($definitionCollection, $path = null)
    {
        $path = $path ? $path : static::filePath();
        /** @noinspection PhpIncludeInspection */
        $items = require $path;
        $definitionCollection->replace($items);
    }

    /**
     * @param null $path
     */
    public static function empty($path = null)
    {
        $path = $path ? $path : static::filePath();
        $content = '<?php return [];';
        file_put_contents($path, $content);
    }

    /**
     * @return bool
     */
    public static function hasCacheFile()
    {
        $path = static::filePath();
        return is_file($path);
    }

    /**
     * @return string
     */
    public static function filePath()
    {
        return static::filePathBase() . '/dispatcher.php';
    }

    /**
     * @return string
     */
    public static function filePathBase()
    {
        return function_exists('app')
            ? app('path.storage') . DIRECTORY_SEPARATOR . 'cache'
            : dirname(dirname(dirname(__DIR__))) . '/cache';
    }
}
