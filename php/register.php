<?php

//Datenbank Anmeldeinformationen zur Datei hinzufügen
include("sql.php");

//Aufbau der Verbindung zum Datenbankserver
$con = openConnection();
//Entfernen von speziellen Characters in Email und Nutzernamen, Hashen des Passworts

$username = mysqli_real_escape_string($con, $_POST['username']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$email = mysqli_real_escape_string($con, $_POST['email']);

//Überprüfen, ob die Email valide ist

function checkValidEmail($con, $email ){
	if( !filter_var ($email, FILTER_VALIDATE_EMAIL ) ){
		redirectRegistration("Emailadresse $email ist keine gültige Emailadresse.\n");
		exit();
	}
}

checkValidEmail($con, $email);
//Gucken, ob Nutzername schon in Verwendung ist
checkUsernameTaken($con, $username);


//Gucken, ob Email schon in Verwendung ist
checkEmailTaken($con, $email);

//Erstellung des Eintrags in der Datenbank
createUser($con, $username, $password, $email);

//Schließen der Verbindung
closeConnection($con);

?>
