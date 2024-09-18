<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Account Created</title>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
	<style>
		body {
			display: flex;
			justify-content: center;
			align-items: center;
			height: 100vh;
			background-color: #f8f9fa;
		}
		.message {
			text-align: center;
		}
	</style>
</head>
<body>
	<div class="message">
		<h3>Account Created Successfully!</h3>
		<p>You will be redirected to the login page in 5 seconds.</p>
		<p>If you are not redirected, <a href="login.html">click here</a>.</p>
	</div>

	<script>
		setTimeout(function() {
			window.location.href = 'login.html';
		}, 5000); // 5000 milliseconds = 5 seconds
	</script>
</body>
</html>
