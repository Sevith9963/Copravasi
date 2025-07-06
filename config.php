<?php
// 🚫 DO NOT add any blank lines or spaces before this line

// ✅ Start output buffering to avoid "headers already sent" issues
ob_start();

// ✅ Set timezone
ini_set('date.timezone', 'Asia/Manila');
date_default_timezone_set('Asia/Manila');

// ✅ Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ Include necessary files (no output in these files!)
require_once('initialize.php');
require_once('classes/DBConnection.php');
require_once('classes/SystemSettings.php');

// ✅ Create DB connection
$db = new DBConnection;
$conn = $db->conn;

// ✅ Redirect helper
function redirect($url = '') {
    if (!empty($url)) {
        echo '<script>location.href="' . base_url . $url . '"</script>';
        exit;
    }
}

// ✅ Image validation helper
function validate_image($file) {
    if (!empty($file)) {
        if (is_file(base_app . $file)) {
            return base_url . $file;
        } else {
            return base_url . 'dist/img/no-image-available.png';
        }
    } else {
        return base_url . 'dist/img/no-image-available.png';
    }
}

// ✅ Mobile device checker
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

// ✅ End output buffering (optional)
ob_end_flush();
?>
