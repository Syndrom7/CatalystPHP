<?php

declare(strict_types=1);

namespace Framework\Rules;

use InvalidArgumentException;
use Framework\Contracts\RuleInterface;

/**
 * Date format validation rule.
 *
 * Validates whether the value of a specified field in the data array matches a specific date format.
 */
class DateFormatRule implements RuleInterface {
    
    /**
     * Validates if the specified field's value matches the given date format.
     *
     * @param array $data The data array containing the field to validate.
     * @param string $field The name of the field to validate.
     * @param array $params Parameters for validation, where the first element is the expected date format.
     * @return bool True if the field's value matches the date format, false otherwise.
     */
    public function validate(array $data, string $field, array $params) : bool {
        if (empty($params[0])) {
            throw new InvalidArgumentException("Date format not specified");
        }

        $parsedDate = date_parse_from_format($params[0], $data[$field]);
        return $parsedDate["error_count"] === 0 && $parsedDate["warning_count"] == 0;
    }

    /**
     * Provides an error message indicating an invalid date format.
     *
     * @param array $data The data array containing the field that failed validation.
     * @param string $field The name of the field that failed validation.
     * @param array $params Parameters used in validation, where the first element is the expected date format.
     * @return string The error message.
     */
    public function getMessage(array $data, string $field, array $params) : string {
        return "Must be a valid date in the format {$params[0]}";
    }
}