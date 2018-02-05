<?php

namespace Nip\Dispatcher\Commands;

use Nip\Dispatcher\Exceptions\ForwardException;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class CommandFactory
 * @package Nip\Dispatcher\Commands
 */
class CommandFactory
{
    /**
     * @param ServerRequestInterface|null $request
     * @return Command
     */
    public static function createFromRequest(ServerRequestInterface $request = null): Command
    {
        $command = new Command();
        $command->setRequest($request);
        return $command;
    }

    /**
     * @param ForwardException $exception
     * @return Command
     */
    public static function createFromForwardExecption(ForwardException $exception)
    {
        $command = new Command();
        return $command;
    }
}
