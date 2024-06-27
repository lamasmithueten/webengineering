<?php

include ("sql.php");

function drawThreadsMainpage()	//Startseite
{
	$con = openConnection();
	$rows = fetchThreadsMainpage($con);				//Alle notwendigen Infos der Threads in Array abspeichern
	//Banner 
	echo '<div class="banner">';
	echo '<div class="submit-link">';
	echo '	<a href="submit.html">Submit a new Thread</a>';
	echo '</div>';
	if ($_SESSION['id'] == 1){
		echo '<div class="admin-link">';
		echo '<a href="admin.html">Admin</a>';
		echo '</div>';
	}
	drawSearch();
	drawLogoutButton();
	drawThemeSlider();
	echo '</div>';
	//Banner Ende, Anzeigen der Threads
	drawThreads($rows, $con);
	closeConnection($con);
}

function drawThreadsPage($thread_id)	//Ganze Threadseite bauen
{
	$con = openConnection();
	$rows = fetchThread($con, $thread_id);
	$threadTitle = isset($rows[0]['title']) ? $rows[0]['title'] : 'Default Title';

	//Banner
	echo '<div class="banner">';
	echo '<a href="index.html" class="index-link">Threads</a>';
	drawLogoutButton();
	drawThemeSlider();
	echo '</div>';
	//Thread
	drawThread($rows, $thread_id, $con);
	drawSubmitComments($thread_id);
	//Kommentare
	$rows = fetchAllComments($con, $thread_id);
	drawComments($rows, $thread_id, $con);
	closeConnection($con);
}

function drawThread($rows, $thread_id, $con) //Baut einzelnen Thread auf Threadpage
{
	foreach ($rows as $fieldname => $arrayEntry) {
		echo '<div class="thread" data-thread-id="' . $arrayEntry['id'] . '">';
		echo '<div class="title">' . str_replace(array('\r\n', '\n\r', '\n', '\r'), '<br>', $arrayEntry['title']) . '</div>';
		echo '<div class="post">';
		if (isset($arrayEntry['picture_path'])) {
			$image = $arrayEntry['picture_path'];
			echo '<div class="image"><img src="../pictures/' . $image . '"></div>';
		}
		echo '<div class="text">' . str_replace(array('\r\n', '\n\r', '\n', '\r'), '<br>', $arrayEntry['text']) . '</div>';
		echo '</div>';
		echo '<div class="user_info">';
		echo '<div class="username-likes">';
		drawLikesThread($con, $arrayEntry);
		echo '<span class="thread-username">' . $arrayEntry['username'] . '</span>';
		echo '</div>';
		echo '<div class="timestamp">' . $arrayEntry['timestamp'] . '</div>';
		echo '</div>';
		//L�schknopf nur f�r Verfasser und Admin erstellen
		if(isset($_SESSION['id']) && $_SESSION['id'] == $arrayEntry['id_account'] || $_SESSION['id'] == 1 ) {
		    echo '<form class="delete-button" action="../php/delete_thread.php" method="post">';
		    echo '<input type="hidden" name="thread_id" value="' . $thread_id . '">';
		    echo '<button type="submit">Delete</button>';
		    echo '</form>';
		}
		echo '</div>';
	}

}
function drawSubmitComments($thread_id)		//Erstellt das Inputfeld f�r neue Kommentare
{
	echo '<div class="comment-form">';
	echo '<p>Submit a comment</p>';
	echo '<form action="../php/submit_comment.php" method="post" enctype="multipart/form-data">';
	echo '<textarea id="comment" name="comment" maxlength="65535" required></textarea>';
	echo '<input type="hidden" name="threadid" id="threadid" value="' . $thread_id . '"/>';
	echo '<input type="submit" value="submit"/>';
	echo '</form>';
	echo '</div>';
}

function drawComments($rows, $thread_id, $con)		//Erstellt die Kommentare unter einem Thread
{
	echo '<div class="comments" data-user-id="' . $_SESSION['id'] . '">';
	echo '<p>Comments</p>';
	foreach ($rows as $fieldname => $arrayEntry) {
		echo '<div class="comment" data-comment-id="' . $arrayEntry['id'] . '">';
		echo '<div class="comment-text">' . str_replace(array('\r\n', '\n\r', '\n', '\r'), '<br>', $arrayEntry['text']) . '</div>';
		echo '<div class="comment-info">';
		echo '<div class="username-likes">'; // Neue div hinzuf�gen
		drawLikes($con, $arrayEntry);
		echo '<span class="comment-username">' . $arrayEntry['username'] . '</span>';
		echo '</div>'; // Schlie�en Sie die neue div
		echo '<span class="comment-timestamp">' . $arrayEntry['timestamp'] . '</span>';
		if(isset($_SESSION['id']) && $_SESSION['id'] == $arrayEntry['id_account'] || $_SESSION['id'] == 1) {	//Ersteller des Kommentars und der Admin d�rfen den Kommentar l�schen
		    echo '<form class="delete-button" action="../php/delete_comment.php" method="post">';
		    echo '<input type="hidden" name="comment_id" value="' . $arrayEntry['id'] . '">';
		    echo '<input type="hidden" name="thread_id" value="' . $thread_id . '">';
		    echo '<button type="submit">Delete</button>';
		    echo '</form>';
		}
		echo '</div>';
		echo '</div>';
	}
	echo '</div>';
}

function drawLogoutButton(){
	echo '<div class="logout-button">';
	if ($_SERVER['REQUEST_URI']=="/mainpage"){
		echo '<form class="logout-button" action="php/logout.php" method="post">';
	}
	else{
		echo '<form class="logout-button" action="../php/logout.php" method="post">';
	}
	echo '<button type="submit">Logout</button>';
	echo '</form>';
	echo '</div>';
}

function drawThemeSlider(){			//Knopf zum Umschalten zwischen Dark und Lightmode
	echo '<div class="theme-slider">';
	echo '<label class="switch">';
	echo '<input type="checkbox" id="themeSwitch">';
	echo '<span class="slider round"></span>';
	echo '</label>';
	echo '</div>';
}

function drawLikes($con, $arrayEntry) {			//Baut Likes unter Kommentaren
    echo '<div class="like-container">';
    echo '<input type="checkbox" id="like-checkbox-' . $arrayEntry['id'] . '" class="like-checkbox"';
    if (isLiked($con, $arrayEntry['id'], $_SESSION['id']) == true) {
        echo ' checked';
    }
    echo '>';
    echo '<label for="like-checkbox-' . $arrayEntry['id'] . '" class="like-label">';
	echo '<svg height="24" viewBox="0 0 1792 1792" width="24" xmlns="http://www.w3.org/2000/svg" class="thumb-up">';
	echo '<path d="M320 1344q0-26-19-45t-45-19q-27 0-45.5 19t-18.5 45q0 27 18.5 45.5t45.5 18.5q26 0 45-18.5t19-45.5zm160-512v640q0 26-19 45t-45 19h-288q-26 0-45-19t-19-45v-640q0-26 19-45t45-19h288q26 0 45 19t19 45zm1184 0q0 86-55 149 15 44 15 76 3 76-43 137 17 56 0 117-15 57-54 94 9 112-49 181-64 76-197 78h-129q-66 0-144-15.5t-121.5-29-120.5-39.5q-123-43-158-44-26-1-45-19.5t-19-44.5v-641q0-25 18-43.5t43-20.5q24-2 76-59t101-121q68-87 101-120 18-18 31-48t17.5-48.5 13.5-60.5q7-39 12.5-61t19.5-52 34-50q19-19 45-19 46 0 82.5 10.5t60 26 40 40.5 24 45 12 50 5 45 .5 39q0 38-9.5 76t-19 60-27.5 56q-3 6-10 18t-11 22-8 24h277q78 0 135 57t57 135z"/>';
	echo '</svg>';
	echo '</label>';
    echo '<span class="like-count">';
    $like_count = getLikeCountComment($con, $arrayEntry['id']);
    echo "$like_count";
    echo '</span>';
    echo '</div>';
}


function drawLikesThread($con, $arrayEntry) {		//Baut Likes von Threads
    echo '<div class="like-container">';
    echo '<input type="checkbox" id="like-checkbox-' . $arrayEntry['id'] . '" class="like-checkbox"';
    if (isLikedThread($con, $arrayEntry['id'], $_SESSION['id']) == true) {
        echo ' checked';
    }
    echo '>';
    echo '<label for="like-checkbox-' . $arrayEntry['id'] . '" class="like-label">';
	echo '<svg height="24" viewBox="0 0 1792 1792" width="24" xmlns="http://www.w3.org/2000/svg" class="thumb-up">';
	echo '<path d="M320 1344q0-26-19-45t-45-19q-27 0-45.5 19t-18.5 45q0 27 18.5 45.5t45.5 18.5q26 0 45-18.5t19-45.5zm160-512v640q0 26-19 45t-45 19h-288q-26 0-45-19t-19-45v-640q0-26 19-45t45-19h288q26 0 45 19t19 45zm1184 0q0 86-55 149 15 44 15 76 3 76-43 137 17 56 0 117-15 57-54 94 9 112-49 181-64 76-197 78h-129q-66 0-144-15.5t-121.5-29-120.5-39.5q-123-43-158-44-26-1-45-19.5t-19-44.5v-641q0-25 18-43.5t43-20.5q24-2 76-59t101-121q68-87 101-120 18-18 31-48t17.5-48.5 13.5-60.5q7-39 12.5-61t19.5-52 34-50q19-19 45-19 46 0 82.5 10.5t60 26 40 40.5 24 45 12 50 5 45 .5 39q0 38-9.5 76t-19 60-27.5 56q-3 6-10 18t-11 22-8 24h277q78 0 135 57t57 135z"/>';
	echo '</svg>';
	echo '</label>';
    echo '<span class="like-count">';
    $like_count = getLikeCountThread($con, $arrayEntry['id']);
    echo "$like_count";
    echo '</span>';
    echo '</div>';
}


function drawSearch(){			//Suchleiste
    echo '<form action="search" method="post">';
    echo '<div class="search-container">';
    echo '<div class="search-bar">';
    echo '<input type="text" name="search" placeholder="Search" id="search" maxlength="255"/>';
    echo '</div>';
    echo '<div class="search-button">';
    echo '<input type="submit" value="Search" />';
    echo '</div>';
    echo '</div>';
    echo '</form>';
}

function drawThreads($rows, $con){		//Baut alle Threads auf der Mainpage und alle relevanten Threads auf der Searchpage
		foreach ($rows as $fieldname => $arrayEntry) {
			echo '<div class="thread" data-thread-id="' . $arrayEntry['id'] . '">';
			echo '<div class="title"><a href="thread/' .
				$arrayEntry["id"] .
				'">';
			echo str_replace(
				['\r\n', '\n\r', '\n', '\r'],
				"<br>",
				$arrayEntry["title"]
			);
			echo "</a></div>";

			echo '<div class="post">';
			if (isset($arrayEntry["picture_path"])) {
				$image = $arrayEntry["picture_path"];
				echo '<div class="image"><img src="../pictures/' .
					$image .
					'"></div>';
			}
			echo '<div class="text">' .
				str_replace(
					['\r\n', '\n\r', '\n', '\r'],
					"<br>",
					$arrayEntry["text"]
				) .
				"</div>";
			echo "</div>";

			echo '<div class="user_info">';
			echo '<div class="username-likes">'; // Neue div hinzuf�gen
			drawLikesThread($con, $arrayEntry);
			echo '<span class="thread-username">' . $arrayEntry['username'] . '</span>';
			echo '</div>';
			echo '<div class="timestamp">' .
				$arrayEntry["timestamp"] .
				"</div>";
			echo "</div>";
			if(isset($_SESSION['id']) && $_SESSION['id'] == $arrayEntry['id_account'] || $_SESSION['id'] ==1 ) {
				echo '<form class="delete-button" action="php/delete_thread.php" method="post">';
				echo '<input type="hidden" name="thread_id" value="' . $arrayEntry["id"] . '">';
				echo '<button type="submit">Delete</button>';
				echo '</form>';
			}

			echo "</div>";
			echo "<br>";
		}
}

function drawThreadsSearchpage()	//Baut die Searchpage 
{
	$con = openConnection();
	$search = mysqli_real_escape_string($con, $_POST['search']);
	$rows = fetchThreadsSearchpage($con, $search);
	echo '<div class="banner">';
	echo '<div class="submit-link">';
	echo '	<a href="submit.html">Submit a new Thread</a>';
	echo '</div>';
	drawSearch();
	echo '<div class="clear-results">';
	echo '<a href="mainpage.html">Clear results</a>';
	echo '</div>';
	if ($_SESSION['id'] ==1){
		echo '<div class="admin-link">';
		echo '<a href="admin.html">Admin</a>';
		echo '</div>';
	}
	drawLogoutButton();
	drawThemeSlider();
	echo '</div>';
	drawThreads($rows, $con);
	closeConnection($con);
}

function drawAdminpage(){		//Baut die Adminpage
	$con = openConnection();
	$rows = fetchAccountsInfo($con);
	closeConnection($con);

	echo '<div class="banner">';
	echo '<a href="index.html" class="index-link">Threads</a>';
	drawLogoutButton();
	drawThemeSlider();
	echo '</div>';

	echo '<div class="admin-table">';
	echo '<table>';
	echo '<tr><th>Username</th><th>Current Emailaddresse</th><th>Update Email</th><th>Update Password</th><th>delete User</th></tr>';
	foreach ($rows as $fieldname => $arrayEntry) {
		echo '<tr><td>' . $arrayEntry['username'] . '</td><td>' . $arrayEntry['email'] . '</td>';
		echo '<td><form class="admin-form update-button"action="" method="post" id="email' . $arrayEntry['id']. '">';
		echo '<input type="email" placeholder="email" name="email" maxlength="255" required>';
		echo '<input type="hidden" name="user" value="' . $arrayEntry["id"] . '" >';
		echo '<button type="button" onClick = confirmationPopUp(2,' . "\"email" . $arrayEntry['id'] . "\"" . ')>Update</button>';
		echo '</form>';
		echo '<td><form class="admin-form update-button"action="php/update_password.php" method="post" id="password' . $arrayEntry['id']. '">';
		echo '<input type="password" placeholder="password" name="password" maxlength="255" required>';
		echo '<input type="hidden" name="user" value="' . $arrayEntry["id"] . '" >';
		echo '<button type="button" onClick = confirmationPopUp(3,' . "\"password" . $arrayEntry['id'] . "\"" . ')>Update</button>';
		echo '</form>';
		if ($arrayEntry['id'] != 1){
			echo '<td><form class="admin-form delete-user-button"action="php/delete_user.php" method="post" id="delete' . $arrayEntry['id']. '">';
			echo '<input type="hidden" name="user" value="' . $arrayEntry["id"] . '" >';
			echo '<button type="button" onClick = confirmationPopUp(1,' . "\"delete" . $arrayEntry['id'] . "\"" . ')>Delete User</button>';
			echo '</form>';
		}else{
			echo '<td class="placeholder-delete"></td>';
		}
		echo '</td></tr>';
	}
	echo '</table>';
	echo '</div>';
}

?>
