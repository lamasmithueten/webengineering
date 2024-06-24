<?php
include("redirect.php");
include("sql.php");

$user = $_POST['user'];
$con = openConnection();
$email = mysqli_real_escape_string($con, $_POST['email']);
updateEmail($con, $user, $email);
closeConnection($con);
header("Location: ../admin");
exit();


?>
