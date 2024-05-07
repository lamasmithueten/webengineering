<?php

function openConnection(){
	include("access_database.php");
	$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
	if (mysqli_connect_errno()){
		exit('Failed to connect to MySQL: ' . mysqli_connect_error());
	}
	return $con;
}


function fetchThreads($con){
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

?>
