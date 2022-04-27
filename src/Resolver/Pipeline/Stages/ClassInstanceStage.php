<?php
declare(strict_types=1);

namespace Nip\Dispatcher\Resolver\Pipeline\Stages;

use Nip\Dispatcher\Exceptions\InvalidCommandException;
use Nip\Dispatcher\Resolver\Cache\ResolverCache;
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
        if (!$this->hasInstanceAction() && $this->hasClassAction()) {
            $this->buildController();
        }
    }

    /**
     * @throws \Exception
     */
    protected function buildController()
    {
        $controllerNames = $this->getCommand()->getActionParam('class');
        $controller = ClassResolver::resolveFromClasses($controllerNames);

        if ($controller) {
            ResolverCache::setFromAction($this->getCommand()->getAction(), get_class($controller));
            ResolverCache::save();
            $this->getCommand()->setActionParam('instance', $controller);
            return;
        }

        throw new InvalidCommandException(
            "No valid controllers found for [" . print_r($controllerNames, true) . "]"
        );
    }
}
