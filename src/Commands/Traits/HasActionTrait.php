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
        $this->guardActionAsArray();

        $this->action[$name] = $value;
    }

    /**
     * @param $name
     * @param $value
     * @return mixed
     * @throws \Exception
     */
    public function getActionParam($name)
    {
        $this->guardActionAsArray();

        return isset($this->action[$name]) ? $this->action[$name] : null;
    }

    /**
     * @throws \Exception
     */
    protected function guardActionAsArray()
    {
        if (!is_array($this->action) && $this->action !== null) {
            throw new \Exception(
                "Command Action is not an array, [" . print_r($this->action, true) . "]"
            );
        }
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
