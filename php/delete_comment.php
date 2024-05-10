<?php
include("sql.php");

$con = openConnection();

$comment_to_delete = $_POST['comment_id'];
$thread_id = $_POST['thread_id'];
deleteComment($con, $comment_to_delete);
header("Location: https://webeng.mwerr.de/thread/$thread_id");
exit();

closeConnection($con);
?>
