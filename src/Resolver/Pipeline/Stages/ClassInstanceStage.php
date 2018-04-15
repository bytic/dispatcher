<?php

namespace Nip\Dispatcher\Resolver\Pipeline\Stages;

use Nip\Controllers\Controller;
use Nip\Dispatcher\Exceptions\InvalidCommandException;
use Nip\Dispatcher\Resolver\ClassResolver;

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
        $controller = ClassResolver::resolveFromClasses($controllerNames);

        if ($controller) {
            $this->getCommand()->setActionParam('instance', $controller);
            return;
        }

        throw new InvalidCommandException(
            "No valid controllers found for [" . print_r($controllerNames, true) . "]"
        );
    }
}
