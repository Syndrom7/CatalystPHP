<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;

/**
 * URL validation rule.
 *
 * Validates whether the specified field in the data array is a valid URL.
 */
class UrlRule implements RuleInterface {
    
    /**
     * Validates a URL.
     */
    public function validate(array $data, string $field, array $params) : bool {
        return (bool) filter_var($data[$field], FILTER_VALIDATE_URL);
    }

    /**
     * Provides an error message for invalid URLs.
     */
    public function getMessage(array $data, string $field, array $params) : string {
        return "Please provide a valid URL";
    }
}