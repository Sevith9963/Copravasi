<?php
// Ensure DB constants are loaded
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
        // Create the MySQLi connection
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

        // Check for connection error
        if ($this->conn->connect_error) {
            die("❌ Database connection failed: " . $this->conn->connect_error);
        }
    }

    public function __destruct() {
        // Close the connection on destruction
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>
