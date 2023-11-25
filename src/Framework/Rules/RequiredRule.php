<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;

/**
 * Required field validation rule.
 *
 * Validates whether a specified field in the data array is present and not empty.
 */
class RequiredRule implements RuleInterface {

    /**
     * Validates whether the specified field is present and not empty.
     */
    public function validate(array $data, string $field, array $params) : bool {
        return !empty($data[$field]);
    }

    /**
     * Provides an error message for a required field.
     */
    public function getMessage(array $data, string $field, array $params) : string {
        return "This field is required";
    }
}