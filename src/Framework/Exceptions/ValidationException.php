<?php

declare(strict_types=1);

namespace Framework\Exceptions;

use RuntimeException;

/**
 * Exception for handling validation errors.
 *
 * This exception should be thrown when validation of input data fails. It contains an array of
 * validation error messages which can be displayed to the user.
 */
class ValidationException extends RuntimeException {

    /**
     * Constructs a new ValidationException.
     *
     * @param array $errors An associative array containing validation error messages.
     * @param int $code The HTTP status code to be used for this exception (default is 422).
     */
    public function __construct (public array $errors, int $code = 422) {
        parent::__construct(code: $code);
    }
}