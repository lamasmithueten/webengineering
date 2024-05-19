<?php

include ("sql.php");
session_name("webeng_mwerr");
session_start();

$con=openConnection();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
	redirect();
} elseif (isset($_POST['username'], $_POST['password'])) {
	createSession();
} else {
	exit('Please fill both the username and password fields!');
}

function redirect()
{
	header('location:../mainpage');
}

function createSession()
{
	global $con, $id, $password;
	if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
		$stmt->bind_param('s', $_POST['username']);
		$stmt->execute();
		$stmt->store_result();
		if ($stmt->num_rows > 0) {
			$stmt->bind_result($id, $password);
			$stmt->fetch();
			//	if ($_POST['password'] === $password) {
			if (password_verify($_POST['password'], $password)) {
				session_regenerate_id();
				$_SESSION['loggedin'] = TRUE;
				$_SESSION['name'] = $_POST['username'];
				$_SESSION['id'] = $id;
				redirect();
			} else {
				//echo 'Incorrect password!';
				redirectLogin("Falscher Username und/oder falsches Passwort!");
			}
		} else {
			//echo 'Incorrect username!';
			redirectLogin("Falscher Username und/oder falsches Passwort!");
		}
		$stmt->close();
	}
}

closeConnection($con);

?>