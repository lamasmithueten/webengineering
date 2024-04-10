<?php

include("access_database.php");
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()){
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$email = $_POST['email'];

$sqlquery = "INSERT INTO accounts VALUES ( NULL, '$username', '$password', '$email')" ;

if(mysqli_query($con, $sqlquery)){
	echo "<h3>Account registriert<h3>";
	echo nl2br ("\n$username\n $email\n ");
} 
else {
	echo "ERROR: "
	. mysqli_error($con);
}
mysqli_close($con);

?>
