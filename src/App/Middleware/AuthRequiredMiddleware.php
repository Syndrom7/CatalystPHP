<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;

/**
 * Middleware to enforce user authentication.
 *
 * Checks if a user session is present and redirects to the login page if not.
 * This middleware ensures that only authenticated users can access certain routes.
 */
class AuthRequiredMiddleware implements MiddlewareInterface {
    
    /**
     * Processes the middleware logic.
     *
     * Checks the session for user authentication and redirects to the login page if necessary.
     * Calls the next middleware if the user is authenticated.
     *
     * @param callable $next The next middleware to call if the user is authenticated.
     */
    public function process(callable $next)  {
        // Check if the user is not authenticated
        if (empty($_SESSION["user"])) {
            // Redirect to the login page
            redirectTo("/login");
            return;
        }
        // User is authenticated, proceed with the next middleware
        $next();
    }
}