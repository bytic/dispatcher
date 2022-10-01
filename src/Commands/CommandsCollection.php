<?php
declare(strict_types=1);

namespace Nip\Dispatcher\Commands;

use ArrayAccess;
use Exception;
use Iterator;

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
     * @return bool
     */
    public function overflow()
    {
        return $this->getHops() > $this->getMaxHops();
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
     * @return int
     */
    public function getHops(): int
    {
        return $this->hops;
    }

    /**
     * @param int $hops
     */
    public function setHops(int $hops)
    {
        $this->hops = $hops;
    }

    /**
     * @inheritdoc
     */
    public function offsetExists($offset): bool
    {
        return isset($this->items[$offset]);
    }

    /**
     * @inheritdoc
     */
    public function offsetGet($offset): mixed
    {
        return $this->items[$offset];
    }

    /**
     * @inheritdoc
     * @param Command $value
     */
    public function offsetSet($offset, $value):void
    {
        if ($offset == null) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
        $this->hops = count($this->items);
        if ($this->overflow()) {
            throw new Exception(
                "Maximum number of hops ($this->maxHops) has been reached for {$value->getString()}"
            );
        }
    }

    /**
     * @inheritdoc
     */
    public function offsetUnset($offset): void
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
