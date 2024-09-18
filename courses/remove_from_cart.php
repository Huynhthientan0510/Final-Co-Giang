<?php
session_start();
include '../includes/db.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$course_id = $_POST['course_id'];
	$user_id = $_SESSION['user_id'];

	// SQL query to delete the course from the cart
	$query = "DELETE FROM cart WHERE user_id = ? AND course_id = ?";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("ii", $user_id, $course_id);

	if ($stmt->execute()) {
		echo "success";
	} else {
		echo "error";
	}

	$stmt->close();
}
$conn->close();
?>
