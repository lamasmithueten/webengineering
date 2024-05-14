<?php
include("redirect.php");
include("sql.php");

$con = openConnection();

$comment_to_delete = $_POST['comment_id'];
$thread_id = $_POST['thread_id'];
deleteComment($con, $comment_to_delete);
closeConnection($con);
header("Location: /thread/$thread_id");
exit();

?>
