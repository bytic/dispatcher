<?php
declare(strict_types=1);

namespace Nip\Dispatcher\Configuration;

/**
 * Class Configuration
 * @package Nip\Records\Locator
 */
class Configuration
{
    protected array $namespaces;

    /**
     */
    public function __construct()
    {
        if (function_exists('app') && app()->has('app')) {
            $this->namespaces[] = app('app')->getRootNamespace();
        } else {
            $this->namespaces[] = '';
        }
    }


    /**
     * @param $namespace
     */
    public function prependNamespace($namespace)
    {
        array_unshift($this->namespaces, $namespace);
    }

    /**
     * @param $namespace
     */
    public function addNamespace($namespace)
    {
        $this->namespaces[] = $namespace;
    }

    /**
     * @return array
     */
    public function getNamespaces(): array
    {
        return $this->namespaces;
    }

    /**
     * @return bool
     */
    public function hasNamespaces()
    {
        return count($this->namespaces) > 0;
    }

    /**
     * @param array $namespaces
     */
    public function setNamespaces(array $namespaces): void
    {
        $this->namespaces = $namespaces;
    }
}
