<?php

declare(strict_types=1);

namespace Framework\Rules;

use InvalidArgumentException;
use Framework\Contracts\RuleInterface;

/**
 * Regular expression validation rule.
 *
 * Validates whether the value of a specified field in the data array matches a given regular expression.
 */
class RegexRule implements RuleInterface {

    /**
     * Validates if the specified field's value matches a regular expression.
     *
     * @param array $data The data array containing the field to validate.
     * @param string $field The name of the field to validate.
     * @param array $params Parameters for validation, where the first element is the regular expression.
     * @return bool True if the field's value matches the regular expression, false otherwise.
     */
    public function validate(array $data, string $field, array $params): bool {
        if (empty($params[0])) {
            throw new InvalidArgumentException("Regular expression not specified");
        }

        return preg_match($params[0], $data[$field] ?? '') === 1;
    }

    /**
     * Provides an error message indicating that the field does not match the required format.
     */
    public function getMessage(array $data, string $field, array $params): string {
        return "The field {$field} is not in the required format";
    }
}