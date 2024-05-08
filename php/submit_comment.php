<?php
include('redirect.php');
include('sql.php');


$con = openConnection();
$comment = mysqli_real_escape_string($con, $_POST['comment']);
$account_id = $_SESSION['id'];
$thread_id = $_POST['threadid'];

createComment($con, $thread_id, $comment, $account_id);

closeConnection($con);

?>
