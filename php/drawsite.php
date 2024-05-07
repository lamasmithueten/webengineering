<?php

function drawThreadsMainpage($rows){
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
            echo "</div>"; // end of post

            echo '<div class="user_info">';
            echo '<div class="username">' . $arrayEntry["username"] . "</div>";
            echo '<div class="timestamp">' .
                $arrayEntry["timestamp"] .
                "</div>";
            echo "</div>"; // end of user_info

            echo "</div>"; // end of thread
            echo "<br>";
        }
}
?>
