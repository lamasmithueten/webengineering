<?php
	include('redirect.php');
	include('access_database.php');

	$userID = $_SESSION['id'];;
	
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
	$rows=$result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title></title>
</head>
<body>
	<p>Thread</p>
<?php	
	foreach ($rows as $fieldname => $arrayEntry){
		echo "<table>";
		echo '<tr><td>';
		echo $arrayEntry['title'];
		echo "</td></tr><tr>";
		if (isset($arrayEntry['picture_path'])){
		$image = $arrayEntry['picture_path'];
?>
		<td>
		<img src="https://webeng.mwerr.de/pictures/<?php echo $image;?>">
<?php
			echo "</td>";
		}
		echo "<td>";
		echo $arrayEntry['text'];
		echo "</td></tr><tr><td>";
		echo $arrayEntry['username'];
		echo "</td><td>";
		echo $arrayEntry['timestamp'];
		echo "</td></tr>";
		echo "</table>";
		echo "<br>";
		echo "<br>";
	}
?>
	<br><br><br>
	<p>Submit a comment</p>
	<form action="https://webeng.mwerr.de/php/submit_comment.php" method="post" enctype="multipart/form-data">
	<textarea id="comment" name="comment" maxlength="65535" required></textarea>
	<input type="hidden" name="threadid" id="threadid" value="<?php echo $thread_id ?>"/>
	<input type="submit" value="submit"/>
	</form>	
	<br><br><br>
	<p>Comments</p>
	<?php
		$sqlquery = "select accounts.username, comments.text, comments.timestamp from accounts join comments on accounts.id=comments.id_account join threads on comments.id_thread=threads.id where threads.id=?";
		$stmt = $con->prepare($sqlquery);
		$stmt->bind_param("s", $thread_id);
		$stmt->execute();
		$result = $stmt -> get_result();
		$rows=$result->fetch_all(MYSQLI_ASSOC);

		foreach ($rows as $fieldname => $arrayEntry){
			echo "<table>";
			echo "<tr><td>";
			echo $arrayEntry['text'];
			echo "</td></tr><tr><td>";
			echo $arrayEntry['username'];
			echo "</td><td>";
			echo $arrayEntry['timestamp'];
			echo "</td></tr></table>";
		}
	?>
</body>
</html>
<?php mysqli_close($con); ?>
