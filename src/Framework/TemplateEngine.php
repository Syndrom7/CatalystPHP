<?php

declare(strict_types=1);

namespace Framework;

class TemplateEngine {

    private array $globalTemplateData = [];

    /**
     * Constructs a new TemplateEngine instance.
     *
     * @param string $templatePath The path to the directory containing template files.
     */
    public function __construct(private string $templatePath) {}

    

    /**
     * Renders a template file with provided data.
     *
     * Data is escaped and then extracted into the template.
     *
     * @param string $template The name of the template file to render (without the .php extension).
     * @param array $data The data to be made available to the template.
     * @return string The rendered template as a string.
     */
    public function render (string $template, array $data = []) : string {

        // Escape data in the array recursively 
        array_walk_recursive($data, function (&$item) {
            $item = htmlspecialchars((string) $item, ENT_QUOTES, 'UTF-8');
        });

        extract($data , EXTR_SKIP);
        extract($this->globalTemplateData, EXTR_SKIP);

        ob_start();

        include "{$this->templatePath}/{$template}.php";

        $output = ob_get_contents();

        ob_end_clean();
        
        return $output;
    }

    /**
     * Resolves the full path of a given template file.
     *
     * @param string $path The relative path of the template file.
     * @return string The resolved full path of the template file.
     */
    public function resolve (string $path) : string {
        return "{$this->templatePath}/{$path}";
    }

    /**
     * Adds a global variable to the template data.
     *
     * This data will be available to all templates rendered by the engine.
     *
     * @param string $key The key of the global variable.
     * @param mixed $value The value of the global variable.
     */
    public function addGlobal (string $key, mixed $value) : void {
        $this->globalTemplateData[$key] = $value;
    }

    /**
     * Returns error messages for a specific field as an array.
     *
     * @param string $field The name of the field to display errors for.
     * @param array $errors Array containing error messages.
     * @return array Array of error messages for the specified field.
     */
    public function getErrorMessages(string $field, array $errors): array {
        if (!array_key_exists($field, $errors)) {
            return [];
        }

        return $errors[$field];
    }

    /**
     * Retrieves the value of a form field from previous input data.
     *
     * @param array $formData Array containing previously submitted form data.
     * @param string $field The name of the form field to retrieve the value for.
     * @param string $default Default value to return if the field is not set in formData.
     * @return string The value of the old form field or the default value.
     */
    public function oldInput(array $formData, string $field, string $default = ''): string {
        return $formData[$field] ?? $default;
    }

    /**
     * Returns a CSRF token as a hidden input field.
     *
     * @param string $csrfToken The CSRF token.
     * @return string The CSRF token input field.
     */
    public function csrf(string $csrfToken): string {
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') . '">';
    }
}