<?php
session_start();  // Start session to store login state
include 'includes/db.php';  // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$email = $_POST['email'];
	$password = $_POST['password'];

	// Use prepared statements to avoid SQL injection
	$query = "SELECT * FROM users WHERE email = ?";
	$stmt = mysqli_prepare($conn, $query);
	if ($stmt) {
		mysqli_stmt_bind_param($stmt, "s", $email);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$user = mysqli_fetch_assoc($result);

		// Verify password
		if ($user && password_verify($password, $user['password'])) {
			// Set login state
			$_SESSION['isLoggedIn'] = true;  // Set session login state
			$_SESSION['user_email'] = $email;  // Store user email in session
			$_SESSION['user_id'] = $user['id'];  // Store user ID
			$_SESSION['username'] = $user['username'];  // Store username

			// Redirect user to the previous page or homepage
			echo '<script>
					localStorage.setItem("isLoggedIn", "true");
					localStorage.setItem("user_id", "' . $user['id'] . '");

					// Get redirect URL and action from sessionStorage
					const redirectUrl = sessionStorage.getItem("redirect_url") || "index.html";
					const action = sessionStorage.getItem("action");
					const courseId = sessionStorage.getItem("course_id");

					// Clear sessionStorage after login
					sessionStorage.removeItem("redirect_url");
					sessionStorage.removeItem("action");
					sessionStorage.removeItem("course_id");

					// Handle redirect based on action
					if (action === "add_to_cart") {
						alert("Course has been added to your cart!");
						window.location.href = redirectUrl;
					} else if (action === "buy_now" && courseId) {
						window.location.href = "purchase.html?course=" + courseId;
					} else {
						window.location.href = "index.html";  // Default to homepage if no action
					}
				  </script>';
		} else {
			echo "Invalid email or password.";
		}
		mysqli_stmt_close($stmt);
	} else {
		echo "Database query error.";
	}
}
mysqli_close($conn);
?>
