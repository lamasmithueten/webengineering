<?php
include("redirect.php");
include("sql.php");

$user = $_POST['user'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$con = openConnection();
update_password($con, $user, $password);
closeConnection($con);
header("Location: ../admin");
exit();


?>
