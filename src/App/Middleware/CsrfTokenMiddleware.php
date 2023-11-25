<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use Framework\TemplateEngine;

/**
 * Middleware for CSRF token generation and injection.
 *
 * Generates a CSRF token if one does not already exist in the session, 
 * then makes it globally available to all views for form protection.
 */
class CsrfTokenMiddleware implements MiddlewareInterface {
    
    private TemplateEngine $view;

    /**
     * Constructs the middleware with a TemplateEngine instance.
     *
     * @param TemplateEngine $view The template engine used to add global variables.
     */
    public function __construct (TemplateEngine $view) {
        $this->view = $view;
    }
    
    /**
     * Middleware to generate CSRF token
     *
     * Generates a new CSRF token if one doesn't exist, adds it to the session,
     * and makes it available as a global variable in the view template engine.
     *
     * @param callable $next The next middleware.
     */
    public function process(callable $next) {
        // Check if a CSRF token is already set in the session, if not, generate a new one
        $_SESSION["csrf_token"] = $_SESSION["csrf_token"] ?? bin2hex(random_bytes(32));
        
        // Add the CSRF token as a global variable to the template engine, 
        // making it available to all templates
        $this->view->addGlobal("csrfToken", $_SESSION["csrf_token"]);

        // Proceed to the next middleware
        $next();
    }

}