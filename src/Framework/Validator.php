<?php

declare(strict_types=1);

namespace Framework;

use Framework\Contracts\RuleInterface;
use Framework\Exceptions\ValidationException;

/**
 * Validator class for handling form validation.
 *
 * This class manages the addition and execution of validation rules against form data.
 */
class Validator {

    private array $rules = [];
    
    /**
     * Adds a validation rule to the validator.
     *
     * @param string $alias The alias/name of the rule.
     * @param RuleInterface $rule The rule object implementing RuleInterface.
     */
    public function add (string $alias, RuleInterface $rule) : void {
        $this->rules[$alias] = $rule;
    }

    /**
     * Validates form data against the defined rules.
     *
     * Iterates over the provided fields and their associated rules, applying each rule
     * to the corresponding form data. Collects and throws validation errors if any.
     *
     * @param array $formData The form data to validate.
     * @param array $fields The validation rules to apply.
     * @throws ValidationException If any validation rules fail.
     */
    public function validate (array $formData, array $fields) : void {
        $errors = [];
        
        // Iterate over each field and its associated rules
        foreach ($fields as $fieldName => $rules) {
            // Process each rule defined for the field
            foreach ($rules as $rule) {
                $ruleParams = [];

                // Check if the rule has parameters (e.g., "min:18")
                if (str_contains($rule, ":")) {
                    // Split the rule and its parameters
                    [$rule, $ruleParams] = explode(":", $rule);
                    $ruleParams = explode(",", $ruleParams);
                }

                // Retrieve the rule validator object from the array of rules
                $ruleValidator = $this->rules[$rule];

                // Run the validator on the input field
                if ($ruleValidator->validate($formData, $fieldName, $ruleParams)) {
                    continue;
                }
                // If validation fails, add the error message to the errors array
                $errors[$fieldName][] = $ruleValidator->getMessage($formData, $fieldName, $ruleParams);
            }   
        }

        // If any errors throw exception a ValidationException
        if (count($errors)) {
            throw new ValidationException($errors);
        }
    }
}