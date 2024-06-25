<?php

include("redirect.php");
include("sql.php");

$con = openConnection();
$id_thread = $_POST['thread_id'];
$id_user = $_SESSION['id'];
$action = $_POST['action'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if ($action === 'like') {
		createLikeThread($con, $id_user, $id_thread);
	}
	else if ($action === 'unlike') {
		deleteLikeThread($con, $id_user, $id_thread);
	}
	$like_count = getLikeCountThread($con, $id_thread);
	echo json_encode(['like_count' => $like_count]);	
}

closeConnection($con);

?>
