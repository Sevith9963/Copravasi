<?php
// =============================================
// CONFIG.PHP - SECURE CONFIGURATION FILE
// =============================================
// 🚫 ABSOLUTELY NO OUTPUT BEFORE THIS LINE
// 🚫 No whitespace, no BOM, no HTML before <?php

// ======================
// 1. ERROR REPORTING
// ======================
error_reporting(E_ALL);
ini_set('display_errors', 0); // Set to 1 for debugging, 0 in production

// ==================
// 2. SESSION HANDLING
// ==================
// These MUST be the very first session-related calls

// Session INI settings (must come before session_start())
@ini_set('session.cookie_httponly', 1);
@ini_set('session.cookie_secure', isset($_SERVER['HTTPS']));
@ini_set('session.use_strict_mode', 1);
@ini_set('session.cookie_samesite', 'Strict');

// Session cookie parameters
@session_set_cookie_params([
    'lifetime' => 86400, // 1 day
    'path' => '/',
    'domain' => $_SERVER['HTTP_HOST'] ?? '',
    'secure' => isset($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Strict'
]);

// Start session
if (session_status() === PHP_SESSION_NONE) {
    @session_start();
}

// Regenerate session ID periodically
if (session_status() === PHP_SESSION_ACTIVE) {
    if (!isset($_SESSION['created'])) {
        @session_regenerate_id(true);
        $_SESSION['created'] = time();
    } elseif (time() - $_SESSION['created'] > 1800) {
        @session_regenerate_id(true);
        $_SESSION['created'] = time();
    }
}

// =================
// 3. CORE SETTINGS
// =================
date_default_timezone_set('Asia/Manila');

// Directory separator
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

// Base path
defined('BASE_PATH') or define('BASE_PATH', realpath(dirname(__FILE__)) . DS);

// ===================
// 4. OUTPUT BUFFERING
// ===================
// Only start output buffering AFTER session setup
ob_start();

// ===================
// 5. FILE INCLUDES
// ===================
try {
    require_once('initialize.php');
    require_once('classes/DBConnection.php');
    require_once('classes/SystemSettings.php');
} catch (Throwable $e) {
    error_log("System initialization failed: " . $e->getMessage());
    if (ob_get_level() > 0) ob_end_clean();
    die("System maintenance in progress. Please try again later.");
}

// =====================
// 6. DATABASE CONNECTION
// =====================
try {
    $db = new DBConnection();
    $conn = $db->conn;
    
    if (!method_exists($conn, 'ping') || !$conn->ping()) {
        throw new Exception("Database connection failed");
    }
} catch (Throwable $e) {
    error_log("Database error: " . $e->getMessage());
    if (ob_get_level() > 0) ob_end_clean();
    die("Database connection error. Please contact administrator.");
}

// ===================
// 7. HELPER FUNCTIONS
// ===================
function redirect(string $url = '', int $statusCode = 303): void {
    if (!headers_sent()) {
        $target = empty($url) ? ($_SERVER['HTTP_REFERER'] ?? base_url) : base_url . $url;
        header('Location: ' . filter_var($target, FILTER_SANITIZE_URL), true, $statusCode);
        exit;
    }
    
    echo '<script>location.href="' . htmlspecialchars(base_url . $url, ENT_QUOTES) . '"</script>';
    exit;
}

function validate_image(?string $file): string {
    $default = base_url . 'dist/img/no-image-available.png';
    if (empty($file)) return $default;

    $filePath = base_app . $file;
    if (is_file($filePath) && is_readable($filePath)) {
        if (!headers_sent()) {
            header('Cache-Control: public, max-age=86400');
        }
        return base_url . $file;
    }
    return $default;
}

function isMobileDevice(): bool {
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
    return (bool) preg_match(
        '/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series[46]0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', 
        $ua
    );
}

// ===================
// 8. CLEANUP
// ===================
while (ob_get_level() > 0) {
    ob_end_flush();
}