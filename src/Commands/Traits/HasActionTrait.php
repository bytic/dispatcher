<?php

namespace Nip\Dispatcher\Commands\Traits;

/**
 * Trait HasActionTrait
 * @package Nip\Dispatcher\Commands\Traits
 */
trait HasActionTrait
{
    protected $action = null;

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * @return bool
     */
    public function hasAction()
    {
        return $this->action !== null;
    }

    /**
     * @param $name
     * @param $value
     * @return void
     * @throws \Exception
     */
    public function setActionParam($name, $value)
    {
        if (is_array($this->action)) {
            $this->action[$name] = $value;
        }
        throw new \Exception("Command Action is not an array");
    }

    /**
     * @param $name
     * @param $value
     * @return mixed
     * @throws \Exception
     */
    public function getActionParam($name)
    {
        if (is_array($this->action)) {
            return $this->action[$name];
        }
        throw new \Exception("Command Action is not an array");
    }


    /**
     * @param $name
     * @return boolean
     */
    public function hasActionParam($name)
    {
        if (is_array($this->action)) {
            return isset($this->action[$name]);
        }
        return false;
    }
}
