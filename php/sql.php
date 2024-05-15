<?php

function openConnection()
{
	include ("access_database.php");
	$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
	if (mysqli_connect_errno()) {
		exit('Failed to connect to MySQL: ' . mysqli_connect_error());
	}
	return $con;
}


function fetchThreadsMainpage($con)
{
	$sqlquery = "SELECT username, text, timestamp, picture_path, title, threads.id, threads.id_account FROM accounts JOIN threads ON accounts.id = threads.id_account order by timestamp DESC";
	$stmt = $con->prepare($sqlquery);
	$stmt->execute();
	$result = $stmt->get_result();
	$rows = $result->fetch_all(MYSQLI_ASSOC);
	return $rows;
}

function closeConnection($con)
{
	mysqli_close($con);
}

function fetchThread($con, $thread_id)
{
	$sqlquery = "SELECT username, text, timestamp, picture_path, title, threads.id, threads.id_account FROM accounts JOIN threads ON accounts.id = threads.id_account WHERE threads.id = ?";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("s", $thread_id);
	$stmt->execute();
	$result = $stmt->get_result();
	if ($result->num_rows == 0) {
		header("Location: ../index");
		exit;
	}
	$rows = $result->fetch_all(MYSQLI_ASSOC);
	return $rows;
}

function fetchAllComments($con, $thread_id)
{
	$sqlquery = "select accounts.username, comments.text, comments.timestamp, comments.id_account, comments.id from accounts join comments on accounts.id=comments.id_account join threads on comments.id_thread=threads.id where threads.id=?";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("s", $thread_id);
	$stmt->execute();
	$result = $stmt->get_result();
	$rows = $result->fetch_all(MYSQLI_ASSOC);
	return $rows;
}

function checkUsernameTaken($con, $username)
{
	$sqlquery = "SELECT username FROM accounts WHERE username = ?";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("s", $username);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows > 0) {
		echo "Username $username ist schon in Verwendung.";
		echo '<br><a href="../register">Zurück zum Registrieren</a><br><a href="../index">Zurück zur Anmeldung</a><br>';
		exit();
	}
}

function checkEmailTaken($con, $email)
{
	$sqlquery = "SELECT email FROM accounts WHERE email = ?";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("s", $email);
	$stmt->execute();
	$result = $stmt->get_result();


	if ($result->num_rows > 0) {
		echo "Emailadresse $email ist schon in Verwendung.";
		echo '<br><a href="../register">Zurück zum Registrieren</a><br><a href="index">Zurück zur Anmeldung</a><br>';
		exit();
	}
}


function createUser($con, $username, $password, $email)
{
	$sqlquery = "INSERT INTO accounts (id, username, password, email) VALUES ( NULL, ?, ?, ?)";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("sss", $username, $password, $email);


	if ($stmt->execute()) {
		$text = "Dein Account $username wurde erfolgreich erstellt.\n";
		mail($email, "Account aktiviert", $text);
		echo "<h3>Account registriert<h3>";
		echo nl2br("\n$username\n $email\n ");
		echo '<br><a href="index">Zurück zur Anmeldung</a><br>';
	} else {
		echo "ERROR: "
			. $stmt->error;
	}
}

function createComment($con, $thread_id, $comment, $account_id)
{
	$sqlquery = "INSERT INTO comments (id, id_thread, text, timestamp, id_account) VALUES (NULL, ?, ?, now(), ?)";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("isi", $thread_id, $comment, $account_id);
	if ($stmt->execute()) {
		header("Location: /thread/$thread_id");
		exit;
	} else {
		echo "ERROR: "
			. $stmt->error;
	}
	$stmt->close();
}

function submitThreadWithPicture($con, $text, $id, $filename, $title, $temp_file, $fullpath)
{
	$sqlquery = "INSERT INTO threads (id, text, id_account, timestamp, picture_path, title) VALUES (NULL, ?, ?, now(), ?, ?)";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("siss", $text, $id, $filename, $title);

	if (move_uploaded_file($temp_file, $fullpath)) {
		if ($stmt->execute()) {
			header("Location: ../mainpage.html");

		} else {
			echo "ERROR: "
				. $stmt->error;
		}

	} else {
		echo "Failed to move your image.\n";
	}
}

function submitThreadWithoutPicture($con, $text, $id, $title)
{
	$sqlquery = "INSERT INTO threads (id, text, id_account, timestamp, picture_path, title) VALUES (NULL, ?, ?, now(), NULL, ?)";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("sss", $text, $id, $title);
	if ($stmt->execute()) {
		header("Location: ../mainpage.html");

	} else {
		echo "ERROR: "
			. $stmt->error;
	}
}

function deleteComment($con, $comment_to_delete){
	$sqlquery = "DELETE FROM comments WHERE id=?";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("i", $comment_to_delete);
	$stmt->execute();
}



function deleteAllComments($con, $comments_to_delete){
	$sqlquery = "DELETE FROM comments WHERE id_thread=?";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("i", $comments_to_delete);
	$stmt->execute();
}

function deleteThread($con, $thread_to_delete){
	deleteAllComments($con, $thread_to_delete);
	deletePic($con, $thread_to_delete);
	$sqlquery = "DELETE FROM threads WHERE id=?";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("i", $thread_to_delete);
	$stmt->execute();
}

function deletePic($con, $thread_id){
	$sqlquery = "SELECT picture_path FROM threads WHERE id = ?";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("s", $thread_id);
	$stmt->execute();
	$result = $stmt->get_result();
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$file=  __DIR__ . "/../pictures/" . $row["picture_path"];
		unlink($file);
	}
}


?>