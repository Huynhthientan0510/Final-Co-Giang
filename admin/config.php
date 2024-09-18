<?php
// config.php
$host = 'localhost';            // Database host
$dbname = 'cpp_learning_platform'; // Your database name
$dbuser = 'onii-chan';   // Database username
$dbpass = 'onii123@';   // Database password

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $dbuser, $dbpass);
    // Set PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle connection error
    die("Database connection failed: " . $e->getMessage());
}
?>