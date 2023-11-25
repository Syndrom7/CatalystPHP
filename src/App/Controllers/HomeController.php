<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;

/**
 * Controller for the home page.
 *
 * This controller is responsible for rendering the home page.
 */
class HomeController {
    
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
     * Renders the home page.
     *
     * @return void
     */
    public function home () : void {
        echo $this->view->render('index', [
            'title' => 'Home'
        ]);
    }
}