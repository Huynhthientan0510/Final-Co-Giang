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

$identifier = $_POST['identifier'];

// Delete based on email or phone
$stmt = $pdo->prepare("DELETE FROM admin_instructor WHERE email = ? OR phone = ?");
$stmt->execute([$identifier, $identifier]);

echo "Instructor deleted successfully!";
?>
