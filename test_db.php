<?php
$conn = new mysqli('127.0.0.1', 'root', '', 'tourism_db');

if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}
echo "✅ Connected to tourism_db successfully!";
?>
