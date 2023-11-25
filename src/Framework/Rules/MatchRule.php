<?php

declare(strict_types=1);

namespace Framework\Rules;

use InvalidArgumentException;
use Framework\Contracts\RuleInterface;

/**
 * Field match validation rule.
 *
 * Validates whether the value of a specified field matches the value of another field.
 */
class MatchRule implements RuleInterface {

    /**
     * Validates if the specified field matches another field.
     *
     * @param array $data The data array containing the fields to validate.
     * @param string $field The name of the field to validate.
     * @param array $params Parameters for validation, where the first element specifies the field to match against.
     * @return bool True if the values of both fields match, false otherwise.
     */
    public function validate(array $data, string $field, array $params) : bool {
        if (empty($params[0])) {
            throw new InvalidArgumentException("Field to match against not specified");
        }

        $fieldOne = $data[$field];
        $fieldTwo = $data[$params[0]];

        return $fieldOne === $fieldTwo;
    }

    /**
     * Provides an error message indicating that the fields do not match.
     */
    public function getMessage(array $data, string $field, array $params) : string {
        return  "The field {$field} does not match the {$params[0]} field";
    }
}