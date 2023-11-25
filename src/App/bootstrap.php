<?php

/**
 * Application Bootstrap File.
 *
 * Initializes the application by setting up autoloading, loading environment variables,
 * and creating an instance of the application class with routes and middleware.
 */

declare(strict_types=1);

// Include the AutoLoader
require_once __DIR__ . '../../Framework/Utilities/Autoloader.php';

use Framework\App;
use App\Config\Paths;

require_once __DIR__ . '../../Framework/Utilities/DontenvLoader.php';
require_once __DIR__ . '/Routes/web.php';
require_once __DIR__ . '/Config/Middleware.php';

use function App\Routes\registerRoutes;
use function App\Config\registerMiddleware;
use function Framework\Utilities\loadEnv;

// Initialize env configuration
loadEnv();

// Create an instance of the App class
$app = new App(PATHS::SOURCE . '/App/container-definitions.php');

// Register application routes and middleware
registerRoutes($app);
registerMiddleware($app);

// Return the initialized application instance
return $app;