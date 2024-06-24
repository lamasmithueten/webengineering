<?php
include ("redirect.php");
include ("sql.php");

$con = openConnection();
$id = $_POST['user'];
deleteAccount($con, $id);
closeConnection($con);
header("Location: ../admin");
exit();

?>
