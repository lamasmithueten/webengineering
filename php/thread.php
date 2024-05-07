<?php
	include('redirect.php');
	include('access_database.php');

	$userID = $_SESSION['id'];
	
	$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
	if (mysqli_connect_errno()){
		exit('Failed to connect to MySQL: ' . mysqli_connect_error());
	}
	$thread_id = $_GET['variable'];
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title></title>
		<link rel="stylesheet" type="text/css" href="../css/thread.css">
</head>
<body>
	<p>Thread</p>
<?php	
foreach ($rows as $fieldname => $arrayEntry) {
	echo '<div class="thread">';
	echo '<div class="title">' . str_replace(array('\r\n', '\n\r', '\n', '\r'), '<br>', $arrayEntry['title']) . '</div>';
	echo '<div class="post">';
	if (isset($arrayEntry['picture_path'])) {
		$image = $arrayEntry['picture_path'];
		echo '<div class="image"><img src="https://webeng.mwerr.de/pictures/' . $image . '"></div>';
	}
	echo '<div class="text">' . str_replace(array('\r\n', '\n\r', '\n', '\r'), '<br>', $arrayEntry['text']) . '</div>';
	echo '</div>'; 
	echo '<div class="user_info">';
	echo '<div class="username">' . $arrayEntry['username'] . '</div>';
	echo '<div class="timestamp">' . $arrayEntry['timestamp'] . '</div>';
	echo '</div>'; 
	echo '</div>'; 
}

echo '<div class="comment-form">';
echo '<p>Submit a comment</p>';
echo '<form action="https://webeng.mwerr.de/php/submit_comment.php" method="post" enctype="multipart/form-data">';
echo '<textarea id="comment" name="comment" maxlength="65535" required></textarea>';
echo '<input type="hidden" name="threadid" id="threadid" value="' . $thread_id . '"/>'; 
echo '<input type="submit" value="submit"/>';
echo '</form>';
echo '</div>';
		$sqlquery = "select accounts.username, comments.text, comments.timestamp from accounts join comments on accounts.id=comments.id_account join threads on comments.id_thread=threads.id where threads.id=?";
		$stmt = $con->prepare($sqlquery);
		$stmt->bind_param("s", $thread_id);
		$stmt->execute();
		$result = $stmt -> get_result();
		$rows=$result->fetch_all(MYSQLI_ASSOC);

echo '<div class="comments">';
echo '<p>Comments</p>';
foreach ($rows as $fieldname => $arrayEntry) {
	echo '<div class="comment">';
	echo '<div class="comment-text">' . str_replace(array('\r\n', '\n\r', '\n', '\r'), '<br>', $arrayEntry['text']) . '</div>';
	echo '<div class="comment-info">';
	echo '<span class="comment-username">' . $arrayEntry['username'] . '</span>';
	echo '<span class="comment-timestamp">' . $arrayEntry['timestamp'] . '</span>';
	echo '</div>'; 
	echo '</div>'; 
}
echo '</div>'; 
	?>
</body>
</html>
<?php mysqli_close($con); ?>
