<?php

namespace Nip\Dispatcher\Resolver\Pipeline\Stages;

use Nip\Dispatcher\Resolver\ClassResolver\NameGenerator;

/**
 * Class ModuleControllerStage
 * @package Nip\Dispatcher\Resolver\Pipeline\Stages
 */
class ModuleControllerStage extends AbstractStage
{

    /**
     * @return void
     * @throws \Exception
     */
    public function processCommand()
    {
        if (!$this->hasInstanceAction() && $this->hasControllerName()) {
            $this->parseActionForController();
        }
    }

    /**
     * @return bool
     */
    public function hasControllerName()
    {
        $action = $this->getCommand()->getAction();
        if (is_array($action) && isset($action['controller'])) {
            return true;
        }
        return false;
    }

    /**
     * @throws \Exception
     */
    public function parseActionForController()
    {
        $action = $this->getCommand()->getAction();
        $module = isset($action['module']) ? $action['module'] : '';
        $controller = isset($action['controller']) ? $action['controller'] : '';

        if (class_exists($controller)) {
            $this->getCommand()->setActionParam('class', [$controller]);
            return;
        }

        $classes = NameGenerator::generateClasses($module, $controller);
        $this->saveClassesInAction($classes);
    }

    /**
     * @param $classes
     * @throws \Exception
     */
    protected function saveClassesInAction($classes)
    {
        $class = $this->prepareClassAction($this->getCommand()->getActionParam('class'));
        $class = array_merge($class, $classes);
        $this->getCommand()->setActionParam('class', $class);
    }

    /**
     * @param $class
     * @return array|null
     */
    protected function prepareClassAction($class)
    {
        $class = $class != null ? $class : [];
        $class = is_array($class) ? $class : [$class];
        return $class;
    }
}
