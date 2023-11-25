<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use Framework\Exceptions\CsrfException;

/**
 * Middleware for CSRF protection.
 *
 * Ensures that requests (POST, DELETE) are have a valid CSRF token.
 * This middleware is a security measure to prevent CSRF attacks.
 */
class CsrfGuardMiddleware implements MiddlewareInterface {
    
    /**
     * Middleware to check the validity of CSRF token.
     *
     * Verifies the presence and validity of the CSRF token for state-changing HTTP methods.
     * Allows the request to proceed if the token is valid, otherwise, throws a CsrfException.
     *
     * @param callable $next The next middleware.
     * @throws CsrfException If the CSRF token is missing or invalid.
     */
    public function process(callable $next)  {
        // Retrieve the request method from the server superglobal and convert to uppercase
        $requestMethod = strtoupper($_SERVER["REQUEST_METHOD"]);
        // HTTP methods that should be validated for CSRF tokens
        $validHttpMethods = ["POST", "DELETE"];

        // Continue without CSRF check for methods not in the validHttpMethods array
        if (!in_array($requestMethod, $validHttpMethods)) {
            $next();
            return;
        }

        // Check if the CSRF token in the session matches the one sent in the POST request
        if ($_SESSION["csrf_token"] !== $_POST["csrf_token"]) {
            // If they don't match or if the token is not set, throw a CSRF exception
            throw new CsrfException("Invalid CSRF token");
        }

        // Unset the CSRF token in the session after successful validation
        unset($_SESSION["csrf_token"]);

        // Continue to the next middleware
        $next(); 
    }

}