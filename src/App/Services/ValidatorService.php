<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Validator;
use Framework\Rules\{EmailRule, MatchRule, MaxRule, RequiredRule, MinRule, UrlRule};


/**
 * Service class for handling form validations.
 *
 * Initializes a Validator instance and registers validation rules.
 * Provides methods to validate forms.
 */
class ValidatorService {
    private Validator $validator;

    /**
     * Constructs the ValidatorService.
     *
     * Initializes the Validator and registers validation rules.
     */
    public function __construct() {
        $this->validator = new Validator();
        $this->validator->add("required", new RequiredRule());
        $this->validator->add("email", new EmailRule());
        $this->validator->add("min", new MinRule());
        $this->validator->add("match", new MatchRule());
        $this->validator->add("max", new MaxRule());
    }

    /**
     * Validates registration form data.
     *
     * Applies validation rules to the registration form fields.
     *
     * @param array $formData The data from the registration form.
     * @return void
     */
    public function validateRegister (array $postData) : void {
        $this->validator->validate($postData, [
            "email" => ["required", "email"],
            "password" => ["required"],
            "confirmPassword" => ["required", "match:password"],
        ]);
    }

    /**
     * Validates login form data.
     *
     * Applies validation rules to the login form fields.
     *
     * @param array $formData The data from the login form.
     * @return void
     */
    public function validateLogin (array $postData) : void {
        $this->validator->validate($postData, [
            "email" => ["required", "email"],
            "password" => ["required"],
        ]);
    }

}