<?php
session_start();
include '../includes/db.php';  // Include your database connection

// Check if the user is logged in
if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
	echo json_encode(['success' => false, 'message' => 'User not logged in']);
	exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$userId = $_SESSION['user_id'];
	$username = $_SESSION['username'];
	$courseId = $_POST['course_id'];

	// Fetch course details from the database to get the course name and price
	$courseQuery = "SELECT course_name, price FROM courses WHERE course_id = ?";
	$courseStmt = mysqli_prepare($conn, $courseQuery);
	mysqli_stmt_bind_param($courseStmt, "i", $courseId);
	mysqli_stmt_execute($courseStmt);
	$courseResult = mysqli_stmt_get_result($courseStmt);

	if ($courseRow = mysqli_fetch_assoc($courseResult)) {
		$courseName = $courseRow['course_name'];
		$coursePrice = $courseRow['price'];  // Fetch the price from the database

		// Check if the course has been bought before
		$purchaseCheckQuery = "SELECT * FROM purchased_courses WHERE user_id = ? AND course_id = ?";
		$purchaseCheckStmt = mysqli_prepare($conn, $purchaseCheckQuery);
		mysqli_stmt_bind_param($purchaseCheckStmt, "ii", $userId, $courseId);
		mysqli_stmt_execute($purchaseCheckStmt);
		$purchaseCheckResult = mysqli_stmt_get_result($purchaseCheckStmt);

		if (mysqli_num_rows($purchaseCheckResult) > 0) {
			// Course has already been purchased
			echo json_encode(['success' => false, 'message' => 'Course already bought', 'purchased' => true]);
			exit();
		}

		// Check if the course is already in the cart
		$cartCheckQuery = "SELECT * FROM cart WHERE user_id = ? AND course_id = ?";
		$cartCheckStmt = mysqli_prepare($conn, $cartCheckQuery);
		mysqli_stmt_bind_param($cartCheckStmt, "ii", $userId, $courseId);
		mysqli_stmt_execute($cartCheckStmt);
		$cartCheckResult = mysqli_stmt_get_result($cartCheckStmt);

		if (mysqli_num_rows($cartCheckResult) > 0) {
			// Course is already in the cart
			echo json_encode(['success' => false, 'message' => 'Course already in cart', 'in_cart' => true]);
			exit();
		}

		// Insert the course into the cart
		$query = "INSERT INTO cart (user_id, course_id, course_name, username, price) VALUES (?, ?, ?, ?, ?)";
		$stmt = mysqli_prepare($conn, $query);
		if ($stmt) {
			mysqli_stmt_bind_param($stmt, "iissd", $userId, $courseId, $courseName, $username, $coursePrice);
			mysqli_stmt_execute($stmt);
			if (mysqli_stmt_affected_rows($stmt) > 0) {
				echo json_encode(['success' => true, 'message' => 'Course added to cart']);
			} else {
				echo json_encode(['success' => false, 'message' => 'Failed to add course to cart']);
			}
			mysqli_stmt_close($stmt);
		} else {
			echo json_encode(['success' => false, 'message' => 'Database query error']);
		}

		mysqli_stmt_close($cartCheckStmt);
		mysqli_stmt_close($purchaseCheckStmt);
	} else {
		echo json_encode(['success' => false, 'message' => 'Course not found']);
	}

	mysqli_stmt_close($courseStmt);
} else {
	echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

mysqli_close($conn);
?>
