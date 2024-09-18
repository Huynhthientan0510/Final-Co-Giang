<?php
session_start();
include '../includes/db.php'; // Include your database connection file

// Check if the user is logged in
if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
	header("Location: ../login.html"); // Redirect to login if not logged in
	exit();
}

// Fetch the user ID from the session
$user_id = $_SESSION['user_id'];

// Query to get the user's cart items
$query = "SELECT * FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>My Cart - C++ Courses</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
	<link rel="stylesheet" href="styles.css">
</head>

<body class="light-mode">
	<!-- Dark mode toggle button -->
	<button class="btn btn-dark mode-toggle" id="darkModeToggle">Dark Mode</button>

	<!-- Navbar -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container">
			<a class="navbar-brand" href="#">My Cart</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
				aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav ms-auto">
					<li class="nav-item">
						<a class="nav-link" href="../index.html">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="courses.php">Courses</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<!-- Page Header -->
	<header class="bg-dark text-light py-4">
		<div class="container text-center">
			<h1 class="animate__animated animate__fadeInDown">Your Cart</h1>
			<p class="lead">Here are the C++ courses you have added to your cart.</p>
		</div>
	</header>

	<!-- Courses Section -->
	<section id="cart-courses" class="my-5">
		<div class="container">
			<div class="row gy-4" id="course-list">
				<?php
				// Check if there are any courses in the cart
				if ($result->num_rows > 0) {
					// Loop through each cart item and display it
					while ($row = $result->fetch_assoc()) {
						echo "
						<div class='col-md-4'>
							<div class='card h-100'>
								<div class='card-body'>
									<h5 class='card-title'>" . $row['course_name'] . "</h5>
									<p class='card-text'>Added by: " . $row['username'] . "</p>
									<button class='btn btn-danger remove-cart-item' data-course-id='" . $row['course_id'] . "'>Remove</button>
								</div>
							</div>
						</div>";
					}
				} else {
					echo "<p class='text-center'>Your cart is empty.</p>";
				}
				?>
			</div>
			<div class="text-center mt-4">
				<button id="checkout-btn" class="btn btn-primary">Proceed to Checkout</button>
			</div>
		</div>
	</section>

	<!-- Footer -->
	<footer class="bg-dark text-light py-3">
		<div class="container text-center">
			<p>&copy; SCAM Center. All rights reserved.</p>
			<div class="social-icons mt-2">
				<a href="#" class="me-3"><i class="fab fa-facebook fa-2x"></i></a>
				<a href="#" class="me-3"><i class="fab fa-twitter fa-2x"></i></a>
				<a href="#"><i class="fab fa-linkedin fa-2x"></i></a>
			</div>
		</div>
	</footer>

	<!-- Bootstrap JS and Custom JS -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script>
		// Handle remove button click
		$(document).on('click', '.remove-cart-item', function() {
			const courseId = $(this).data('course-id');

			// Confirm before removing the item
			Swal.fire({
				title: 'Are you sure?',
				text: "This will remove the course from your cart.",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Yes, remove it!',
				cancelButtonText: 'No, keep it'
			}).then((result) => {
				if (result.isConfirmed) {
					// Send AJAX request to remove the item
					$.ajax({
						url: 'remove_from_cart.php',
						type: 'POST',
						data: { course_id: courseId },
						success: function(response) {
							if (response === "success") {
								Swal.fire('Removed!', 'Course has been removed from your cart.', 'success').then(() => {
									window.location.reload(); // Reload the page after successful removal
								});
							} else {
								Swal.fire('Error', 'Failed to remove the course.', 'error');
							}
						},
						error: function() {
							Swal.fire('Error', 'Failed to remove the course.', 'error');
						}
					});
				}
			});
		});
	</script>
	<script>
		document.getElementById("checkout-btn").addEventListener("click", function() {
		window.location.href = "../payment/payment.php"; // Redirect to payment.php
	});

	</script>

</body>

</html>

<?php
$stmt->close();
$conn->close();
?>
