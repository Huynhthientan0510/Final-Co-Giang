<?php
session_start();
include '../includes/db.php';  // Include your database connection

// Check if the user is logged in
if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch courses in the user's cart before clearing it
$query = "SELECT course_id, course_name, price FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();

$cartItems = [];
while ($row = $result->fetch_assoc()) {
    $cartItems[] = $row;
}

$stmt->close();

// Insert purchased courses into the purchased_courses table
if (!empty($cartItems)) {
    $insertQuery = "INSERT INTO purchased_courses (user_id, course_id, course_name, purchase_date, time_of_purchase) VALUES (?, ?, ?, CURDATE(), CURTIME())";
    $stmt = $conn->prepare($insertQuery);
    
    foreach ($cartItems as $course) {
        $stmt->bind_param('iis', $userId, $course['course_id'], $course['course_name']);
        $stmt->execute();
    }
    
    $stmt->close();
}

// Delete all courses from the user's cart after inserting them into purchased_courses
$deleteQuery = "DELETE FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($deleteQuery);
$stmt->bind_param('i', $userId);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Cart cleared and courses purchased successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to clear cart']);
}

$stmt->close();
$conn->close();
?>
