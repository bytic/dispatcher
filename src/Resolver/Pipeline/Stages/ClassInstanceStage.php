<?php

namespace Nip\Dispatcher\Resolver\Pipeline\Stages;

use Nip\Controllers\Controller;
use Nip\Dispatcher\Exceptions\InvalidCommandException;

/**
 * Class ClassInstanceStage
 * @package Nip\Dispatcher\Resolver\Pipeline\Stages
 */
class ClassInstanceStage extends AbstractStage
{
    /**
     * @return void
     * @throws \Exception
     */
    public function processCommand()
    {
        if ($this->hasClassAction()) {
            $this->buildController();
        }
    }

    /**
     * @return bool
     */
    protected function hasClassAction()
    {
        return $this->getCommand()->hasActionParam('class');
    }

    /**
     * @throws \Exception
     */
    protected function buildController()
    {
        $controllerNames = $this->getCommand()->getActionParam('class');
        foreach ($controllerNames as $class) {
            if ($this->validController($class)) {
                $controller = $this->newController($class);
                $this->getCommand()->setActionParam('instance', $controller);
                return;
            }
        }
        throw new InvalidCommandException(
            "No valid controllers found for [" . print_r($controllerNames, true) . "]"
        );
    }

    /**
     * @param $class
     * @return bool
     */
    protected function validController($class)
    {
        return class_exists($class);
    }

    /**
     * @param string $class
     * @return Controller
     * @throws InvalidCommandException
     */
    public function newController($class)
    {
        $controller = new $class();
        return $controller;
    }
}
