<?php
include ("sql.php");

$con=openConnection();

function authenticate(){
	global $con;
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
		closeConnection($con);
		redirect();
	} elseif (isset($_POST['username'], $_POST['password'])) {
		createSession();
	} else {
		addPostErrormessage('Please fill both the username and password fields!');
	}
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
			if (password_verify($_POST['password'], $password)) {
				session_regenerate_id();
				$_SESSION['loggedin'] = TRUE;
				$_SESSION['name'] = $_POST['username'];
				$_SESSION['id'] = $id;
				closeConnection($con);
				redirect();
			} else {
				addPostErrormessage("Falscher Username und/oder falsches Passwort!");
			}
		} else {
			addPostErrormessage("Falscher Username und/oder falsches Passwort!");
		}
		$stmt->close();
	}
}

?>