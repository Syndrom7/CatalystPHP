<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;

/**
 * Email validation rule.
 *
 * Validates whether the value of a field is a valid email address.
 */
class EmailRule implements RuleInterface {
    
    /**
     * Validates whether the specified field contains a valid email address.
     */
    public function validate(array $data, string $field, array $params) : bool {
        return (bool) filter_var($data[$field], FILTER_VALIDATE_EMAIL);
    }

    /**
     * Provides an error message indicating that the field should contain a valid email address.
     */
    public function getMessage(array $data, string $field, array $params) : string {
        return "Enter a valid email address";
    }
}