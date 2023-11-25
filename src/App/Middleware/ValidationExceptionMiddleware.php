<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use Framework\Exceptions\ValidationException;

/**
 * Middleware for handling validation exceptions.
 *
 * Catches `ValidationException` during request processing and stores error messages and session's old form data
 * (excluding sensitive fields) in the session. Then, redirects back to the previous page.
 */
class ValidationExceptionMiddleware implements MiddlewareInterface {
    
    /**
     * Processes the middleware logic.
     *
     * @param callable $next The next middleware.
     */
    public function process (callable $next) {
        try {
            // Attempt to process the next middleware
            $next();
        } catch (ValidationException $exception) {
            // Extract and filter old form data and exclude sensitive fields
            $oldFormData = $_POST;
            $excludedFields = ["password", "confirmPassword"];
            $formattedFormData = array_diff_key($oldFormData, array_flip($excludedFields));

            // Store the validation errors and old form data in the session
            $_SESSION["errors"] = $exception->errors;
            $_SESSION["oldFormData"] = $formattedFormData;
            
            // Redirect the user to the referring page
            $refer = $_SERVER["HTTP_REFERER"];
            redirectTo($refer);
        }
    }
    
}