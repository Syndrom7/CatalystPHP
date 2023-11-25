<?php

declare(strict_types=1);

namespace App\Config;

use Framework\App;
use App\Middleware\{CsrfGuardMiddleware, CsrfTokenMiddleware, FlashMiddleware, SessionMiddleware, TemplateDataMiddleware, ValidationExceptionMiddleware};

/**
 * Registers global middleware for the application.
 *
 * Adds middleware classes to the application's middleware stack.
 * These middleware are executed for every request processed by the application.
 *
 * @param App $app The application instance.
 * @return void
 */
function registerMiddleware (App $app) : void {
    // Register CSRF protection middleware
    $app->addMiddleware(CsrfGuardMiddleware::class);
    $app->addMiddleware(CsrfTokenMiddleware::class);

    // Register middleware for global template data
    $app->addMiddleware(TemplateDataMiddleware::class);
    // Register middleware for handling validation exceptions
    $app->addMiddleware(ValidationExceptionMiddleware::class);
    // Register middleware for flashing messaging 
    $app->addMiddleware(FlashMiddleware::class);
    // Register middleware for session management 
    $app->addMiddleware(SessionMiddleware::class);
}