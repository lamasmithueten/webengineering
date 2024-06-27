<?php
include_once("sql.php");

function update_Email($email, $user) {
    $con = openConnection();
    $email = mysqli_real_escape_string($con, $email);
    if(checkEmailTaken($con, $email)){
        return "E-Mail is already taken";
    }
    updateEmail($con, $user, $email);
    closeConnection($con);
    return "E-Mail was updated";
}


?>
