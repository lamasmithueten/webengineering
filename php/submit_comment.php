<?php
include('redirect.php');
include('access_database.php');


$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()){
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$comment = mysqli_real_escape_string($con, $_POST['comment']);
$account_id = $_SESSION['id'];
$thread_id = $_POST['threadid'];

$sqlquery = "INSERT INTO comments (id, id_thread, text, timestamp, id_account) VALUES (NULL, ?, ?, now(), ?)";
$stmt = $con->prepare($sqlquery);
$stmt->bind_param("isi", $thread_id, $comment, $account_id);
if($stmt->execute()){
	header("Location: https://webeng.mwerr.de/thread/$thread_id");
	exit;
}
else{
	echo "ERROR: "
	. $stmt->error;
}
$stmt->close();
mysqli_close($con);

?>
