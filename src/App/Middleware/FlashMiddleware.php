<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use Framework\TemplateEngine;


/**
 * Middleware for handling flash messages.
 *
 * Retrieves flash data like errors and old form data from the session and makes them
 * available to the templates. After the data is passed to the view, it's removed from the session.
 */
class FlashMiddleware implements MiddlewareInterface {
    
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
     * Processes the incoming request by handling flash data.
     *
     * Retrieves flash data from the session and adds it as global variables to the view.
     * Once the data is transferred to the view, it's removed from the session.
     *
     * @param callable $next The next middleware.
     */
    public function process(callable $next) {
        // Retrieve 'errors' from the session and make it globally available to the views
        $this->view->addGlobal("errors", $_SESSION["errors"] ?? []);
        // Remove 'errors' from the session after passing it to the view
        unset($_SESSION["errors"]);

        // Retrieve 'oldFormData' from the session and make it globally available to the views
        $this->view->addGlobal("oldFormData", $_SESSION["oldFormData"] ?? []);
        // Remove 'oldFormData' from the session after passing it to the view
        unset($_SESSION["oldFormData"]);
        
        // Proceed to the next middleware
        $next();
    }
}