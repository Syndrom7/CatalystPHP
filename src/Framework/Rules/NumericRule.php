<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;

/**
 * Numeric value validation rule.
 *
 * Validates whether the specified field in the data array contains a numeric value.
 */
class NumericRule implements RuleInterface {
    
    /**
     * Validates whether the specified field contains a numeric value.
     */
    public function validate(array $data, string $field, array $params) : bool {
        return is_numeric($data[$field]);
    }

    /**
     * Provides an error message indicating that only numeric values are allowed.
     */
    public function getMessage(array $data, string $field, array $params) : string {
        return "This field accepts must contain only numbers";
    }
}