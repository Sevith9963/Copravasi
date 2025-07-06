<?php
// 🚫 Strict error reporting for development (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ✅ Security: Prevent XSS attacks
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1); // Enable if using HTTPS
ini_set('session.use_strict_mode', 1);

// ✅ Start output buffering with compression
if (!ob_start("ob_gzhandler")) {
    ob_start();
}

// ✅ Timezone settings
date_default_timezone_set('Asia/Manila');

// ✅ Session configuration
session_set_cookie_params([
    'lifetime' => 86400, // 1 day
    'path' => '/',
    'domain' => $_SERVER['HTTP_HOST'] ?? '',
    'secure' => isset($_SERVER['HTTPS']), // Auto-enable for HTTPS
    'httponly' => true,
    'samesite' => 'Strict'
]);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ Regenerate session ID to prevent fixation
if (!isset($_SESSION['created'])) {
    session_regenerate_id(true);
    $_SESSION['created'] = time();
} elseif (time() - $_SESSION['created'] > 1800) { // 30 minutes
    session_regenerate_id(true);
    $_SESSION['created'] = time();
}

// ✅ Constants definition
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
defined('BASE_PATH') or define('BASE_PATH', realpath(dirname(__FILE__)) . DS);

// ✅ Include core files with error handling
try {
    require_once('initialize.php');
    require_once('classes/DBConnection.php');
    require_once('classes/SystemSettings.php');
} catch (Throwable $e) {
    error_log("Core file inclusion failed: " . $e->getMessage());
    die("System initialization failed. Please try again later.");
}

// ✅ Database connection with error handling
try {
    $db = new DBConnection();
    $conn = $db->conn;
    
    // Test connection
    if ($conn->ping() === false) {
        throw new Exception("Database connection is not active");
    }
} catch (Throwable $e) {
    error_log("Database connection failed: " . $e->getMessage());
    die("Database connection error. Please contact administrator.");
}

// ✅ Enhanced redirect helper
function redirect(string $url = '', int $statusCode = 303): void {
    if (!headers_sent()) {
        if (empty($url)) {
            $url = $_SERVER['HTTP_REFERER'] ?? base_url;
        }
        header('Location: ' . filter_var(base_url . $url, FILTER_SANITIZE_URL), true, $statusCode);
        exit;
    }
    
    // Fallback to JavaScript if headers sent
    echo '<script>location.href="' . htmlspecialchars(base_url . $url, ENT_QUOTES) . '"</script>';
    exit;
}

// ✅ Secure image validation with caching headers
function validate_image(?string $file): string {
    $default = base_url . 'dist/img/no-image-available.png';
    
    if (empty($file)) {
        return $default;
    }

    $filePath = base_app . $file;
    
    if (is_file($filePath) && is_readable($filePath)) {
        // Add cache control for images
        header('Cache-Control: public, max-age=86400');
        return base_url . $file;
    }
    
    return $default;
}

// ✅ Enhanced mobile detection
function isMobileDevice(): bool {
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    
    if (empty($userAgent)) {
        return false;
    }

    $mobileKeywords = [
        'mobile', 'android', 'iphone', 'ipod', 'ipad', 
        'blackberry', 'webos', 'windows phone', 'iemobile'
    ];

    foreach ($mobileKeywords as $keyword) {
        if (stripos($userAgent, $keyword) !== false) {
            return true;
        }
    }

    return (bool) preg_match(
        '/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|' .
        'ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|' .
        'plucker|pocket|psp|series[46]0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',
        $userAgent
    );
}

// ✅ Clean output buffer
while (ob_get_level() > 0) {
    ob_end_flush();
}