<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;
use InvalidArgumentException;

/**
 * Maximum length validation rule.
 *
 * Validates whether the length of the value of the specified field
 * does not exceed a certain maximum.
 */
class MaxRule implements RuleInterface {
    
    /**
     * Validates the maximum length of a field's value.
     *
     * @param array $data The data array containing the field to validate.
     * @param string $field The name of the field to validate.
     * @param array $params Parameters for validation, with the first element specifying the maximum length.
     * @return bool True if the field value does not exceed the maximum length, false otherwise.
     * @throws InvalidArgumentException If the maximum length parameter is not specified.
     */
    public function validate(array $data, string $field, array $params) : bool {
        if (empty($params[0])) {
            throw new InvalidArgumentException("Max length not specified");
        }

        $length = (int) $params[0];
        return strlen($data[$field]) < $length;
    }

    /**
     * Provides an error message for maximum length validation failure.
     */
    public function getMessage(array $data, string $field, array $params) : string {
        return "Exceeds max character limit of {$params[0]}";
    }
}