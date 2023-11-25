<?php

declare(strict_types=1);

namespace Framework\Utilities;

use App\Config\Paths;
use RuntimeException;


/**
 * Loads environment variables from a .env file into the $_ENV superglobal.
 *
 * This function reads key-value pairs from a .env file and sets them
 * in the $_ENV superglobal for access throughout the application.
 */
function loadEnv() {
    // Define the path to the .env file.
    $envFilePath = Paths::ROOT . ".env";

    // Check if the .env file exists.
    if (!file_exists($envFilePath)) {
        return;
    }

    // Read the file contents into an array, ignoring empty lines and new lines.
    $lines = file($envFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($lines === false) {
        // Handle the error if the file cannot be read.
        throw new RuntimeException("Failed to read environment file at: {$envFilePath}");
    }

    // Process each line in the .env file.
    foreach ($lines as $line) {
        // Skip lines that are comments.
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        // Split the line into name and value.
        list($name, $value) = explode('=', $line, 2);

        // Remove quotes from the value.
        $value = trim($value, "\"'");

        // Set the value in the $_ENV.
        $_ENV[$name] = $value;
    }
}
