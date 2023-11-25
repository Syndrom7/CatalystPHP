<?php

/**
 * Dependency Injection Container Configuration.
 *
 * Defines how to instantiate and configure various services and components of the application.
 */

declare(strict_types=1);

use Framework\{TemplateEngine, Database, Container};
use App\Config\Paths;
use App\Services\{ValidatorService, UserService};


return [
    // Template engine instance
    TemplateEngine::class => fn() => new TemplateEngine(Paths::VIEW),

    // Validator service instance
    ValidatorService::class => fn() => new ValidatorService(),

    // Database connection instance
    Database::class => fn () => new Database($_ENV["DB_DRIVER"], [
        "host"   =>   $_ENV["DB_HOST"], 
        "port"   =>   $_ENV["DB_PORT"], 
        "dbname" =>   $_ENV["DB_NAME"] 
    ], $_ENV["DB_USER"], $_ENV["DB_PASS"]),

    // User service instance, with database dependency
    UserService::class => function (Container $container) {
        $db = $container->get(Database::class);
        return new UserService($db);
    }
];