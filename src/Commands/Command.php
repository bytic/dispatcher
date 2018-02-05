<?php

namespace Nip\Dispatcher\Commands;

use Nip\Dispatcher\Commands\Traits\HasActionTrait;
use Nip\Dispatcher\Commands\Traits\HasResponseTrait;
use Nip\Dispatcher\Traits\HasRequestTrait;

/**
 * Class ActionCall
 * @package Nip\Dispatcher\Resolver\Pipeline
 */
class Command
{
    use HasRequestTrait;
    use HasResponseTrait;
    use HasActionTrait;

    /**
     * @return string
     */
    public function getString()
    {
        if ($this->hasAction()) {
            return print_r($this->getAction(), true);
        }

        if ($this->hasRequest()) {
            return print_r($this->getRequest()->getMCA(), true);
        }

        return print_r($this, true);
    }
}
