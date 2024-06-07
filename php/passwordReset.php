<?php
include("sql.php");

function createResetToken($email) {
    $con = openConnection();
    createResetTokenHelper($email, $con);
    closeConnection($con);
}

function createResetTokenHelper($email, $con) {
    $id = getUserIdWithEmail($email, $con);

    if(is_null($id)){
        closeConnection($con);
        return;
    }

    $token = "";
    while(true){
        $token =generateToken(6,999999);
        if(!checkIfTokenExists($token,$con)) {
            break;
        }
    }
    if(createResetTokenEntry($token,$id,$email,$con)){
        sendResetCode($email,$token);
    }
}

function resetPassword($code, $password) {
    $con = openConnection();
    $message = resetPasswordHelper($code, $password, $con);
    closeConnection($con);
    return $message;
}

function resetPasswordHelper($code, $password, $con) {
    $succesMessage = "Password was changed";
    $entry = getTokenEntry($code, $con);
    if(is_null($entry)) {
        return $succesMessage;
    }
    if(isExpired($entry['expires'])) {
        deleteCode($code, $con);
        return "Code is expired";
    }
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    if(updatePassword($entry['user_id'],$hashedPassword,$con)){
        $email = getUserEmailWithId($entry['user_id'],$con);
        sendPasswordResetNotification($email);
        deleteCode($code, $con);
        return $succesMessage;
    }
    return "error";
}

function isExpired($dateTime) {
    $now = new DateTime();
    if(date_create_from_format('d/m/Y:H:i:s',$dateTime) <= $now) {
        return false;
    }
    return true;
}

function getTokenEntry($code, $con) {
    $sqlquery = "SELECT * FROM password_reset WHERE reset_token = ?";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("s", $code);
	$stmt->execute();
	$result = $stmt->get_result();
    if($result->num_rows == 0) {
        return null;
    }
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $first_row = $rows[0];
    return $first_row;
}

function updatePassword($userId, $hashedPassword, $con) {
    $sqlquery = "UPDATE accounts SET password = ? WHERE id = ?";
        $stmt = $con->prepare($sqlquery);
        $stmt->bind_param("si", $hashedPassword, $userId);
        
        if ($stmt->execute()) {
            return true;
        } else {
            echo "ERROR: "
                . $stmt->error;
                return false;
        }
}

function getUserIdWithEmail($email, $con) {
    $sqlquery = "SELECT id FROM accounts WHERE email = ?";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("s", $email);
	$stmt->execute();
	$result = $stmt->get_result();
    if($result->num_rows == 0) {
        return null;
    }
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $first_row = $rows[0];
    return $first_row["id"];
}

function getUserEmailWithId($id, $con) {
    $sqlquery = "SELECT email FROM accounts WHERE id = ?";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$result = $stmt->get_result();
    if($result->num_rows == 0) {
        return null;
    }
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $first_row = $rows[0];
    return $first_row["email"];
}

function generateToken($length, $maxValue) {
    return str_pad(mt_rand(0, $maxValue), $length, '0', STR_PAD_LEFT);
}

function checkIfTokenExists($reset_token,$con) {
    $sqlquery = "SELECT * FROM password_reset WHERE reset_token = ?";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("s", $reset_token);
	$stmt->execute();
	$result = $stmt->get_result();

    if ($result->num_rows > 0) {
		return true;
	}
	return false;
}

function createResetTokenEntry($token, $id,$email, $con) {
    deleteCodeOfUser($id,$con);

    $expires = new DateTime();
    $expires->modify('+20 minutes');
    $expiresFormated = $expires->format('Y-m-d H:i:s');
    $sqlquery = "INSERT INTO password_reset (id, user_id, reset_token, expires) VALUES ( NULL, ?, ?, ?)";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("sss", $id, $token, $expiresFormated);

    if ($stmt->execute()) {
		return true;
	} else {
		echo "ERROR: "
			. $stmt->error;
			return false;
	}
}

function sendResetCode($email, $token) {
    $subject = "Password Reset Code";
		$text = "Dear User,\n\n
        We have received a request to reset the password for your account. Please use the code provided below to complete the password reset process:
            \n\n**Reset Code: {$token}**\n\nTo reset your password, follow these steps:
            \n1. Go to the password reset page on our website.\n2. Enter your email address and the reset code provided above.
            \n3. Follow the on-screen instructions to set a new password.\n\nIf you did not request a password reset, please ignore this email. 
            Your account will remain secure, and no changes will be made.\n\nIf you have any questions or need further assistance, 
            please do not hesitate to contact our support team at [Support Email] or [Support Phone Number].
            \n\nBest regards,\n\nYour Anarchy IT-Support---
            \n\nNote: For security reasons, this code will expire in 20 Minutes. Please ensure you complete the reset process within this timeframe.";
		mail($email, $subject, $text);
}

function sendPasswordResetNotification($email) {
    $subject = "Password Reseted";
		$text = "Dear User,\n\n
        We are writing to inform you that the password for your account was successfully changed.
        \n\nIf you made this change, no further action is required. You can now use your new password to access your account. 
        If you did not authorize this change, it is important that you act immediately to secure your account. 
        Please change your password immediately and contact the Anarchy IT-Support to report the unauthorized change.
        \n\nIf you have any questions or need assistance, 
        please do not hesitate to contact our support team.\n\nThank you for your attention to this matter.\n\nBest regards,
        \n\nYour Anarchy IT-Support---
        **Note:** This is an automated message. Please do not reply to this email.\n\n---";
		mail($email, $subject, $text);
}


function deleteCodeOfUser($id_user, $con) {
    $sqlquery = "DELETE FROM password_reset WHERE user_id=?";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("i", $id_user);
	$stmt->execute();
}

function deleteCode($code, $con) {
    $sqlquery = "DELETE FROM password_reset WHERE reset_token=?";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("i", $code);
	$stmt->execute();
}

?>