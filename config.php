<?php
// =============================================
// CONFIG.PHP - SECURE CONFIGURATION FILE
// =============================================
// 🚫 MUST be the first line with NO whitespace before <?php
// 🚫 Ensure file is saved without BOM (Byte Order Mark)

// ======================
// 1. SERVER CONFIGURATION
// ======================

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1); // Set to 0 in production

// ==================
// 2. SESSION HANDLING
// ==================

// Session security settings (MUST come before session_start())
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', isset($_SERVER['HTTPS']));
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_samesite', 'Strict');

// Custom session parameters
$sessionParams = [
    'lifetime' => 86400, // 1 day
    'path' => '/',
    'domain' => $_SERVER['HTTP_HOST'] ?? '',
    'secure' => isset($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Strict'
];

session_set_cookie_params($sessionParams);

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Regenerate session ID periodically
if (!isset($_SESSION['created'])) {
    session_regenerate_id(true);
    $_SESSION['created'] = time();
} elseif (time() - $_SESSION['created'] > 1800) { // 30 minutes
    session_regenerate_id(true);
    $_SESSION['created'] = time();
}

// =================
// 3. CORE SETTINGS
// =================

// Timezone configuration
date_default_timezone_set('Asia/Manila');

// Directory separator constant
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

// Base path constant
defined('BASE_PATH') or define('BASE_PATH', realpath(dirname(__FILE__)) . DS);

// Now start output buffering
ob_start();

// ===================
// 4. FILE INCLUDES
// ===================

try {
    require_once('initialize.php');
    require_once('classes/DBConnection.php');
    require_once('classes/SystemSettings.php');
} catch (Throwable $e) {
    error_log("System initialization failed: " . $e->getMessage());
    ob_clean();
    die("System maintenance in progress. Please try again later.");
}

// =====================
// 5. DATABASE CONNECTION
// =====================

try {
    $db = new DBConnection();
    $conn = $db->conn;
    
    // Test connection
    if (!method_exists($conn, 'ping') || !$conn->ping()) {
        throw new Exception("Database connection failed");
    }
} catch (Throwable $e) {
    error_log("Database error: " . $e->getMessage());
    ob_clean();
    die("Database connection error. Please contact administrator.");
}

// ===================
// 6. HELPER FUNCTIONS
// ===================

/**
 * Secure redirect helper
 */
function redirect(string $url = '', int $statusCode = 303): void {
    if (!headers_sent()) {
        $target = empty($url) ? ($_SERVER['HTTP_REFERER'] ?? base_url) : base_url . $url;
        header('Location: ' . filter_var($target, FILTER_SANITIZE_URL), true, $statusCode);
        exit;
    }
    
    // JavaScript fallback
    echo '<script>location.href="' . 
         htmlspecialchars(base_url . $url, ENT_QUOTES) . 
         '"</script>';
    exit;
}

/**
 * Secure image validation
 */
function validate_image(?string $file): string {
    $default = base_url . 'dist/img/no-image-available.png';
    
    if (empty($file)) {
        return $default;
    }

    $filePath = base_app . $file;
    
    if (is_file($filePath) && is_readable($filePath)) {
        header('Cache-Control: public, max-age=86400');
        return base_url . $file;
    }
    
    return $default;
}

/**
 * Advanced mobile detection
 */
function isMobileDevice(): bool {
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    
    if (empty($userAgent)) {
        return false;
    }

    $mobilePattern = '/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|' .
                    'iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|' .
                    'palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series[46]0|symbian|treo|up\.(browser|link)|' .
                    'vodafone|wap|windows (ce|phone)|xda|xiino/i';

    return (bool) preg_match($mobilePattern, $userAgent);
}

// ===================
// 7. CLEANUP
// ===================

// Flush output buffer
while (ob_get_level() > 0) {
    ob_end_flush();
}

// ===================
// END OF CONFIG.PHP
// ===================
?>