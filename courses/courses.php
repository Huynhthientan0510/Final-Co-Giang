<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>C++ Courses</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
	<link rel="stylesheet" href="styles.css">
</head>

<body class="light-mode">
	<!-- Dark mode toggle button -->
	<button class="btn btn-dark mode-toggle" id="darkModeToggle">Dark Mode</button>

	<!-- Navbar -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container">
			<a class="navbar-brand" href="#">C++ Courses</a>
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
						<a class="nav-link" href="#">About</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Contact</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="cart.php">Your Cart</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<header class="bg-dark text-light py-4">
		<div class="container">
			<h1 class="text-center animate__animated animate__fadeInDown">C++ Courses</h1>
			<p class="text-center lead">Master C++ from Beginner to Advanced with Comprehensive Learning</p>
		</div>
	</header>

	<section id="courses" class="my-5">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-8 text-center mb-5">
					<h2 class="animate__animated animate__fadeInUp">Course Categories</h2>
					<p>Choose from a variety of C++ courses designed to elevate your skills from beginner to expert.</p>
				</div>
			</div>
			<div class="row gy-4">
				<!-- Dynamic content will be injected here via PHP -->
				<?php include 'fetch_courses.php'; ?>
			</div>
		</div>
	</section>

	<!-- Footer -->
	<footer class="bg-dark text-light py-3">
		<div class="container text-center">
			<p>&copy; SCAM Center. All rights reserved</p>
			<div class="social-icons mt-2">
				<a href="#" class="me-3"><i class="fab fa-facebook fa-2x"></i></a>
				<a href="#" class="me-3"><i class="fab fa-twitter fa-2x"></i></a>
				<a href="#"><i class="fab fa-linkedin fa-2x"></i></a>
			</div>
		</div>
	</footer>

	<!-- Bootstrap JS -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<!-- Custom JS -->
	<script src="scripts.js"></script>
</body>

</html>
