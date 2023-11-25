<?php

declare(strict_types=1);

namespace Framework\Contracts;

interface MiddlewareInterface {

    /**
     * Processes an incoming request and returns a response.
     *
     * The method receives a callable that represents the next middleware in the queue.
     * Implementing middleware classes should call this callable to
     * pass the request further down the middleware stack.
     *
     * @param callable $next The next middleware or handler in the queue.
     */
    public function process (callable $next);
}