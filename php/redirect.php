<?php
session_name("webeng_mwerr");
session_start();

if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header("Location: ../index");
    exit; 
}
?>