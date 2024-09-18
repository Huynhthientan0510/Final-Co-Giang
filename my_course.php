<?php
// Assuming the user is logged in and their ID is in session
session_start();
$user_id = $_SESSION['user_id']; // Logged-in user ID

// Connect to your database
include 'includes/db.php'; 

// Fetch purchased courses for this user
$sql = "SELECT course_name FROM purchased_courses WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the user has purchased any courses
if ($result->num_rows > 0) {
    $courses = array();

    // Store the purchased course names
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row['course_name'];
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    // User has not purchased any courses
    echo "<p>You haven't purchased any courses yet.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
        }

        body {
            background-color: #f4f4f9;
            padding: 20px;
        }

        h1 {
            text-align: center;
            font-size: 36px;
            color: #333;
            margin-bottom: 40px;
        }

        .container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            justify-items: center;
        }

        .card {
            background-color: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
            position: relative;
            width: 300px;
            cursor: pointer;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: linear-gradient(120deg, rgba(0, 255, 188, 0.7), rgba(72, 52, 212, 0.7));
            z-index: 0;
            opacity: 0;
            transition: opacity 0.4s ease-in-out;
        }

        .card:hover::before {
            opacity: 0.85;
        }

        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: opacity 0.4s ease-in-out;
            z-index: 1;
        }

        .card:hover img {
            opacity: 0.7;
        }

        .card-body {
            padding: 20px;
            position: relative;
            z-index: 2;
        }

        .card-title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #333;
        }

        .card-text {
            font-size: 14px;
            color: #555;
            margin-bottom: 20px;
        }

        .btn {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            transition: background-color 0.3s ease-in-out;
            position: relative;
            z-index: 2;
        }

        .btn:hover {
            background-color: #218838;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.3);
            z-index: 1;
            transition: left 0.4s ease-in-out;
        }

        .btn:hover::before {
            left: 100%;
        }

        /* Add smooth scrolling effect when clicking on course cards */
        html {
            scroll-behavior: smooth;
        }

        /* Responsive design for smaller screens */
        @media (max-width: 768px) {
            h1 {
                font-size: 28px;
            }

            .card {
                width: 100%;
                max-width: 90%;
            }
        }
    </style>
</head>
<body>

    <h1>My Courses</h1>
    <div class="container">
        <?php foreach ($courses as $course): ?>
            <div class="card">
                <!-- Default or dynamic image for each course -->
                <img src="path/to/default/course-image.jpg" alt="Course Image">

                <div class="card-body">
                    <h3 class="card-title"><?php echo $course; ?></h3>
                    <p class="card-text">Explore the lessons and resources for "<?php echo $course; ?>" at your own pace.</p>
                    <!-- Link to the index.html file inside the course folder -->
                    <a href="course/<?php echo rawurlencode($course); ?>/index.html" class="btn">Learn</a>
                </div>

            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>
