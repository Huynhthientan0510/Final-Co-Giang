<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Checkout - C++ Courses</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
	
	<style>
		.payment-container {
			max-width: 700px;
			margin: 50px auto;
			padding: 20px;
			background: #f4f4f4;
			border-radius: 10px;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
			animation: fadeIn 1s ease-in-out;
		}

		.summary-section {
			margin-bottom: 30px;
		}

		.summary-section h3 {
			font-size: 24px;
		}

		.summary-item {
			display: flex;
			justify-content: space-between;
			font-size: 18px;
			margin: 10px 0;
		}

		.total-price {
			font-weight: bold;
			color: #2c3e50;
		}

		.pay-button {
			width: 100%;
			padding: 15px;
			background-color: #28a745;
			color: white;
			font-size: 18px;
			border: none;
			border-radius: 5px;
			cursor: pointer;
			transition: background-color 0.3s ease;
		}

		.pay-button:hover {
			background-color: #218838;
		}
	</style>
</head>

<body>
	<!-- Navbar -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container">
			<a class="navbar-brand" href="#">Checkout</a>
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
						<a class="nav-link" href="cart.html">Cart</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<!-- Payment Container -->
	<div class="container payment-container">
		<h1 class="text-center">Checkout Summary</h1>

		<div class="summary-section">
			<h3>Courses in Cart</h3>
			<div id="cart-items">
				<!-- Dynamic Cart Items will be loaded here by JavaScript -->
			</div>
		</div>

		<div class="summary-item">
			<span>Total Price:</span>
			<span class="total-price" id="total-price">$0</span>
		</div>

		<button id="pay-button" class="pay-button">Proceed to Payment</button>
	</div>

	<!-- Footer -->
	<footer class="bg-dark text-light py-3">
		<div class="container text-center">
			<p>&copy; SCAM Center. All rights reserved.</p>
		</div>
	</footer>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script>
		document.addEventListener("DOMContentLoaded", () => {
			// Fetch courses from the cart and display them
			fetch('fetch_cart.php')
				.then(response => response.json())
				.then(data => {
					let cartItems = document.getElementById('cart-items');
					let totalPrice = 0;
					data.forEach(course => {
						// Create the cart item element
						const courseItem = `
						<div class="summary-item">
							<span>${course.course_name}</span>
							<span>$${course.price}</span>
						</div>`;
						cartItems.insertAdjacentHTML('beforeend', courseItem);
						totalPrice += parseFloat(course.price);
					});
					document.getElementById('total-price').innerText = `$${totalPrice.toFixed(2)}`;
				})
				.catch(error => {
					console.error('Error fetching cart data:', error);
				});

			// Handle payment process
			document.getElementById('pay-button').addEventListener('click', () => {
				Swal.fire({
					title: 'Processing Payment...',
					text: 'Please wait while we process your payment.',
					icon: 'info',
					showConfirmButton: false,
					allowOutsideClick: false,
					timer: 3000
				}).then(() => {
					// Simulate payment success
					Swal.fire({
						title: 'Payment Successful!',
						text: 'Thank you for purchasing the courses.',
						icon: 'success',
						confirmButtonText: 'Close'
					}).then(() => {
						// After successful payment, clear the cart
						fetch('clear_cart.php', {
							method: 'POST'
						})
						.then(response => response.json())
						.then(data => {
							if (data.success) {
								console.log('Cart cleared successfully');
							} else {
								console.error('Failed to clear cart:', data.message);
							}
						})
						.catch(error => {
							console.error('Error clearing cart:', error);
						});

						// Redirect to homepage after successful payment
						window.location.href = '../index.html';
					});
				});
			});
		});
	</script>
</body>
</html>
