<?php

declare (strict_types=1);

namespace App\Routes;

use Framework\App;
use App\Controllers\{HomeController, AuthController, ErrorController};
use App\Middleware\{AuthRequiredMiddleware, GuestOnlyMiddleware};

/**
 * Registers routes for the web application.
 *
 * This function defines the routes for the application, linking URL paths to controller actions.
 * It also associates middleware with routes.
 *
 * @param App $app The application instance.
 * @return void
 */
function registerRoutes(App $app) : void {
    $app->get("/", [HomeController::class, "home"]);
    $app->get("/register", [AuthController::class, "registerView"])->middleware(GuestOnlyMiddleware::class);
    $app->post("/register", [AuthController::class, "register"])->middleware(GuestOnlyMiddleware::class);
    $app->get("/login", [AuthController::class, "loginView"])->middleware(GuestOnlyMiddleware::class);
    $app->post("/login", [AuthController::class, "login"])->middleware(GuestOnlyMiddleware::class);
    $app->get("/logout", [AuthController::class, "logout"])->middleware(AuthRequiredMiddleware::class);


    $app->setErrorHandler([ErrorController::class, "notFound"]);
}