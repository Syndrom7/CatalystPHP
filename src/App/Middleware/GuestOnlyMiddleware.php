<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;

/**
 * Middleware to restrict access to only authenticated users.
 *
 * Redirects authenticated users to the home page to prevent access to,
 * login or register page.
 */
class GuestOnlyMiddleware implements MiddlewareInterface {

    /**
     * Process an incoming server request.
     *
     * Redirects authenticated users to the home page and allows further processing
     * for guests by calling the next middleware in the sequence.
     *
     * @param callable $next The next middleware to call if the user is a guest.
     */
    public function process(callable $next) {
        // Check if there is an active user session
        if (!empty($_SESSION["user"])) {
            // Redirect to the home page if the user is already authenticated
            redirectTo("/");
        }
        
        // Continue to the next middleware if the user is not authenticated
        $next();
    }
}