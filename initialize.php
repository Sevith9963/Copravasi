<?php
$dev_data = array(
    'id' => '-1',
    'firstname' => 'Developer',
    'lastname' => '',
    'username' => 'dev_oretnom',
    'password' => '5da283a2d990e8d8512cf967df5bc0d0',
    'last_login' => '',
    'date_updated' => '',
    'date_added' => ''
);

// Dynamically determine base URL
$base_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']);
$base_url = rtrim($base_url, '/') . '/';

// CLI fallback
if (php_sapi_name() === 'cli') {
    $base_url = 'http://localhost/tourism/';
}

if (!defined('base_url')) define('base_url', $base_url);
if (!defined('base_app')) define('base_app', str_replace('\\', '/', __DIR__) . '/');
if (!defined('dev_data')) define('dev_data', $dev_data);

// Environment-based DB configs (can be set in Render, Docker, etc.)
if (!defined('DB_SERVER')) define('DB_SERVER', getenv('DB_SERVER') ?: '127.0.0.1'); // use IP to avoid socket errors
if (!defined('DB_USERNAME')) define('DB_USERNAME', getenv('DB_USERNAME') ?: 'root');
if (!defined('DB_PASSWORD')) define('DB_PASSWORD', getenv('DB_PASSWORD') ?: '');
if (!defined('DB_NAME')) define('DB_NAME', getenv('DB_NAME') ?: 'tourism_db');
?>
