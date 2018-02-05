<?php

namespace Nip\Dispatcher\Resolver\Pipeline\Stages;

use Nip\Dispatcher\Exceptions\InvalidCommandException;

/**
 * Class ClassInstanceStage
 * @package Nip\Dispatcher\Resolver\Pipeline\Stages
 */
class ActionCallStage extends AbstractStage
{
    /**
     * @return void
     * @throws \Exception
     */
    public function processCommand()
    {
        if (!$this->hasInstanceAction()) {
            throw new InvalidCommandException(
                "No valid instance for callback in dispatcher command " .
                "[" . print_r($this->getCommand(), true) . "]"
            );
        }
        $this->invokeAction();
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    protected function invokeAction()
    {
        $controllerInstance = $this->getCommand()->getActionParam('instance');
        $method = $this->getCommand()->getActionParam('action');
        if (method_exists($controllerInstance, 'callAction')) {
            return $controllerInstance->callAction($method);
        }
        return $controllerInstance->{$method}();
    }

    /**
     * @return bool
     */
    protected function hasInstanceAction()
    {
        return $this->getCommand()->hasActionParam('instance');
    }
}