<?php
// Developer fallback account (used for development access)
$dev_data = [
    'id'           => '-1',
    'firstname'    => 'Developer',
    'lastname'     => '',
    'username'     => 'dev_oretnom',
    'password'     => '5da283a2d990e8d8512cf967df5bc0d0',
    'last_login'   => '',
    'date_updated' => '',
    'date_added'   => ''
];

// Dynamically build base URL (for browser and CLI)
if (php_sapi_name() !== 'cli' && isset($_SERVER['HTTP_HOST'])) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $base_url = $protocol . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']);
    $base_url = rtrim($base_url, '/') . '/';
} else {
    // Fallback for CLI (e.g., cron jobs or unit tests)
    $base_url = 'http://localhost/tourism/';
}

// Define global constants only if not already defined
defined('base_url')   || define('base_url', $base_url);
defined('base_app')   || define('base_app', str_replace('\\', '/', __DIR__) . '/');
defined('dev_data')   || define('dev_data', $dev_data);

// Database configuration (from env or fallback values)
defined('DB_SERVER')   || define('DB_SERVER', getenv('DB_SERVER') ?: '127.0.0.1');
defined('DB_USERNAME') || define('DB_USERNAME', getenv('DB_USERNAME') ?: 'root');
defined('DB_PASSWORD') || define('DB_PASSWORD', getenv('DB_PASSWORD') ?: '');
defined('DB_NAME')     || define('DB_NAME', getenv('DB_NAME') ?: 'tourism_db');
