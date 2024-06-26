<?php
include("authenticationRedirect.php");

function openConnection()
{
	include ("access_database.php");
	$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
	if (mysqli_connect_errno()) {
		exit('Failed to connect to MySQL: ' . mysqli_connect_error());
	}
	return $con;
}


function fetchThreadsMainpage($con) //Keine Filterung notwendig auf Mainpage. Bei der Searchpage wird noch ein WHERE am Ende ergänzt
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

function fetchThread($con, $thread_id)  //Informationen eines einzelnen Threads für die indivdiduelle Threadseite (/thread/$THREADNUMMER)
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

function fetchAllComments($con, $thread_id) //Kommentare unterhalb der Threads
{
	$sqlquery = "SELECT accounts.username, comments.text, comments.timestamp, comments.id_account, comments.id FROM accounts JOIN comments ON accounts.id=comments.id_account JOIN threads ON comments.id_thread=threads.id WHERE threads.id=? ORDER BY comments.timestamp DESC";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("s", $thread_id);
	$stmt->execute();
	$result = $stmt->get_result();
	$rows = $result->fetch_all(MYSQLI_ASSOC);
	return $rows;
}

//Relevant für Validierung bei Accountregistrierung

function checkUsernameTaken($con, $username)
{
	$sqlquery = "SELECT username FROM accounts WHERE username = ?";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("s", $username);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows > 0) {
		return true;
	}
	return false;
}

function checkEmailTaken($con, $email)
{
	$sqlquery = "SELECT email FROM accounts WHERE email = ?";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("s", $email);
	$stmt->execute();
	$result = $stmt->get_result();


	if ($result->num_rows > 0) {
		return true;
	}
	return false;
}


function createUser($con, $username, $password, $email)
{
	$sqlquery = "INSERT INTO accounts (id, username, password, email) VALUES ( NULL, ?, ?, ?)";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("sss", $username, $password, $email);


	if ($stmt->execute()) {
		$text = "Dein Account $username wurde erfolgreich erstellt.\n";
		mail($email, "Account aktiviert", $text);
		return true;
	} else {
		echo "ERROR: "
			. $stmt->error;
			return false;
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

//Je nachdem, ob der Thread ein Bild hat oder nicht, muss eine unterschiedliche SQL-Abfrage passieren

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

//Die Datenbank ist sehr hierarchisch mit ihren Integrity Constraints: account -> thread -> kommentar -> Likes

function deleteComment($con, $comment_to_delete){
	deleteAllLikesComment($con, $comment_to_delete);		//Integrity Constraint in Tabelle verlangt löschen aller Likes vorher. Gleiche Prinzip bei den anderen Löschfunktionen
	$sqlquery = "DELETE FROM comments WHERE id=?";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("i", $comment_to_delete);
	$stmt->execute();
}

function deleteAllLikesComment($con, $comment_to_delete){
	$sqlquery = "DELETE FROM comment_likes WHERE id_comment=?";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("i", $comment_to_delete);
	$stmt->execute();
}




function deleteAllComments($con, $comments_to_delete){

	$sqlquery = "SELECT id FROM comments WHERE id_thread=?";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("i", $comments_to_delete);
	$stmt->execute();
	$result = $stmt->get_result();
	$rows = $result->fetch_all(MYSQLI_ASSOC);
	foreach ($rows as $fieldname => $arrayEntry) {
		deleteAllLikesComment($con, $arrayEntry['id']);
	}

	$sqlquery = "DELETE FROM comments WHERE id_thread=?";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("i", $comments_to_delete);
	$stmt->execute();
}

function deleteThread($con, $thread_to_delete){
	deleteAllComments($con, $thread_to_delete);
	deletePic($con, $thread_to_delete);
	$sqlquery = "DELETE FROM thread_likes WHERE id_thread=?";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("i", $thread_to_delete);
	$stmt->execute();
	
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

function createLikeComment($con, $id_user, $id_comment){
        $sqlquery = "INSERT INTO comment_likes (id_user, id_comment) VALUES (?, ?)";
        $stmt = $con->prepare($sqlquery);
        $stmt->bind_param("ii", $id_user, $id_comment);
        $stmt->execute();
	$stmt->close();
}

function deleteLikeComment($con, $id_user, $id_comment){
        $sqlquery = "DELETE FROM comment_likes WHERE id_user = ? AND id_comment = ?";
        $stmt = $con->prepare($sqlquery);
        $stmt->bind_param("ii", $id_user, $id_comment);
        $stmt->execute();
        $stmt->close();
}

function getLikeCountComment($con, $id_comment){
	$sqlquery = "SELECT COUNT(*) as like_count FROM comment_likes WHERE id_comment = ?";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("i", $id_comment);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();
	$like_count = $row['like_count'];
	$stmt->close();
	return $like_count;
}

function isLiked($con, $id_comment, $id_user){
	$sqlquery = "SELECT COUNT(*) AS like_count FROM comment_likes WHERE id_comment = ? AND id_user = ? ";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("ii", $id_comment, $id_user);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();
	$like_count = $row['like_count'];
	$stmt->close();
	if ($like_count >0)
	{
		return true;
	}
	else
	{
		return false;
	}

}

function createLikeThread($con, $id_user, $id_thread){
        $sqlquery = "INSERT INTO thread_likes (id_user, id_thread) VALUES (?, ?)";
        $stmt = $con->prepare($sqlquery);
        $stmt->bind_param("ii", $id_user, $id_thread);
        $stmt->execute();
	$stmt->close();
}

function deleteLikeThread($con, $id_user, $id_thread){
        $sqlquery = "DELETE FROM thread_likes WHERE id_user = ? AND id_thread = ?";
        $stmt = $con->prepare($sqlquery);
        $stmt->bind_param("ii", $id_user, $id_thread);
        $stmt->execute();
        $stmt->close();
}

function getLikeCountThread($con, $id_thread){
	$sqlquery = "SELECT COUNT(*) as like_count FROM thread_likes WHERE id_thread = ?";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("i", $id_thread);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();
	$like_count = $row['like_count'];
	$stmt->close();
	return $like_count;
}

function isLikedThread($con, $id_thread, $id_user){			//Zum Setzen der Checkbox, ob schon geliked wurde von Person oder nicht
	$sqlquery = "SELECT COUNT(*) AS like_count FROM thread_likes WHERE id_thread = ? AND id_user = ? ";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("ii", $id_thread, $id_user);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();
	$like_count = $row['like_count'];
	$stmt->close();
	if ($like_count >0)
	{
		return true;
	}
	else
	{
		return false;
	}

}


function fetchThreadsSearchpage($con, $search)
{
	$search_phrase = "%$search%";
	$sqlquery = "SELECT username, text, timestamp, picture_path, title, threads.id, threads.id_account FROM accounts JOIN threads ON accounts.id = threads.id_account WHERE text LIKE ? OR title LIKE ? ORDER BY timestamp DESC";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("ss", $search_phrase, $search_phrase);
	$stmt->execute();
	$result = $stmt->get_result();
	$rows = $result->fetch_all(MYSQLI_ASSOC);
	return $rows;
}

function fetchAccountsInfo($con)
{
	$sqlquery = "SELECT username, email, id FROM accounts";
	$stmt = $con->prepare($sqlquery);
	$stmt->execute();
	$result = $stmt->get_result();
	$rows = $result->fetch_all(MYSQLI_ASSOC);
	return $rows;
}

//Beim Löschen von Accounts müssen auch die entsprechenden Likes und Beiträge gelöscht werden, damit die Integrity Constraints nicht verletzt werden

function deleteAccount($con, $id){	
	deleteAllLikesUser($con, $id);
	deleteAllCommentsUser($con, $id);
	$sqlquery = "SELECT id FROM threads WHERE id_account=?";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$result = $stmt->get_result();
	$rows = $result->fetch_all(MYSQLI_ASSOC);
	foreach ($rows as $fieldname => $arrayEntry) {
		deleteThread($con, $arrayEntry['id']);
	}
	$sqlquery = "DELETE FROM accounts WHERE id=?";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("i", $id);
	$stmt->execute();
}

function deleteAllLikesUser($con, $id){
	$sqlquery = "DELETE FROM comment_likes WHERE id_user=?";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$sqlquery = "DELETE FROM thread_likes WHERE id_user=?";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("i", $id);
	$stmt->execute();
}

function deleteAllCommentsUser($con, $id){
	$sqlquery = "DELETE FROM comments WHERE id_account=?";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("i", $id);
	$stmt->execute();
}

function updateEmail($con, $id, $email){
	$sqlquery = "UPDATE accounts SET email = ?  WHERE id=?";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("si", $email, $id);
	$stmt->execute();
}

function update_password($con, $id, $password){
	$sqlquery = "UPDATE accounts SET password = ?  WHERE id=?";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("si", $password, $id);
	$stmt->execute();
}


?>
