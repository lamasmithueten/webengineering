<?php
include("redirect.php");
include("access_database.php");


$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()){
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$title = mysqli_real_escape_string($con, $_POST['title']);
$text = mysqli_real_escape_string($con, $_POST['text']);
$name = $_SESSION['name'];

$sqlquery = "Select id from accounts where username = ?";
$stmt = $con->prepare($sqlquery);
$stmt->bind_param("s", $name );
$stmt->execute();
$result= $stmt -> get_result();
$id_array=$result->fetch_assoc();
$id = $id_array["id"];


$sqlquery = "INSERT INTO threads (id, text, id_account, timestamp, picture_path, title) VALUES (NULL, ?, ?, curdate(), NULL, ?)";
$stmt = $con->prepare($sqlquery);
$stmt->bind_param("sss", $text, $id, $title );
if ($stmt->execute()){
    header("Location: mainpage.html");
	
}
else{
	echo "ERROR: "
	. $stmt->error;
}



?>
