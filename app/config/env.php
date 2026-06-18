<?php
/**
 * Environment Variable Loader
 * Parses .env file and sets environment variables
 */

function loadEnv($path = null) {
    if ($path === null) {
        $path = dirname(dirname(__DIR__)) . '/.env';
    }
    
    if (!file_exists($path)) {
        die('Environment file not found. Please create a .env file in the root directory.');
    }
    
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    foreach ($lines as $line) {
        // Skip comments
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        
        // Parse key=value
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            
            // Remove quotes if present
            $value = trim($value, '"\'');
            
            // Set environment variable
            putenv("$key=$value");
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }
    }
}

// Auto-load environment variables
loadEnv();
