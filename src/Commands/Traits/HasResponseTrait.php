<?php

namespace Nip\Dispatcher\Commands\Traits;

use Psr\Http\Message\ResponseInterface;

/**
 * Trait HasResponseTrait
 * @package Nip\Dispatcher\Commands\Traits
 */
trait HasResponseTrait
{
    /**
     * @var null|ResponseInterface
     */
    protected $response = null;

    /**
     * @return null|ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param ResponseInterface $response
     */
    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * @return bool
     */
    public function hasResponse()
    {
        return $this->response instanceof ResponseInterface;
    }
}
