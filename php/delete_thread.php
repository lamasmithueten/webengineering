<?php
include("redirect.php");
include("sql.php");

$con = openConnection();

$thread_to_delete = $_POST['thread_id'];
deleteThread($con, $thread_to_delete);
closeConnection($con);
header("Location: ../index");
exit();

?>
