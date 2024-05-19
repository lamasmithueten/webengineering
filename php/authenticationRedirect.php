<?php
    function redirectRegistration($message)
    {
        if(is_null($message))
        {
            header("Location:../register");
        } else {
            header("Location:../register?message=$message");
        }
    }

    function redirectLogin($message)
    {
        if(is_null($message))
        {
            header("Location:../index");
        } else {
            header("Location:../index?message=$message");
        }
    }
?>