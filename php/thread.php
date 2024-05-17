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
		<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
<?php	
drawThreadspage($thread_id);
?>
</body>
</html>
