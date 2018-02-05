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
        $action = [
            'module' => $this->formatModuleName($request->getModuleName()),
            'controller' => $this->formatControllerName($request->getControllerName()),
            'action' => $this->formatActionName($request->getActionName()),
        ];

        $this->getCommand()->setAction($action);
    }

    /**
     * @param string $name
     * @return mixed
     */
    protected function formatModuleName($name)
    {
        $name = $name ? $name : 'default';

        return inflector()->camelize($name);
    }

    /**
     * @param string $name
     * @return mixed
     */
    protected function formatControllerName($name)
    {
        $name = $name ? $name : 'index';

        return $this->getControllerName($name);
    }

    /**
     * @param $controller
     * @return mixed
     */
    protected function getControllerName($controller)
    {
        return inflector()->classify($controller);
    }

    /**
     * @param boolean $name
     * @return mixed
     */
    protected function formatActionName($name)
    {
        $name = inflector()->camelize($name);
        $name[0] = strtolower($name[0]);

        return $name;
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
