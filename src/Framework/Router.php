<?php

declare(strict_types=1);

namespace Framework;

/**
 * Router class for managing application routes.
 * 
 * This class is responsible for defining application routes, and including its 
 * controllers, and managing request dispatching. It also responsible for the integration 
 * of middlewares for request processing and error handling.
 */
class Router {
    private array $routes = [];
    private array $middlewares = [];
    private array $errorHandler;

    /**
     * Adds a new route to the router.
     *
     * Registers a route with a specific HTTP method, path, and related controllers.
     * 
     * @param string $method The HTTP method (GET, POST, DELETE).
     * @param string $path The URL path for the route.
     * @param array $controller The controller and method to handle the route.
     * @return void
     */
    public function add(string $method, string $path, array $controller) : void {
        // Normalize the provided URL path
        $path = $this->normalizePath($path);

        $regexPath = preg_replace("#{[^/]+}#","([^/]+)", $path);

        // Store the route information, including the HTTP method, path, controller, and the regex path
        $this->routes[] = [
            "path" => $path,
            "method" => strtoupper($method),
            "controller" => $controller,
            "middlewares" => [],
            "regexPath" => $regexPath
        ];
    }

    /**
     * Normalizes a URL path.
     *
     * Trims trailing slashes, adds a leading slash, and reduces multiple slashes into one.
     *
     * @param string $path The URL path to normalize.
     * @return string The normalized path.
     */
    public function normalizePath(string $path) : string {
        $path = trim($path, "/");
        $path = "/{$path}/";
        $path = preg_replace("#[/]{2,}#", "/", $path);

        return $path;
    }

    /**
     * Dispatches a request to the appropriate route based on the path and method.
     * 
     * Iterates through registered routes and matches them against the provided path and method.
     * If a match is found, the related controller action is executed, along with its middleware.
     *
     * @param string $path The URL path of the request.
     * @param string $method The HTTP method of the request.
     * @param Container|null $container The dependency injection container.
     * @return void
     */
    public function dispatch (string $path, string $method, Container $container = null) : void {
        // Normalize the provided path and get the method custom method. (e.g., DELETE method)
        $path = $this->normalizePath($path);
        $method = strtoupper($_POST["_METHOD"] ?? $method);

        // Iterate through all registered routes
        foreach ($this->routes as $route) {
            // If the path and method don't match, continue to the next route
            if (!preg_match("#^{$route["regexPath"]}$#", $path, $paramValues) || $route["method"] !== $method) {
                continue;
            }
            
            // Extract parameters from the URL
            array_shift($paramValues);
            preg_match_all("#{([^/]+)}#", $route["path"], $paramKeys);
            $paramsKeys = $paramKeys[1];
            $params = array_combine($paramsKeys, $paramValues);

            // Extract the controller class and method names from the route
            [$class, $function] = $route["controller"];
            // Instantiate the controller: Use the container for dependency injection if available otherwise, create a new instance
            $controllerInstance = $container ? $container->resolve($class) : new $class();
            // Define the action as a callable function. The action is the controller method that will be executed.
            // The $params array contains any params extracted from the URL.
            $action = fn() => $controllerInstance->{$function}($params);
            
            // Combine all applicable middlewares for the route including both route specific and global middlewares.
            $allMiddleware = [...$route["middlewares"], ...$this->middlewares];
            // Apply each middleware to the action
            foreach ($allMiddleware as $middleware) {
                // Instantiate the middleware: Use the container for dependency injection if available otherwise, create a new instance
                $middlewareInstance = $container ? $container->resolve($middleware) : new $middleware;
                // Wrap the current action within the middleware process.
                // Each middleware's process method takes the next action as a parameter.
                $action = fn () => $middlewareInstance->process($action);
            }

            // Execute the last action, which includes all middlewares
            $action();
            
            // End the dispatch function after successfully handling the route.
            return;
        }

        // If no route matches, dispatch the not found method
        $this->dispatchNotFound($container);
    }

    /**
     * Adds a global middleware to the router.
     *
     * @param string $middleware The middleware class to add.
     * @return void
     */
    public function addMiddleware (string $middleware) : void {
        $this->middlewares[] = $middleware;
    }

    /**
     * Adds a route-specific middleware.
     *
     * Route specific middlewares are executed only for the route they are attached to.
     *
     * @param string $middleware The middleware class to add.
     * @return void
     */
    public function addRouteMiddleware(string $middleware) : void {
        // Get the key of the last added route in the router's routes array.
        $lastRouteKey = array_key_last($this->routes);
        
        // Append the middleware to the middleware stack of the last defined route.
        // This ensures that the middleware is specific to this route only.
        $this->routes[$lastRouteKey]["middlewares"][] = $middleware;
    }

    /**
     * Sets the error handler controller for the router.
     *
     * @param array $controller The controller and method to handle errors.
     * @return void
     */
    public function setErrorHandler (array $controller) : void {
        // Set the error handler with the provided controller action
        $this->errorHandler = $controller;
    }

    /**
     * Dispatches a 404 error if no route matches.
     *
     * This method is called when no matching route is found in the dispatch process.
     *
     * @param Container|null $container The dependency injection container.
     * @return void
     */
    public function dispatchNotFound (null|Container $container) : void {
        // Extract the controller class and method from the error handler.
        [$class, $function] = $this->errorHandler;
        // Instantiate the error handler controller using the container for dependency injection if available otherwise, create a new instance
        $controllerInstance =  $container ? $container->resolve($class) : new $class;
        // Define the error handling action as a callable function.
        $action = fn () => $controllerInstance->$function();

        // Apply global middlewares to the error handling action.
        foreach ($this->middlewares as $middleware) {
            // Instantiate the middleware: Use the container for dependency injection if available otherwise, create a new instance
            $middlewareInstance = $container ? $container->resolve($middleware) : new $class;
            // Wrap the current action within the middleware process.
            // Each middleware's process method takes the next action as a parameter.
            $action = fn () => $middlewareInstance->process($action);
        }
        
        // Execute the last action, which includes all middlewares
        $action();
    }
}