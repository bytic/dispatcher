<?php

namespace Nip\Dispatcher\Resolver\Pipeline\Stages;

use Nip\Dispatcher\Commands\Command;
use Nip\Controllers\Controller;
use Nip\Http\Request;
use Nip\Http\Request\PsrRequest;
use Psr\Http\Message\RequestInterface;

/**
 * Class AbstractStage
 * @package Nip\Dispatcher\Resolver\Pipeline\Stages
 */
abstract class AbstractStage implements StageInterface
{
    /**
     * @var Command
     */
    protected $command;

    /**
     * @param Command $methodCall
     * @return Command
     */
    public function __invoke(Command $command): Command
    {
        $this->setCommand($command);
        $this->processCommand();
        return $command;
    }

    /**
     * @return void
     */
    abstract public function processCommand();

    /**
     * @return Command
     */
    public function getCommand(): Command
    {
        return $this->command;
    }

    /**
     * @param Command $command
     */
    public function setCommand(Command $command)
    {
        $this->command = $command;
    }

    /**
     * @return bool
     */
    protected function hasClassAction()
    {
        return $this->getCommand()->hasActionParam('class');
    }

    /**
     * @return bool
     */
    protected function hasInstanceAction()
    {
        return $this->getCommand()->hasActionParam('instance');
    }

    protected function setControllerRequest($controller, $request)
    {
        if ($controller instanceof Controller && $request instanceof Request && !$request instanceof RequestInterface) {
            $request = new PsrRequest($request, false);
        }

        $controller->setRequest($request);
    }
}
