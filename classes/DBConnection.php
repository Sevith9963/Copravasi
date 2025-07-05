<?php
// Ensure constants are loaded
if (!defined('DB_SERVER')) {
    require_once("../initialize.php");
}

class DBConnection {
    private $host = DB_SERVER;
    private $username = DB_USERNAME;
    private $password = DB_PASSWORD;
    private $database = DB_NAME;

    public $conn;

    public function __construct() {
        // 🔍 Debug: Show the DB password being used (TEMPORARY — remove later)
        echo "🔍 Using DB password: '" . $this->password . "'<br>";

        // Create connection
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

        // Handle connection error
        if ($this->conn->connect_error) {
            die("❌ Database connection failed: " . $this->conn->connect_error);
        }
    }

    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>
