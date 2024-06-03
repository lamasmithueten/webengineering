<?php

include ("sql.php");

function drawThreadsMainpage()
{
	$con = openConnection();
	$rows = fetchThreadsMainpage($con);
	closeConnection($con);
	echo '<div class="banner">';
	echo '<div class="submit-link">';
	echo '	<a href="submit.html">submit a new thread</a>';
	echo '</div>';
	drawLogoutButton();
	drawThemeSlider();
	echo '</div>';
	foreach ($rows as $fieldname => $arrayEntry) {
		echo '<div class="thread">';
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
		echo '<div class="username">' . $arrayEntry["username"] . "</div>";
		echo '<div class="timestamp">' .
			$arrayEntry["timestamp"] .
			"</div>";
		echo "</div>";
		if(isset($_SESSION['id']) && $_SESSION['id'] == $arrayEntry['id_account']) {
			echo '<form class="delete-button" action="php/delete_thread.php" method="post">';
			echo '<input type="hidden" name="thread_id" value="' . $arrayEntry["id"] . '">';
			echo '<button type="submit">Delete</button>';
			echo '</form>';
		}

		echo "</div>";
		echo "<br>";
	}
}

function drawThreadsPage($thread_id)
{
	$con = openConnection();
	$rows = fetchThread($con, $thread_id);
	$threadTitle = isset($rows[0]['title']) ? $rows[0]['title'] : 'Default Title';

	echo '<div class="banner">';
	echo '<a href="index.html" class="index-link">Threads</a>';
	drawLogoutButton();
	drawThemeSlider();
	echo '</div>';
	
	drawThread($rows, $thread_id);
	drawSubmitComments($thread_id);
	$rows = fetchAllComments($con, $thread_id);
	drawComments($rows, $thread_id, $con);
	closeConnection($con);
}

function drawThread($rows, $thread_id)
{
	foreach ($rows as $fieldname => $arrayEntry) {
		echo '<div class="thread">';
		echo '<div class="title">' . str_replace(array('\r\n', '\n\r', '\n', '\r'), '<br>', $arrayEntry['title']) . '</div>';
		echo '<div class="post">';
		if (isset($arrayEntry['picture_path'])) {
			$image = $arrayEntry['picture_path'];
			echo '<div class="image"><img src="../pictures/' . $image . '"></div>';
		}
		echo '<div class="text">' . str_replace(array('\r\n', '\n\r', '\n', '\r'), '<br>', $arrayEntry['text']) . '</div>';
		echo '</div>';
		echo '<div class="user_info">';
		echo '<div class="username">' . $arrayEntry['username'] . '</div>';
		echo '<div class="timestamp">' . $arrayEntry['timestamp'] . '</div>';
		echo '</div>';
		if(isset($_SESSION['id']) && $_SESSION['id'] == $arrayEntry['id_account']) {
		    echo '<form class="delete-button" action="../php/delete_thread.php" method="post">';
		    echo '<input type="hidden" name="thread_id" value="' . $thread_id . '">';
		    echo '<button type="submit">Delete</button>';
		    echo '</form>';
		}
		echo '</div>';
	}

}
function drawSubmitComments($thread_id)
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

function drawComments($rows, $thread_id, $con)
{
	echo '<div class="comments" data-user-id="' . $_SESSION['id'] . '">';
	echo '<p>Comments</p>';
	foreach ($rows as $fieldname => $arrayEntry) {
		echo '<div class="comment" data-comment-id="' . $arrayEntry['id'] . '">';
		echo '<div class="comment-text">' . str_replace(array('\r\n', '\n\r', '\n', '\r'), '<br>', $arrayEntry['text']) . '</div>';
		echo '<div class="comment-info">';
		echo '<span class="comment-username">' . $arrayEntry['username'] . '</span>';
		//hier if-Abfrage für Setzen der Checkbox
		echo '<div class="like-container">';
		echo '<input type="checkbox" class="like-checkbox"'; 
			if(isLiked($con, $arrayEntry['id'], $_SESSION['id'])==true ) {
				echo 'checked';
			}
			echo '>';
		echo '<span class="like-count">';
            $like_count = getLikeCountComment($con, $arrayEntry['id']);
            echo "$like_count";
			echo '</span>';
			echo '</div>';

		echo '<span class="comment-timestamp">' . $arrayEntry['timestamp'] . '</span>';
		if(isset($_SESSION['id']) && $_SESSION['id'] == $arrayEntry['id_account']) {
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

function drawThemeSlider(){
	echo '<div class="theme-slider">';
	echo '<label class="switch">';
	echo '<input type="checkbox" id="themeSwitch">';
	echo '<span class="slider round"></span>';
	echo '</label>';
	echo '</div>';
}

?>
