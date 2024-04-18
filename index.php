<?php
session_name("webeng_mwerr");
session_start();
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<?php
	if (isset($_SESSION['logggedin']) && $_SESSION['loggedin']) {
		header('location:mainpage.html');
	} else {
		?>
		<div class="login">
			<h1>Login</h1>
			<form action="authenticate.php" method="post">
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="username" placeholder="Username" id="username" required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Password" id="password" required>
				<input type="submit" value="Login">
			</form>
			<div class="register-link">
				<a href="register.html">register new account</a>
			</div>
		</div>
	<?php } ?>
</body>

</html>