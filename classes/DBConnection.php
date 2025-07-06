<?php
// 🚫 No blank lines or spaces above this line

// Load DB constants if not already defined
if (!defined('DB_SERVER')) {
    require_once("../initialize.php");
}

class DBConnection {
    private $host     = DB_SERVER;
    private $username = DB_USERNAME;
    private $password = DB_PASSWORD;
    private $database = DB_NAME;

    public $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->conn->connect_error) {
            // ✅ Log error silently
            error_log("❌ DB Connection Failed: " . $this->conn->connect_error);

            // ✅ Throw exception instead of outputting error
            throw new Exception("Database connection failed.");
        }
    }

    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
