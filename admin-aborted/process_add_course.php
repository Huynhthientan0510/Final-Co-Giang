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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $course_name = $_POST['course_name'];
    $course_description = $_POST['course_description'];
    $price = $_POST['price'];

    // Validation to ensure all fields are filled
    if (empty($course_name) || empty($course_description) || empty($price)) {
        echo "All fields are required.";
        exit;
    }

    // Check if price is a valid number
    if (!is_numeric($price)) {
        echo "Price must be a valid number.";
        exit;
    }

    try {
        // Insert data into courses table
        $stmt = $pdo->prepare("INSERT INTO courses (course_name, course_description, price) VALUES (?, ?, ?)");
        $stmt->execute([$course_name, $course_description, $price]);

        // Success message
        echo "Course added successfully!";
    } catch (PDOException $e) {
        // Display error if insertion fails
        echo "Error: " . $e->getMessage();
    }
}
?>
