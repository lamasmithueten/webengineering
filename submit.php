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

$temp_file = $_FILES['image']['tmp_name'];
$filename = $_FILES['image']['name'];
$imagepath= '/webserver/webengineering/pictures/';
$fullpath= $imagepath . $filename;

$sqlquery = "SELECT id FROM accounts WHERE username = ?";
$stmt = $con->prepare($sqlquery);
$stmt->bind_param("s", $name );
$stmt->execute();
$result= $stmt -> get_result();
$id_array=$result->fetch_assoc();
$id = $id_array["id"];


$sqlquery = "INSERT INTO threads (id, text, id_account, timestamp, picture_path, title) VALUES (NULL, ?, ?, now(), ?, ?)";
$stmt = $con->prepare($sqlquery);
$stmt->bind_param("ssss", $text, $id, $filename , $title );

	echo 'File count=', count($_FILES), "\n";

	echo '<pre>';
	var_dump($_FILES);
	echo '</pre>';
	echo "<p>1. $filename 2.  $imagepath 3.  $temp_file</p>";

if (move_uploaded_file( $temp_file, $fullpath )){
	if ($stmt->execute()){
	    header("Location: mainpage.html");
		
	}
	else{
		echo "ERROR: "
		. $stmt->error;
	}

} else {
	echo "Failed to move your image.\n";	
	echo "Not uploaded because of error #".$_FILES['image']['error'];
}


?>
