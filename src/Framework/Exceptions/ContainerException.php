<?php

declare(strict_types=1);

namespace Framework\Exceptions;

use Exception;

/**
 * Exception class for container-related errors.
 *
 * This exception should be thrown when an error occurs within the dependency injection
 * container, such as when a service cannot be resolved.
 */
class ContainerException extends Exception {
    
}