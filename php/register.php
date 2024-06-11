<?php
session_start();
//Datenbank Anmeldeinformationen zur Datei hinzufügen
include("sql.php");

//Überprüfen, ob die Email valide ist

function checkValidEmail($con, $email ){
	if( !filter_var ($email, FILTER_VALIDATE_EMAIL ) ){
		//redirectRegistration("Emailadresse $email ist keine gültige Emailadresse.\n");
		addPostErrormessage("$email is not a valid e-mail adress!");
		return false;
	}
	return true;
}

function comparePassword() {
	return $_POST['password'] == $_POST['password2'];
}

function registerUser() {
	if(!comparePassword()){
		addPostErrormessage("Passwords must be the same!");
		return false;
	}
//Aufbau der Verbindung zum Datenbankserver
$con = openConnection();
//Entfernen von speziellen Characters in Email und Nutzernamen, Hashen des Passworts

$username = mysqli_real_escape_string($con, $_POST['username']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$email = mysqli_real_escape_string($con, $_POST['email']);

if(!checkValidEmail($con, $email))
{
	//Schließen der Verbindung
	closeConnection($con);
	addPostErrormessage("$email is not a valid e-mail adress!");
	return false;
}
//Gucken, ob Nutzername schon in Verwendung ist
if(checkUsernameTaken($con, $username))
{
	//Schließen der Verbindung
	closeConnection($con);
	addPostErrormessage("$username is already taken!");
	return false;
}

//Gucken, ob Email schon in Verwendung ist
If(checkEmailTaken($con, $email))
{
	//Schließen der Verbindung
	closeConnection($con);
	addPostErrormessage("$email is arleady taken!");
	return false;
}

//Erstellung des Eintrags in der Datenbank
if(createUser($con, $username, $password, $email)){
	//Schließen der Verbindung
	closeConnection($con);
	redirectSuccessfulRegistration("The account for $username was created!");
}
}

?>
