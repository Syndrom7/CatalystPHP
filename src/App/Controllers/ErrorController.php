<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;

/**
 * Controller for handling error 404 error.
 *
 * This controller is responsible for rendering 404 page
 */
class ErrorController {
    
    private TemplateEngine $view;

    /**
     * Constructs the ErrorController with TemplateEngine instance.
     *
     * @param TemplateEngine $view TThe template engine for rendering views.
     */
    public function __construct(TemplateEngine $view) {
        $this->view = $view;
    }

    /**
     * Renders the 404 Not Found page.
     *
     * @return void
     */
    public function notFound () : void {
        echo $this->view->render('misc/404');
    }
}