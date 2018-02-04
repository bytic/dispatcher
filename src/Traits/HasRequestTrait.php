<?php

namespace Nip\Dispatcher\Traits;

use Nip\Request;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Trait HasRequestTrait
 * @package Nip\Dispatcher\Traits
 */
trait HasRequestTrait
{

    /**
     * @var ServerRequestInterface|Request
     */
    protected $request = null;

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param Request|ServerRequestInterface $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function hasRequest()
    {
        return $this->request instanceof Request;
    }
}
