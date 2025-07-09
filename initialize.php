<?php
// Absolutely NO whitespace before this tag

// Developer default data (fallback)
$dev_data = array(
    'id' => '-1',
    'firstname' => 'Developer',
    'lastname' => '',
    'username' => 'dev_oretnom',
    'password' => '5da283a2d990e8d8512cf967df5bc0d0', // Pre-hashed (MD5-like, but consider stronger hashing)
    'last_login' => '',
    'date_updated' => '',
    'date_added' => ''
);

// Define constants only if not already defined
if (!defined('base_url')) define('base_url', 'https://tourism-2-laic.onrender.com/');
if (!defined('base_app')) define('base_app', str_replace('\\', '/', __DIR__) . '/');
if (!defined('dev_data')) define('dev_data', $dev_data);

// Database connection parameters
if (!defined('DB_SERVER')) define('DB_SERVER', '127.0.0.1');
if (!defined('DB_USERNAME')) define('DB_USERNAME', 'root');
if (!defined('DB_PASSWORD')) define('DB_PASSWORD', '');
if (!defined('DB_NAME')) define('DB_NAME', 'tourism_db');
?>
