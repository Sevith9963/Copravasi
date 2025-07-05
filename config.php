<?php
// ✅ Start output buffering before anything is sent to browser
ob_start();

// ✅ Set PHP timezone
ini_set('date.timezone', 'Asia/Manila');
date_default_timezone_set('Asia/Manila');

// ✅ Start session before any output is flushed
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ Load system configuration
require_once('initialize.php');
require_once('classes/DBConnection.php');
require_once('classes/SystemSettings.php');

// ✅ Attempt DB connection
try {
    $db = new DBConnection();
    $conn = $db->conn;
} catch (Exception $e) {
    // ✅ You can log the error to a file instead for production
    die("❌ Database connection failed. Please contact the administrator.");
}

// ✅ Helper: Redirect
if (!function_exists('redirect')) {
    function redirect($url = '') {
        if (!empty($url)) {
            echo '<script>location.href="' . base_url . $url . '"</script>';
        }
    }
}

// ✅ Helper: Validate image path
if (!function_exists('validate_image')) {
    function validate_image($file) {
        if (!empty($file) && is_file(base_app . $file)) {
            return base_url . $file;
        }
        return base_url . 'dist/img/no-image-available.png';
    }
}

// ✅ Helper: Detect mobile device
if (!function_exists('isMobileDevice')) {
    function isMobileDevice() {
        $mobileAgents = array(
            '/iphone/i', '/ipod/i', '/ipad/i', '/android/i',
            '/blackberry/i', '/webos/i'
        );
        foreach ($mobileAgents as $pattern) {
            if (preg_match($pattern, $_SERVER['HTTP_USER_AGENT'])) {
                return true;
            }
        }
        return false;
    }
}

// 🚫 DO NOT use ob_end_flush() — it may break session or header behavior
