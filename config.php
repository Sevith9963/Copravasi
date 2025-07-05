<?php
ob_start(); // Start output buffering
session_start(); // Must come before any output

require_once('initialize.php');
require_once('classes/DBConnection.php');
require_once('classes/SystemSettings.php');

try {
    $db = new DBConnection();
    $conn = $db->conn;
} catch (Exception $e) {
    die("❌ Database connection failed. Please contact the administrator.");
}

// Redirect helper
if (!function_exists('redirect')) {
    function redirect($url = '') {
        if (!empty($url)) {
            echo '<script>location.href="' . base_url . $url . '"</script>';
        }
    }
}

// Validate image path
if (!function_exists('validate_image')) {
    function validate_image($file) {
        return (!empty($file) && is_file(base_app . $file)) ? base_url . $file : base_url . 'dist/img/no-image-available.png';
    }
}

// Detect mobile devices
if (!function_exists('isMobileDevice')) {
    function isMobileDevice() {
        $devices = [
            '/iphone/i', '/ipod/i', '/ipad/i', '/android/i', '/blackberry/i', '/webos/i'
        ];
        foreach ($devices as $device) {
            if (preg_match($device, $_SERVER['HTTP_USER_AGENT'])) {
                return true;
            }
        }
        return false;
    }
}
