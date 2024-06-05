include("sql.php");

function createResetToken($email) {
    $con = openConnection();

    $id = getUserIdWithEmail($email);

    if(is_null($id)){
        return;
    }

    $token = "";
    while(true){
        $token =generateToken(6,999999);
        if(!checkIfTokenExists($token,$con)) {
            break;
        }
    }
    createResetTokenEntry($token,$id,$email,$con);
}

function getUserIdWithEmail($email, $con) {
    $sqlquery = "SELECT id FROM accounts WHERE email = ?";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("s", $email);
	$stmt->execute();
	return $stmt->get_result();
}

function generateToken($length, $maxValue) {
    str_pad(mt_rand(0, $maxValue), $length, '0', STR_PAD_LEFT);
}

function checkIfTokenExists($reset_token,$con) {
    $sqlquery = "SELECT * FROM password_reset WHERE reset_token = ?";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("s", $reset_token);
	$stmt->execute();
	$resul = $stmt->get_result();

    if ($result->num_rows > 0) {
		return true;
	}
	return false;
}

function createResetTokenEntry($token, $id,$email, $con) {
    $expires = new DateTime();
    $expires->modify('+20 minutes');
    $expires->format('Y-m-d H:i:s');
    $sqlquery = "INSERT INTO password_reset (id, user_id, reset_token, expires) VALUES ( NULL, ?, ?, ?)";
	$stmt = $con->prepare($sqlquery);
	$stmt->bind_param("sss", $id, $token, $expires);

    if ($stmt->execute()) {
        //sendEmail($email, $token);
		return true;
	} else {
		echo "ERROR: "
			. $stmt->error;
			return false;
	}
}

function sendEmail($email, $token) {
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