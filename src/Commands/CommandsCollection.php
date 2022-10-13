<?php
declare(strict_types=1);

namespace Nip\Dispatcher\Commands;

use ArrayAccess;
use Exception;
use Iterator;
use Nip\Collections\Traits\ArrayAccessTrait;
use Nip\Collections\Traits\SortingTrait;

/**
 * Class CommandsStack
 * @package Nip\Dispatcher\Commands
 */
class CommandsCollection implements ArrayAccess, Iterator
{
    use ArrayAccessTrait;
    use SortingTrait;

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
}
