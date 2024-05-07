<?php

function openConnection(){
	include("access_database.php");
	$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
	if (mysqli_connect_errno()){
		exit('Failed to connect to MySQL: ' . mysqli_connect_error());
	}
	return $con;
}


function fetchThreadsMainpage($con){
	$sqlquery = "SELECT username, text, timestamp, picture_path, title, threads.id FROM accounts JOIN threads ON accounts.id = threads.id_account order by timestamp DESC";
	$stmt = $con->prepare($sqlquery);
	$stmt->execute();
	$result = $stmt -> get_result();
	$rows = $result->fetch_all(MYSQLI_ASSOC);
	return $rows;
}

function closeConnection($con){
	mysqli_close($con);
}

function fetchThread($con, $thread_id){
	$sqlquery = "SELECT username, text, timestamp, picture_path, title, threads.id FROM accounts JOIN threads ON accounts.id = threads.id_account WHERE threads.id = ?";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("s", $thread_id);
	$stmt->execute();
	$result = $stmt->get_result();
	if ($result ->num_rows==0){
		header("Location: https://webeng.mwerr.de/");
		exit;
	}
	$rows=$result->fetch_all(MYSQLI_ASSOC);
	return $rows;
}

function fetchAllComments($con, $thread_id){
		$sqlquery = "select accounts.username, comments.text, comments.timestamp from accounts join comments on accounts.id=comments.id_account join threads on comments.id_thread=threads.id where threads.id=?";
		$stmt = $con->prepare($sqlquery);
		$stmt->bind_param("s", $thread_id);
		$stmt->execute();
		$result = $stmt -> get_result();
		$rows=$result->fetch_all(MYSQLI_ASSOC);
		return $rows;
}
?>
