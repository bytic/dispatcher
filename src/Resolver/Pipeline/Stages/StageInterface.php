<?php

namespace Nip\Dispatcher\Resolver\Pipeline\Stages;

use Nip\Dispatcher\Commands\Command;

/**
 * Interface StageInterface
 * @package Nip\Dispatcher\Resolver\Pipeline\Stages
 */
interface StageInterface
{
    /**
     * @param Command $methodCall
     * @return Command
     */
    public function __invoke(Command $methodCall): Command;
}
