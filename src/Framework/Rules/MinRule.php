<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;
use InvalidArgumentException;

/**
 * Minimum length validation rule.
 *
 * Validates whether the length of the value of the specified field is 
 * at a certain minimum.
 */
class MinRule implements RuleInterface {
    
    /**
     * Validates the minimum length of a field's value.
     *
     * @param array $data The data array containing the field to validate.
     * @param string $field The name of the field to validate.
     * @param array $params Parameters for validation, with the first element specifying the minimum length.
     * @return bool True if the field value meets the minimum length, otherwise false.
     * @throws InvalidArgumentException If the minimum length parameter is not specified.
     */
    public function validate(array $data, string $field, array $params) : bool {
        if (empty($params[0])) {
            throw new InvalidArgumentException("Minimum length not specified");
        }

        $length = (int) $params[0];
        return strlen($data[$field]) >= $length;
    }

    /**
     * Provides an error message for minimum length validation failure.
     */
    public function getMessage(array $data, string $field, array $params) : string {
        return "Must be at least {$params[0]} characters";
    }
}