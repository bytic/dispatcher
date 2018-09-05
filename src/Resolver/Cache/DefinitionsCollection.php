<?php

namespace Nip\Dispatcher\Resolver\Cache;

/**
 * Class DefinitionsCollection
 * @package Nip\Dispatcher\Resolver\Cache
 */
class DefinitionsCollection
{
    protected $items = [];

    /**
     * DefinitionsCollection constructor.
     * @param array $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * @param $items
     * @return array
     */
    public function replace($items)
    {
        return $this->items = $items + $this->items;
    }

    /**
     * @param $offset
     * @return bool
     */
    public function has($offset)
    {
        return $this->offsetExists($offset);
    }

    /**
     * @param $offset
     * @return mixed
     */
    public function get($offset)
    {
        return $this->offsetGet($offset);
    }

    /**
     * @param $offset
     * @param $value
     * @return mixed
     */
    public function set($offset, $value)
    {
        $this->offsetSet($offset, $value);
    }

    /**
     * @inheritdoc
     */
    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }

    /**
     * @inheritdoc
     */
    public function offsetGet($offset)
    {
        return $this->items[$offset];
    }

    /**
     * @inheritdoc
     * @param string $value
     */
    public function offsetSet($offset, $value)
    {
        if ($offset == null) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }
}
