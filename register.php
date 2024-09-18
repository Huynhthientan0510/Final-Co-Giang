<?php
include 'includes/db.php';  // Database connection
include 'includes/functions.php';  // Helper functions

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = hashPassword($_POST['password']);

    // Prepare a statement to prevent SQL injection and check both tables
    $stmt = $conn->prepare("
        SELECT 'users' AS source FROM users WHERE email = ? OR phone = ?
        UNION
        SELECT 'admin_instructor' AS source FROM admin_instructor WHERE email = ? OR phone = ?
        LIMIT 1
    ");
    $stmt->bind_param("ssss", $email, $phone, $email, $phone);
    $stmt->execute();
    $stmt->store_result();

    // Check if the email or phone already exists in either table
    if ($stmt->num_rows > 0) {
        // Redirect back to register.html with error message and previous form data
        header("Location: register.html?error=Email%20or%20Phone%20number%20already%20registered.&username=$username&email=$email&phone=$phone");
        exit();
    } else {
        // Insert into database
        $stmt = $conn->prepare("INSERT INTO users (username, email, phone, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $phone, $password);

        if ($stmt->execute()) {
            // Redirect to confirmation page
            header("Location: confirmation.php");
            exit();
        } else {
            // Redirect back to register.html with error message
            $error_message = urlencode("Error: " . $stmt->error);
            header("Location: register.html?error=$error_message&username=$username&email=$email&phone=$phone");
            exit();
        }
    }

    $stmt->close();
}
?>
