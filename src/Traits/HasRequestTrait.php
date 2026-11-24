<?php

namespace Nip\Dispatcher\Traits;

use Nip\Http\Request\RequestAwareTrait;
use Nip\Http\Request;
use Psr\Http\Message\RequestInterface;

/**
 * Trait HasRequestTrait
 * @package Nip\Dispatcher\Traits
 */
trait HasRequestTrait
{
    use RequestAwareTrait;

    /**
     * Accept both the legacy PSR request and the newer ByTIC Symfony request.
     *
     * @return $this
     */
    public function setRequest(Request|RequestInterface $request)
    {
        $this->request = $request;

        return $this;
    }

    public function hasRequest()
    {
        return $this->request instanceof Request || $this->request instanceof RequestInterface;
    }
}
