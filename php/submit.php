<?php
include("redirect.php");
include("sql.php");


$con = openConnection();


$title = mysqli_real_escape_string($con, $_POST['title']);
$text = mysqli_real_escape_string($con, $_POST['text']);
$name = $_SESSION['name'];
$id = $_SESSION['id'];

$temp_file = $_FILES['image']['tmp_name'];
$filename = $_FILES['image']['name'];


if($filename != NULL){
	$filesize = $_FILES['image']['size'];
	$filetime = filemtime($_FILES['image']['tmp_name']);
	$filename = md5($_FILES['image']['name'] . $filesize . $filetime );
	$imagepath= __DIR__ . "/../pictures/";
	$fullpath= $imagepath . $filename;

	submitThreadWithPicture($con, $text, $id, $filename, $title, $temp_file, $fullpath);
}
else{

	submitThreadWithoutPicture($con, $text, $id, $title);

}
mysqli_close($con);

?>