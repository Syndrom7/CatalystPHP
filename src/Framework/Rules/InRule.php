<?php

declare(strict_types=1);

namespace Framework\Rules;

use InvalidArgumentException;
use Framework\Contracts\RuleInterface;

/**
 * Value in set validation rule.
 *
 * Validates whether the value of a specified field is within an allowed set of values.
 */
class InRule implements RuleInterface {
    
    /**
     * Validates if the specified field's value is in a given set of values.
     *
     * @param array $data The data array containing the field to validate.
     * @param string $field The name of the field to validate.
     * @param array $params An array of allowed values for the field.
     * @return bool True if the field's value is in the set, false otherwise.
     */
    public function validate(array $data, string $field, array $params) : bool {
        if (empty($params)) {
            throw new InvalidArgumentException("Allowed set of fields not specified");
        }
        return in_array($data[$field], $params);
    }

    /**
     * Provides an error message if the field's value is not in the allowed set.
     */
    public function getMessage(array $data, string $field, array $params) : string {
        $allowedValues = implode(', ', $params);
        return "The value must be one of the following values: {$allowedValues}";
    }
}