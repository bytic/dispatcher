<?php

namespace Nip\Dispatcher\Resolver\Pipeline\Stages;

use Nip\Controllers\Controller;
use Nip\Dispatcher\Exceptions\InvalidCommandException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

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

        $return = $this->invokeAction();
        $this->getCommand()->setReturn($return);
    }

    /**
     * @return ResponseInterface
     * @throws \Exception
     */
    protected function invokeAction()
    {
        /** @var Controller $controllerInstance */
        $controllerInstance = $this->getCommand()->getActionParam('instance');
        $controllerInstance->setRequest($this->getCommand()->getRequest());
        $method = $this->getCommand()->getActionParam('action');
        if (method_exists($controllerInstance, 'callAction')) {
            return $controllerInstance->callAction($method);
        }
        return $controllerInstance->{$method}();
    }
}
