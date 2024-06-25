<?php
	include('redirect.php');
	include("drawsite.php");

	$thread_id = $_GET['variable'];
	$con = openConnection();
	$rows = fetchThread($con, $thread_id);
	$threadTitle = isset($rows[0]['title']) ? $rows[0]['title'] : 'Default Title';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?php echo htmlspecialchars($threadTitle, ENT_QUOTES, 'UTF-8'); ?></title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="icon" href="../icon/icon.png">
</head>
<body>
<?php	
drawThreadspage($thread_id);
?>
<script src="../js/switchTheme.js"></script>
<script src="../js/likeComment.js"></script>
<script src="../js/likeThread.js"></script>
</body>
</html>
