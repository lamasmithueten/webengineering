<?php
session_name("webeng_mwerr");
session_start();

$_SESSION = array();

session_destroy();

header("Location: ../index.html");

exit();

?>
