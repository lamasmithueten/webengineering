<?php
	include('php/redirect.php');
	include('access_database.php');
	
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
			<img src="pictures/<?php echo $image;?>">
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
</body>
</html>
<?php mysqli_close($con); ?>
