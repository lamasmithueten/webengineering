<?php
	include('redirect.php');
	include("drawsite.php");

	$thread_id = $_GET['variable'];
	
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
drawThreadspage($thread_id);
?>
</body>
</html>
