<?php

namespace Nip\Dispatcher;

use Nip\Http\ServerMiddleware\Middlewares\ServerMiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class ActionDispatcherMiddleware
 * @package Nip\Dispatcher
 */
class ActionDispatcherMiddleware implements ServerMiddlewareInterface
{
    /**
     * The session manager.
     *
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * Create a new session middleware.
     *
     * @param  Dispatcher $dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @inheritdoc
     * @throws \Exception
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $delegate): ResponseInterface
    {
        return $this->getDispatcher()->dispatch($request);
    }

    /**
     * @return Dispatcher
     */
    protected function getDispatcher(): Dispatcher
    {
        return $this->dispatcher;
    }
}
