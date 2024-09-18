<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $file = $_FILES['file'];

    // Check if the file was uploaded without any errors
    if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {
        $fileName = basename($file['name']);
        $targetFilePath = 'uploads/' . $fileName;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
            // Update the user's image path in the database
            $query = "UPDATE users SET image = ? WHERE id = ?";
            $stmt = mysqli_prepare($conn, $query);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "si", $targetFilePath, $user_id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                echo $targetFilePath; // Return the path to the uploaded file
            } else {
                echo "Failed to update database.";
            }
        } else {
            echo "Failed to move uploaded file.";
        }
    } else {
        echo "No file uploaded or there was an error.";
    }
} else {
    echo "Invalid request method.";
}

mysqli_close($conn);
?>
