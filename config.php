<?php
// Absolutely no whitespace or BOM before this line

// Start output buffering (to prevent accidental output)
ob_start();

// Set PHP configuration before output
ini_set('date.timezone', 'Asia/Manila');
date_default_timezone_set('Asia/Manila');

// Optional: Secure session settings (must come before session_start)
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 1 : 0);

// Set session cookie parameters before session_start
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
    'httponly' => true,
    'samesite' => 'Lax', // Or 'Strict'
]);

// Start session safely
session_start();
session_regenerate_id(true);

// Load other required files
require_once('initialize.php');
require_once('classes/DBConnection.php');
require_once('classes/SystemSettings.php');

// Connect to DB with exception handling
try {
    $db = new DBConnection();
    $conn = $db->conn;
} catch (Exception $e) {
    die("Database connection failed. Please contact the administrator.");
}

// Helper Functions
if (!function_exists('redirect')) {
    function redirect($url = '') {
        if (!empty($url)) {
            echo '<script>location.href="' . base_url . $url . '"</script>';
        }
    }
}

if (!function_exists('validate_image')) {
    function validate_image($file) {
        if (!empty($file) && is_file(base_app . $file)) {
            return base_url . $file;
        }
        return base_url . 'dist/img/no-image-available.png';
    }
}

if (!function_exists('isMobileDevice')) {
    function isMobileDevice() {
        $aMobileUA = array(
            '/iphone/i' => 'iPhone',
            '/ipod/i' => 'iPod',
            '/ipad/i' => 'iPad',
            '/android/i' => 'Android',
            '/blackberry/i' => 'BlackBerry',
            '/webos/i' => 'Mobile'
        );
        foreach ($aMobileUA as $sMobileKey => $sMobileOS) {
            if (preg_match($sMobileKey, $_SERVER['HTTP_USER_AGENT'])) {
                return true;
            }
        }
        return false;
    }
}

// Flush the output buffer after everything is loaded
ob_end_flush();
?>
