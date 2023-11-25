<?php

declare(strict_types=1);  

/**
 * Dump and die function for debugging purposes.
 *
 * @param mixed $value The value to be dumped.
 * @return void
 */
function dd (mixed ...$value) : void {
    echo "<pre style='background-color: #f5f5f5; padding: 10px; border: 1px solid #ccc;'>";

    ob_start();
    print_r($value);
    $output = ob_get_clean();

    highlight_string("<?php\n" . $output . "\n?>");

    echo "</pre>";
    
    die();
}

/**
 * Redirect to another URL 
 *
 * @param string $path Redirection path
 * @return void
 */
function redirectTo (string $path) : void {
    header("Location: {$path}", response_code: 302);
    exit;
}

