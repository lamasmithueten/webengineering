<?php
    function redirectSuccessfulRegistration($message)
    {
        $_SESSION['success'] = $message;
        header("Location:../index");
    }

    function addPostErrormessage($errorMessage){
        $_POST['errorMessage'] = $errorMessage;
    }
?>