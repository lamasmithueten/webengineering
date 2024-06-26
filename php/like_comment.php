<?php

include("redirect.php");
include("sql.php");

$con = openConnection();
$id_comment = $_POST['comment_id'];
$id_user = $_SESSION['id'];
$action = $_POST['action'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if ($action === 'like') {
		createLikeComment($con, $id_user, $id_comment);
	}
	else if ($action === 'unlike') {
		deleteLikeComment($con, $id_user, $id_comment);
	}
	$like_count = getLikeCountComment($con, $id_comment);
	echo json_encode(['like_count' => $like_count]);	
}

closeConnection($con);

?>
