<?php
// Only load initialize if not already defined (CLI or direct usage)
if (!defined('DB_SERVER')) {
    require_once("../initialize.php");
}

class DBConnection {

    private $host;
    private $username;
    private $password;
    private $database;

    public $conn;

    public function __construct() {
        // Load from constants (which can be overridden via env in initialize.php)
        $this->host     = DB_SERVER ?: '127.0.0.1'; // IP avoids socket issue on cloud
        $this->username = DB_USERNAME;
        $this->password = DB_PASSWORD;
        $this->database = DB_NAME;

        // Enable detailed error reporting for mysqli (useful for debugging)
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
            $this->conn->set_charset("utf8mb4"); // Optional: ensure character encoding
        } catch (mysqli_sql_exception $e) {
            // Log to file or show clean error message
            error_log("❌ DB Connection error: " . $e->getMessage());
            die("Database connection failed. Please contact the administrator.");
        }
    }

    public function __destruct() {
        if ($this->conn && $this->conn->ping()) {
            $this->conn->close();
        }
    }
}
?>
