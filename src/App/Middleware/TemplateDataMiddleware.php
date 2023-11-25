<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use Framework\TemplateEngine;
use App\Config\TemplateConfig;

/**
 * Middleware for injecting global template data.
 *
 * Sets global variables in the TemplateEngine, making them available across all views.
 */
class TemplateDataMiddleware implements MiddlewareInterface {
    
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
     * Middleware to pass global data to view templates
     *
     * Adds a default title (or any other global data defined in TemplateConfig) to the view.
     *
     * @param callable $next The next middleware.
     * @return void
     */
    public function process (callable $next) {
        // Add a global title to the template
        $this->view->addGlobal('title', TemplateConfig::TEMPLATE_NAME);
        
        // Proceed to the next middleware
        $next();
    }
}