<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;

/**
 * Alphanumeric validation rule.
 *
 * Validates whether the value of a specified field contains only alphanumeric characters.
 */
class AlphaNumericRule implements RuleInterface {
    
    /**
     * Validates if the specified field's value is alphanumeric.
     */
    public function validate(array $data, string $field, array $params): bool {
        return ctype_alnum($data[$field] ?? '');
    }

    /**
     * Provides an error message indicating that only alphanumeric characters are allowed.
     */
    public function getMessage(array $data, string $field, array $params): string {
        return "This field only accepts alphanumeric characters";
    }
}