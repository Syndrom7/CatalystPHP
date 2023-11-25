<?php

declare(strict_types=1);

/**
 * Custom autoloader function to automatically load classes based on their namespace.
 *
 * @param string $className The name of the class to load.
 */
function autoLoader(string $className) {
    // Define the namespace prefixes and their corresponding base directories.
    $prefixes = [
        'Framework\\' => __DIR__ . '/../',  // Path for 'Framework' namespace
        'App\\' => __DIR__ . '/../../App/', // Path for 'App' namespace
    ];

    // Iterate through each namespace prefix to find the appropriate file.
    foreach ($prefixes as $prefix => $base_dir) {
        // Check if the class name starts with the current namespace prefix.
        $len = strlen($prefix);
        if (strncmp($prefix, $className, $len) !== 0) {
            // If not, move to the next registered prefix.
            continue;
        }

        // Remove the namespace prefix and replace namespace separators with directory separators.
        $relative_class = substr($className, $len);
        $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

        // Check if the file exists and require it if it does.
        if (file_exists($file)) {
            require $file;
            return; 
        }
    }
}


spl_autoload_register('autoLoader');