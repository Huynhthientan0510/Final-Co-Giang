<?php
// Start session
session_start();

// Database connection (use your actual credentials)
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to check if the user exists in the database
    $stmt = $pdo->prepare("SELECT * FROM admin_instructor WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        // Redirect based on the user's role
        if ($user['role'] === 'Instructor') {
            header("Location: instructor_dashboard.html");
        } elseif ($user['role'] === 'Admin') {
            header("Location: ../admin/admin_dashboard.html");
        } else {
            echo "Invalid role!";
        }
        exit();
    } else {
        echo "<script>alert('Invalid email or password');</script>";
    }
}
?>
