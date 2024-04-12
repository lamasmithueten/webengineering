<?php

//Datenbank Anmeldeinformationen zur Datei hinzufügen
include("access_database.php");

//Aufbau der Verbindung zum Datenbankserver
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()){
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

//Entfernen von speziellen Characters in Email und Nutzernamen, Hashen des Passworts

$username = mysqli_real_escape_string($con, $_POST['username']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$email = mysqli_real_escape_string($con, $_POST['email']);

//Überprüfen, ob die Email valide ist

if( !filter_var ($email, FILTER_VALIDATE_EMAIL ) ){
	echo "Emailadresse $email ist keine gültige Emailadresse.\n";
	exit();
}

//Gucken, ob Nutzername schon in Verwendung ist

$sqlquery = "SELECT username FROM accounts WHERE username = '$username'";

$result = $con -> query($sqlquery);

if ($result ->num_rows>0){
	echo "Username $username ist schon in Verwendung.";
	echo '<br><a href="register.html">Zurück zum Registrieren</a><br><a href="indexx.html">Zurück zur Anmeldung</a><br>';
	exit();
}

//Gucken, ob Email schon in Verwendung ist

$sqlquery = "SELECT email FROM accounts WHERE email = '$email'";

$result = $con -> query($sqlquery);

if ($result ->num_rows>0){
	echo "Emailadresse $email ist schon in Verwendung.";
	echo '<br><a href="register.html">Zurück zum Registrieren</a><br><a href="indexx.html">Zurück zur Anmeldung</a><br>';
	exit();
}

//Erstellung des Eintrags in der Datenbank

$sqlquery = "INSERT INTO accounts VALUES ( NULL, '$username', '$password', '$email')" ;

if(mysqli_query($con, $sqlquery)){
	$text = "Dein Account $username wurde erfolgreich erstellt.\n";
	mail ($email, "Account aktiviert", $text );
	echo "<h3>Account registriert<h3>";
	echo nl2br ("\n$username\n $email\n ");
} 
else {
	echo "ERROR: "
	. mysqli_error($con);
}

//Schließen der Verbindung
mysqli_close($con);

?>
