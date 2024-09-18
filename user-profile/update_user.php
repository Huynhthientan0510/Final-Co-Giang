<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // Check if the password field is empty or not
    if (!empty($password)) {
        // Hash the password before saving
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE users SET username = ?, email = ?, phone = ?, password = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssssi", $username, $email, $phone, $hashedPassword, $user_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            echo "Profile and password updated successfully.";
        } else {
            echo "Failed to update profile.";
        }
    } else {
        // If no new password, update without password
        $query = "UPDATE users SET username = ?, email = ?, phone = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssi", $username, $email, $phone, $user_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            echo "Profile updated successfully.";
        } else {
            echo "Failed to update profile.";
        }
    }
} else {
    echo "Invalid request method.";
}

mysqli_close($conn);
?>
