<?php
	include('redirect.php');
	include("sql.php");
	include("drawsite.php");

	$userID = $_SESSION['id'];
	$thread_id = $_GET['variable'];
	
	$con = openConnection();
	$rows=fetchThread($con, $thread_id);
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
drawThread($rows);
drawSubmitComments($thread_id);
$rows=fetchAllComments($con, $thread_id);
drawComments($rows);
?>
</body>
</html>
<?php closeConnection($con); ?>
