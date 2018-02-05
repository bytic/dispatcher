<?php

namespace Nip\Dispatcher\Traits;

use Nip\Dispatcher\Commands\CommandsCollection;

/**
 * Trait HasCommandsCollection
 * @package Nip\Dispatcher\Traits
 */
trait HasCommandsCollection
{
    protected $commandsCollection = null;

    /**
     * @return mixed
     */
    public function getCommandsCollection()
    {
        if ($this->commandsCollection === null) {
            $this->initCommandsCollection();
        }
        return $this->commandsCollection;
    }

    /**
     * @param mixed $commandsCollection
     */
    public function setCommandsCollection($commandsCollection)
    {
        $this->commandsCollection = $commandsCollection;
    }

    protected function initCommandsCollection()
    {
        $this->setCommandsCollection($this->newCommandsCollection());
    }

    /**
     * @return CommandsCollection
     */
    protected function newCommandsCollection()
    {
        return new CommandsCollection();
    }
}
