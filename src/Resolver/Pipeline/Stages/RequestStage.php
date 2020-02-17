<?php

namespace Nip\Dispatcher\Resolver\Pipeline\Stages;

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

        $this->getCommand()->setActionParam('module', $request->getModuleName());
        $this->getCommand()->setActionParam('controller', $request->getControllerName());
        $this->getCommand()->setActionParam('action', $request->getActionName());
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
