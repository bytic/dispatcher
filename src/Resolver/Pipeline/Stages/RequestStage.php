<?php

namespace Nip\Dispatcher\Resolver\Pipeline\Stages;

use Nip\Dispatcher\Resolver\ClassResolver\NameFormatter;

/**
 * Class ClosureStage
 * @package Nip\Dispatcher\Resolver\Pipeline\Stages
 */
class RequestStage extends AbstractStage
{
    /**
     * @return void
     */
    public function processCommand()
    {
        if (!$this->getCommand()->hasAction() && $this->hasRequestMCA()) {
            $this->saveRequestParamsInCommand();
        }
    }

    protected function saveRequestParamsInCommand()
    {
        $request = $this->getRequest();

        $action = [
            'module' => $request->getModuleName(),
            'controller' => $request->getControllerName(),
            'action' => $request->getActionName()
        ];

        $this->getCommand()->setAction($action);
    }

    /**
     * @return bool
     */
    protected function hasRequestMCA()
    {
        return $this->getCommand()->hasRequest() && $this->getRequest()->getControllerName() !== null;
    }

    /**
     * @return \Nip\Request
     */
    protected function getRequest()
    {
        return $this->getCommand()->getRequest();
    }
}
