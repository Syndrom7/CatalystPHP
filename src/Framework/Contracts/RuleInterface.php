<?php

declare(strict_types=1);

namespace Framework\Contracts;

interface RuleInterface {

    /**
     * Validates a specific field in the provided data array against defined parameters.
     *
     * Implementations should return true if the field value meets the specified validation rule,
     * and false otherwise.
     *
     * @param array $data The array of data containing the field to be validated.
     * @param string $field The name of the field to validate.
     * @param array $params Additional parameters that the validation rule may require.
     * @return bool Returns true if validation is successful, false otherwise.
     */
    public function validate(array $data, string $field, array $params) : bool;

    /**
     * Provides an error message for a specific field if the validation fails.
     *
     * The message should be relevant to the validation rule and parameters applied to the field.
     *
     * @param array $data The array of data containing the field that failed validation.
     * @param string $field The name of the field for which the error message is generated.
     * @param array $params Additional parameters that the validation rule may have used.
     * @return string The error message associated with the failed validation.
     */
    public function getMessage(array $data, string $field, array $params) : string;
}