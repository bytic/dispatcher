<?php

namespace Nip\Dispatcher\Resolver\Pipeline\Stages;

use Closure;
use Nip\Http\Response\Response;

/**
 * Class ClosureStage
 * @package Nip\Dispatcher\Resolver\Pipeline\Stages
 */
class ClosureStage extends AbstractStage
{
    /**
     * @return void
     */
    public function processCommand()
    {
        if ($this->isClosure()) {
            $return = $this->runClosure();
            $this->getCommand()->setReturn($return);
        }
    }

    /**
     * @return bool
     */
    protected function isClosure()
    {
        return $this->getCommand()->getAction() instanceof Closure;
    }

    /**
     * Run the route action and return the response.
     *
     * @return mixed
     */
    protected function runClosure()
    {
        $closure = $this->getCommand()->getAction();
        return $closure(
            $this->getCommand()->getRequest(),
            new Response()
        );
    }
}
