<?php

include ("sql.php");

function drawThreadsMainpage()
{
	$con = openConnection();
	$rows = fetchThreadsMainpage($con);
	closeConnection($con);
	foreach ($rows as $fieldname => $arrayEntry) {
		echo '<div class="thread">';
		echo '<div class="title"><a href="https://webeng.mwerr.de/thread/' .
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
			echo '<div class="image"><img src="https://webeng.mwerr.de/pictures/' .
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
			echo '<form action="https://webeng.mwerr.de/php/delete_thread.php" method="post">';
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
	drawThread($rows, $thread_id);
	drawSubmitComments($thread_id);
	$rows = fetchAllComments($con, $thread_id);
	closeConnection($con);
	drawComments($rows, $thread_id);
}

function drawThread($rows, $thread_id)
{
	foreach ($rows as $fieldname => $arrayEntry) {
		echo '<div class="thread">';
		echo '<div class="title">' . str_replace(array('\r\n', '\n\r', '\n', '\r'), '<br>', $arrayEntry['title']) . '</div>';
		echo '<div class="post">';
		if (isset($arrayEntry['picture_path'])) {
			$image = $arrayEntry['picture_path'];
			echo '<div class="image"><img src="https://webeng.mwerr.de/pictures/' . $image . '"></div>';
		}
		echo '<div class="text">' . str_replace(array('\r\n', '\n\r', '\n', '\r'), '<br>', $arrayEntry['text']) . '</div>';
		echo '</div>';
		echo '<div class="user_info">';
		echo '<div class="username">' . $arrayEntry['username'] . '</div>';
		echo '<div class="timestamp">' . $arrayEntry['timestamp'] . '</div>';
		echo '</div>';
		if(isset($_SESSION['id']) && $_SESSION['id'] == $arrayEntry['id_account']) {
		    echo '<form action="https://webeng.mwerr.de/php/delete_thread.php" method="post">';
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
	echo '<form action="https://webeng.mwerr.de/php/submit_comment.php" method="post" enctype="multipart/form-data">';
	echo '<textarea id="comment" name="comment" maxlength="65535" required></textarea>';
	echo '<input type="hidden" name="threadid" id="threadid" value="' . $thread_id . '"/>';
	echo '<input type="submit" value="submit"/>';
	echo '</form>';
	echo '</div>';
}

function drawComments($rows, $thread_id)
{
	echo '<div class="comments">';
	echo '<p>Comments</p>';
	foreach ($rows as $fieldname => $arrayEntry) {
		echo '<div class="comment">';
		echo '<div class="comment-text">' . str_replace(array('\r\n', '\n\r', '\n', '\r'), '<br>', $arrayEntry['text']) . '</div>';
		echo '<div class="comment-info">';
		echo '<span class="comment-username">' . $arrayEntry['username'] . '</span>';
		echo '<span class="comment-timestamp">' . $arrayEntry['timestamp'] . '</span>';
		if(isset($_SESSION['id']) && $_SESSION['id'] == $arrayEntry['id_account']) {
		    echo '<form action="https://webeng.mwerr.de/php/delete_comment.php" method="post">';
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

?>
