<?php
include('access_database.php');


$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()){
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$comment = 'lul';
$account_id = 1;
$thread_id = 20;

$sqlquery = "INSERT INTO comments (id, id_thread, text, timestamp, id_account) VALUES (NULL, ?, ?, now(), ?)";
$stmt = $con->prepare($sqlquery);
$stmt->bind_param("isi", $thread_id, $comment, $account_id);
if($stmt->execute()){
//	echo "<p>$thread_id</p>";
//	echo "<p>$comment</p>";
//	echo "<p>$account_id</p>";
}
else{
	echo "ERROR: "
	. $stmt->error;
}
$stmt->close();
mysqli_close($con);

?>
