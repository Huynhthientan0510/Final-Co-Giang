<?php
// Database connection
$host = 'localhost';
$dbname = 'cpp_learning_platform';
$user = 'onii-chan';
$pass = 'onii123@';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

// Get form data
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Hash password
$email = $_POST['email'];
$phone = $_POST['phone'];
$role = $_POST['role'];

// Insert into database
$stmt = $pdo->prepare("INSERT INTO admin_instructor (username, password, email, phone, role) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$username, $password, $email, $phone, $role]);

echo "Instructor created successfully!";
?>
