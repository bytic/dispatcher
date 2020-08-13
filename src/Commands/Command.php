<?php

namespace Nip\Dispatcher\Commands;

use Nip\Dispatcher\Commands\Traits\HasActionTrait;
//use Nip\Dispatcher\Commands\Traits\HasResponseTrait;
use Nip\Dispatcher\Traits\HasRequestTrait;

/**
 * Class ActionCall
 * @package Nip\Dispatcher\Resolver\Pipeline
 */
class Command
{
    use HasRequestTrait;
    use HasActionTrait;

    protected $return = null;

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

    /**
     * @return bool
     */
    public function hasReturn()
    {
        return $this->return !== null;
    }

    /**
     * @return null
     */
    public function getReturn()
    {
        return $this->return;
    }

    /**
     * @param null $return
     */
    public function setReturn($return)
    {
        $this->return = $return;
    }
}
