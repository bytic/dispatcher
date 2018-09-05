<?php

namespace Nip\Dispatcher\Resolver\Pipeline\Stages;

use Nip\Dispatcher\Resolver\Cache\ResolverCache;
use Nip\Dispatcher\Resolver\ClassResolver;

/**
 * Class ResolverCacheStage
 * @package Nip\Dispatcher\Resolver\Pipeline\Stages
 */
class ResolverCacheStage extends AbstractStage
{

    /**
     * @return void
     * @throws \Exception
     */
    public function processCommand()
    {
        if ($this->hasControllerName()) {
            $this->parseCacheForControllerDefinition();
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
    protected function parseCacheForControllerDefinition()
    {
        $action = $this->getCommand()->getAction();
        $class = ResolverCache::resolveFromAction($action);
        if ($class) {
            $instance = ClassResolver::newController($class);

            if ($instance) {
                $this->getCommand()->setActionParam('instance', $instance);
                return;
            }
        }
    }
}
