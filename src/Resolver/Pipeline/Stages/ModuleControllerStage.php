<?php

namespace Nip\Dispatcher\Resolver\Pipeline\Stages;

/**
 * Class ModuleControllerStage
 * @package Nip\Dispatcher\Resolver\Pipeline\Stages
 */
class ModuleControllerStage extends AbstractStage
{

    /**
     * @return void
     */
    public function processCommand()
    {
        if ($this->hasControllerName()) {
            $this->saveActionParamsInCommand();
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
     */
    public function saveActionParamsInCommand()
    {
        $action = $this->getCommand()->getAction();
        $module = isset($action['module']) ? $action['module'] : '';
        $controller = isset($action['controller']) ? $action['controller'] : '';

        $namespaceClass = $this->generateFullControllerNameNamespace($module, $controller);
        if ($this->isValidControllerNamespace($namespaceClass)) {
            $action['class'] = $namespaceClass;
        } else {
            $classicClass = $this->generateFullControllerNameString($module, $controller);
            if (class_exists($classicClass)) {
                $action['class'] = $classicClass;
            }
        }
        $this->getCommand()->setAction($action);
    }


    /**
     * @param $module
     * @param $controller
     * @return string
     */
    protected function generateFullControllerNameNamespace($module, $controller)
    {
        $name = $this->generateModuleNameNamespace($module);
        $name .= '\Controllers\\';
        $name .= $this->formatControllerName($controller);

        return $name;
    }

    /**
     * @param $module
     * @return string
     */
    protected function generateModuleNameNamespace($module)
    {
        $name = $this->getRootNamespace() . 'Modules\\';
        $module = $module == 'Default' ? 'Frontend' : $module;
        $name .= $module;
        return $name;
    }

    /**
     * @param string $name
     * @return mixed
     */
    protected function formatControllerName($name)
    {
        $name = str_replace('_', '\\', $name) . "Controller";

        return $name;
    }

    /**
     * @param string $namespaceClass
     * @return bool
     */
    protected function isValidControllerNamespace($namespaceClass)
    {
        return class_exists($namespaceClass);
    }

    /**
     * @return string
     */
    protected function getRootNamespace()
    {
        if (function_exists('app')) {
            return app('app')->getRootNamespace();
        }
        return '';
    }

    /**
     * @param $module
     * @param $controller
     * @return string
     */
    protected function generateFullControllerNameString($module, $controller)
    {
        return $module . "_" . $controller . "Controller";
    }
}
