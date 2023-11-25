<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use Framework\Exceptions\SessionException;

/**
 * Middleware for session management.
 *
 * Initializes the session and sets cookie parameters.
 * Ensures that the session is not already started and that headers have not been sent before starting it.
 */
class SessionMiddleware implements MiddlewareInterface {
    
    /**
     * Initializes the session and sets session cookie parameters.
     *
     * Throws a SessionException if a session is already active or if headers have been sent.
     * After running the next middleware, it ensures that session data is saved and the session is closed.
     *
     * @param callable $next The next middleware to call if session checks pass.
     * @throws SessionException If a session is already active or headers have been sent.
     */
    public function process (callable $next) {
        // Check if a session is already active. If so, throw a SessionException.
        if (session_status() === PHP_SESSION_ACTIVE) {
            throw new SessionException("Session already active");
        }
        
        // Check if headers have already been sent. If so, throw a SessionException
        if (headers_sent($filename, $line)) {
            throw new SessionException("Headers already sent. Output buffering might be disabled");
        }

        // Set session cookie parameters. The parameters are set based on the environment.
        // 'secure' flag is set to true if the application is running in production.
        session_set_cookie_params([
            "secure" => $_ENV["APP_ENV"] === "production",
            "httponly" => true,
            "samesite" => "lax"
        ]);
        
        // Start the session.
        session_start();
        
        // Call the next middleware or request handler.
        $next();
        
        // After the response has been sent to the client, write and close the session.
        session_write_close();
    }
}