<?php
// Database connection parameters
$host = 'localhost'; // Replace with your host
$db = 'cpp_learning_platform'; // Replace with your database name
$user = 'onii-chan'; // Replace with your username
$pass = 'onii123@'; // Replace with your password
// Create a connection
$conn = new mysqli($host, $user, $pass, $db);

// Check the connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

// Fetch courses from the database, including the price
$sql = "SELECT id, course_name, course_description, price FROM courses"; 
$result = $conn->query($sql);

// Check if any courses exist
if ($result->num_rows > 0) {
	// Loop through and display each course as a Bootstrap card
	while ($row = $result->fetch_assoc()) {
		// Log the fetched data for debugging
		error_log("Received course: " . print_r($row, true));

		// Check if price is being retrieved properly
		if (isset($row['price'])) {
			error_log("Received course price: " . $row['price']);
		} else {
			error_log("Course price missing for: " . $row['course_name']);
		}
		echo '
		<div class="col-lg-4 col-md-6">
			<div class="card h-100 text-center course-card animate__animated animate__zoomIn">
				<img src="https://via.placeholder.com/350x150" class="card-img-top" alt="' . $row['course_name'] . '">
				<div class="card-body">
					<h5 class="card-title">' . $row['course_name'] . '</h5>
					<p class="card-text">' . $row['course_description'] . '</p>
					<p class="card-text"><strong>Price: $' . number_format($row['price'], 2) . '</strong></p> <!-- Display price -->
					<div class="d-grid gap-2 d-md-flex justify-content-md-center">
						<button class="btn btn-success add-to-cart-btn" data-course-id="' . $row['id'] . '">Add to Cart</button>
						<button class="btn btn-warning buy-now-btn" data-course-id="' . $row['id'] . '">Buy Now</button>
					</div>
					<button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#courseModal' . $row['id'] . '">View Details</button>
				</div>
			</div>
		</div>';

		// Modal for each course
		echo '
		<div class="modal fade" id="courseModal' . $row['id'] . '" tabindex="-1" aria-labelledby="courseModalLabel' . $row['id'] . '" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="courseModalLabel' . $row['id'] . '">' . $row['course_name'] . '</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
				   
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>';
	}
} else {
	echo '<p>No courses available at the moment.</p>';
}

// Close the database connection
$conn->close();
?>
