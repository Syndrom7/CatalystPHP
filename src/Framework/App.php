<?php

declare(strict_types=1);

namespace Framework;


class App {

    private Router $router;
    private Container $container;

    /**
     * Constructs a new App instance.
     *
     * Initializes the Router and Container. Loads container definitions if a path is provided.
     *
     * @param string|null $containerDefinitionsPath Path to the file containing container definitions.
     */
    public function __construct(string $containerDefinitionsPath = null) {
        $this->router = new Router();
        $this->container = new Container();

        if ($containerDefinitionsPath) {
            $containerDefinitions = require $containerDefinitionsPath;
            $this->container->addDefinitions($containerDefinitions);
        }
    }

    /**
     * Runs the application by dispatching the router.
     *
     * Determines the request URI and method and dispatches the router to handle the request.
     */
    public function run () : void {
        $path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        $method = $_SERVER["REQUEST_METHOD"];
        
        $this->router->dispatch($path, $method, $this->container);
    }

    /**
     * Registers a GET route with the router.
     *
     * @param string $path The URI path for the route.
     * @param array $controller The controller and method to handle the route.
     * @return App Returns itself to enable method chaining.
     */
    public function get (string $path, array $controller) : App {
        $this->router->add("GET", $path, $controller);
        return $this;
    }

    /**
     * Registers a POST route with the router.
     *
     * @param string $path The URI path for the route.
     * @param array $controller The controller and method to handle the route.
     * @return App Returns itself to enable method chaining.
     */
    public function post (string $path, array $controller) : App {
        $this->router->add("POST", $path, $controller);
        return $this;
    }

    /**
     * Registers a DELETE route with the router.
     *
     * @param string $path The URI path for the route.
     * @param array $controller The controller and method to handle the route.
     * @return App Returns itself to enable method chaining.
     */
    public function delete (string $path, array $controller) : App {
        $this->router->add("DELETE", $path, $controller);
        return $this;
    }

    /**
     * Adds a middleware to the router.
     *
     * @param string $middleware The middleware class to be added.
     */
    public function addMiddleware (string $middleware) : void {
        $this->router->addMiddleware($middleware);
    }

    /**
     * Adds a route-specific middleware.
     *
     * @param string $middleware The middleware class to be added for routes.
     */
    public function middleware (string $middleware) {
        $this->router->addRouteMiddleware($middleware);
    }

    /**
     * Sets a custom error handler for the application.
     *
     * @param array $controller The controller and method to handle errors.
     * @return void
     */
    public function setErrorHandler (array $controller) {
        $this->router->setErrorHandler($controller);
    }
}