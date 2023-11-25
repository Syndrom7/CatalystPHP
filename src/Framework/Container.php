<?php

declare(strict_types=1);

namespace Framework;

use ReflectionClass, ReflectionNamedType;
use Framework\Exceptions\ContainerException;

/**
 * Dependency injection container.
 *
 * Manages object creation and dependencies, allowing for automatic dependency resolution
 * and simplifying the creation of complex objects.
 */
class Container {

    private array $definitions = [];
    private array $resolved = [];

    /**
     * Adds new service definitions to the container.
     *
     * @param array $newDefinitions An associative array of service definitions.
     */
    public function addDefinitions(array $newDefinitions) : void {
        $this->definitions = [...$this->definitions, ...$newDefinitions];
    }

    /**
     * Resolves and creates an instance of the given class name.
     *
     * @param string $className The fully qualified class name to resolve.
     * @return mixed An instance of the resolved class.
     * @throws ContainerException If the class is not instantiable or dependencies cannot be resolved.
     */
    public function resolve (string $className) : mixed {
        // Create a ReflectionClass instance for the specified class name
        $reflectionClass = new ReflectionClass($className);

        // Check if the class is instantiable (not abstract or an interface)
        if (!$reflectionClass->isInstantiable()) {
            throw new ContainerException("Class {$className} is not instantiable");
        }

        // Get constructor of the class
        $constructor = $reflectionClass->getConstructor();
        // If there's no constructor, instantiate the class without any parameters
        if (!$constructor) {
            return new $className;
        }

        // Get constructor parameters
        $params = $constructor->getParameters();
        // If there are no parameters, instantiate the class without any parameters
        if (count($params) === 0) {
            return new $className;
        }

        $dependencies = [];

        // Iterate through each parameter to resolve its dependency
        foreach ($params as $param) {
            $name = $param->getName();
            $type = $param->getType();

            // If the parameter doesn't have a type hint, throw an exception
            if (!$type) {
                throw new ContainerException("Failed to resolve class {$className} due to missing type hint");
            }

             // Check if the type is a class and not a built-in type
            if (!$type instanceof ReflectionNamedType || $type->isBuiltin()) {
                throw new ContainerException("Failed to resolve class {$className} due to invalid param name");
            }

            // Resolve the dependency and add it to the dependencies array
            $dependencies[] = $this->get($type->getName());
        }

        // Instantiate the class with resolved dependencies
        return $reflectionClass->newInstanceArgs($dependencies);
    }

    /**
     * Retrieves a service from the container.
     *
     * @param string $id The identifier of the service.
     * @return mixed The service instance.
     * @throws ContainerException If the service is not defined in the container.
     */
    public function get (string $id) : mixed {
        // Check if the service is defined in the container
        if (!array_key_exists($id, $this->definitions)) {
            throw new ContainerException("Class {$id} does not exist in container");
        }

        // Check if the service has already been resolved
        if (array_key_exists($id, $this->resolved)) {
            // Return the cached instance
            return $this->resolved[$id];
        }

        // Retrieve the factory callable for the service
        $factory = $this->definitions[$id];
        // Create the service instance using the factory
        $dependency = $factory($this);

        $this->resolved[$id] = $dependency;

        // Return the newly created service instance
        return $dependency;
    }
}