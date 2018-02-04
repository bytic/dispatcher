<?php

namespace Nip\Dispatcher\Resolver\Pipeline\Stages;

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
        $action = $this->getCommand()->getAction();
        $controller = $this->newController($action['class']);
        $this->getCommand()->setActionParam('instance', $controller);
    }


    /**
     * @param string $class
     * @return Controller
     */
    public function newController($class)
    {
        $controller = new $class();
        return $controller;
    }
}
