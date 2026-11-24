<?php

namespace Nip\Dispatcher\Commands;

use Nip\Dispatcher\Exceptions\ForwardException;
use Nip\Http\Request;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class CommandFactory
 * @package Nip\Dispatcher\Commands
 */
class CommandFactory
{
    /**
     * @param $action
     * @return Command
     */
    public static function createFromAction($action): Command
    {
        $command = new Command();
        $command->setAction($action);
        return $command;
    }

    /**
     * @param Request|ServerRequestInterface $request
     * @return Command
     */
    public static function createFromRequest(Request|ServerRequestInterface $request): Command
    {
        $command = new Command();
        $command->setRequest($request);
        return $command;
    }

    /**
     * @param ForwardException $exception
     * @return Command
     */
    public static function createFromForwardException(ForwardException $exception)
    {
        $command = new Command();
        return $command;
    }
}
