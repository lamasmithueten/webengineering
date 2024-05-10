<?php
include("redirect.php");
include("sql.php");

$con = openConnection();

$thread_to_delete = $_POST['thread_id'];
deleteThread($con, $thread_to_delete);
header("Location: https://webeng.mwerr.de/mainpage");
exit();

closeConnection($con);
?>
