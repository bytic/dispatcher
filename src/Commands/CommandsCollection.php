<?php

namespace Nip\Dispatcher\Commands;

use ArrayAccess;
use Iterator;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class CommandsStack
 * @package Nip\Dispatcher\Commands
 */
class CommandsCollection implements ArrayAccess, Iterator
{
    protected $items = [];

    protected $hops = 0;

    protected $maxHops = 30;

    /**
     * @param ServerRequestInterface|null $request
     */
    public function addFromRequest(ServerRequestInterface $request = null)
    {
        $command = CommandFactory::createFromRequest($request);
        $this->items[] = $command;
    }

    /**
     * @return int
     */
    public function getMaxHops(): int
    {
        return $this->maxHops;
    }

    /**
     * @param int $maxHops
     */
    public function setMaxHops(int $maxHops)
    {
        $this->maxHops = $maxHops;
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
     */
    public function offsetSet($offset, $value)
    {
        $this->items[$offset] = $value;
        $this->hops = count($this);
    }

    /**
     * @inheritdoc
     */
    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
        $this->hops = count($this);
    }

    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        // TODO: Implement current() method.
    }

    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        // TODO: Implement next() method.
    }

    /**
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        // TODO: Implement key() method.
    }

    /**
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        // TODO: Implement valid() method.
    }

    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        // TODO: Implement rewind() method.
    }
}
