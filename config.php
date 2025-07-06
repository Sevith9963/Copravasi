<?php
ob_start(); // Start output buffering early
ini_set('date.timezone', 'Asia/Manila');
date_default_timezone_set('Asia/Manila');

// Must be before any output
session_start();

require_once('initialize.php');
require_once('classes/DBConnection.php');
require_once('classes/SystemSettings.php');

// Create DB connection
try {
    $db = new DBConnection();
    $conn = $db->conn;
} catch (Exception $e) {
    die("Database connection failed. Please contact the administrator.");
}

// Helpers
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

ob_end_flush(); // Flush buffer after setup
?>
