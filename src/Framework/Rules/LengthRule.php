<?php

declare(strict_types=1);

namespace Framework\Rules;

use InvalidArgumentException;
use Framework\Contracts\RuleInterface;

/**
 * Length validation rule.
 *
 * Validates whether the length of the value of a specified field
 * is within a specified range.
 */
class LengthRule implements RuleInterface {

    /**
     * Validates the length of a field's value.
     *
     * @param array $data The data array containing the field to validate.
     * @param string $field The name of the field to validate.
     * @param array $params Parameters for validation, specifying the minimum and maximum length.
     * @return bool True if the field's value length is within the specified range, false otherwise.
     */
    public function validate(array $data, string $field, array $params): bool {
        if (empty($params[0]) && empty($params[1])) {
            throw new InvalidArgumentException("Minimum and maximum lengths not specified");
        }
        
        $length = strlen($data[$field] ?? '');
        return $length >= $params[0] && $length <= $params[1];
    }

    /**
     * Provides an error message for length validation failure.
     *
     * @param array $data The data array containing the field that failed validation.
     * @param string $field The name of the field that failed validation.
     * @param array $params Parameters used in validation, specifying the minimum and maximum length.
     * @return string The error message.
     */
    public function getMessage(array $data, string $field, array $params): string {
        return "The value must be between {$params[0]} and {$params[1]} characters";
    }
}