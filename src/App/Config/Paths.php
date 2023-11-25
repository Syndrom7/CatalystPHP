<?php

declare (strict_types=1);

namespace App\Config;

/**
 * Class for path constants.
 *
 * Defines constants for various directory paths used throughout the application,
 * such as views, root, and storage directories.
 */
class Paths {
    
    /**
     * Path to the views directory.
     */
    public const VIEW = __DIR__ . '/../views';

    /**
     * Path to the application's source directory.
     */
    public const SOURCE = __DIR__ . '/../../';

    /**
     * Path to the application's root directory.
     */
    public const ROOT = __DIR__ . "/../../../";

    /**
     * Path to the uploads directory in storage.
     */
    public const STORAGE_UPLOADS = __DIR__ . "/../../../storage/uploads";
}