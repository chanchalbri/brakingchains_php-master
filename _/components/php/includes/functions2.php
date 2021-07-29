<?php 
require("PHPMailer_5.2.0/class.phpmailer.php");
// functions.php - called by most files 
// to access custom php functions 
//
// (c) 2018, 5Onit
// Written by James Misa 

function check_required_fields($required_array) {
	$field_errors = array();
	foreach($required_array as $fieldname) {
		if (!isset($_REQUEST[$fieldname]) || (empty($_REQUEST[$fieldname]))) { 
			$field_errors[] = $fieldname; 
		}
	}
	return $field_errors;
}

function validate_form($required_fields) {
    $field_errors = array();
	foreach($required_fields as $fieldname) {
		if (!isset($_REQUEST[$fieldname]) || (empty($_REQUEST[$fieldname]))) { 
			$field_errors[] = $fieldname; 
		}
	}
	return $field_errors;
}

function check_max_field_lengths($field_length_array) {
	$field_errors = array();
	foreach($field_length_array as $fieldname => $maxlength ) {
		if (strlen(trim(($_POST[$fieldname]))) > $maxlength) { $field_errors[] = $fieldname; }
	}
	return $field_errors;
}

function generateRandomString($length = 6) {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
    return $randomString;
}

function reVerCode($onitId, $connection) {
    $verCode = generateRandomString();
    $query = "UPDATE users SET verCode = '{$verCode}' WHERE onitId = '{$onitId}'";
    $result = mysqli_query($connection, $query);
    confirm_query($result, $connection);
    return $verCode;
}

function createOnitId () {
	date_default_timezone_set("America/Los_Angeles");
	$day = date("d");
	$month = date("m");
	$seconds = date("s");
	$minutes = date("i");
	$hours = date("H");
	$year = date("y");
	$onitId = $day . $month . $seconds . $minutes . $hours . $year;

	return $onitId;
}

function confirm_query($result_set, $connection) {
    if (!$result_set) {
        $message = 'Invalid query: ' . mysqli_error($connection) . "\n";
        $message .= 'Whole query: ' . $result_set;
        die($message);
    }
}

function run_query($query, $connection) {
    $resultSet = mysqli_query($connection, $query);
    if (!$resultSet) {
        $message = 'Invalid query: ' . mysqli_error($connection) . "<br>";
        $message .= 'Whole query: ' . $query;
        die($message);
    } else {
        return $resultSet;
    }
}

function nextMonth () {
	date_default_timezone_set("America/Los_Angeles");
	$month = date("m");
    $monthNum  = $month + 1;
    $dateObj   = DateTime::createFromFormat('!m', $monthNum);
    $monthName = $dateObj->format('F'); // March
    
	return $monthName;
}

function thisMonth () {
    date_default_timezone_set("America/Los_Angeles");
	$month = date("F");
    
    return $month;
}

function userAccount ($id, $connection) {
    //create user's account
    $query = "INSERT INTO account (
            userId,
            balance,
            refBal,
            purBal
            ) VALUES (
            '{$id}',
            '0',
            '0',
            '0'
        )";
    $result = mysqli_query($connection, $query);
    confirm_query($result, $connection);
}

function refOnits ($init, $recip, $type, $description, $connection) {
    //credit referrer with Onits
    $query = "INSERT INTO transactions (
            initiator,
            recipient,
            credits,
            type,
            description
            ) VALUES (
            '{$init}',
            '{$recip}',
            '35',
            '{$type}',
            '{$description}'
        )";
    $result = mysqli_query($connection, $query);
    confirm_query($result, $connection);
}

function subOnits ($init, $recip, $type, $description, $connection) {
    //credit sub referrer with Onits
    $query = "INSERT INTO transactions (
            initiator,
            recipient,
            credits,
            type,
            description
            ) VALUES (
            '{$init}',
            '{$recip}',
            '20',
            '{$type}',
            '{$description}'
        )";
    $result = mysqli_query($connection, $query);
    confirm_query($result, $connection);
}

function syncAll ($onitId, $connection){
    //ensure that all data in Account table - 'balance, refBal, purBal, lastLoad, nextLoad, projLoad' - is synced upon login
    $currentMonth = date('m', time());
    $formattedMonth = '2018-' . $currentMonth . '-01 00:00:00';
    $nextLoadQuery = "SELECT * 
            FROM transactions 
            WHERE recipient = '{$onitId}' 
            AND creationDateTime < '{$formattedMonth}'";
    $result = mysqli_query($connection, $nextLoadQuery);
    confirm_query($result, $connection);
    if(mysqli_num_rows($result) > 0){
        $nextLoad = 0;
        while ($foundRecipient = mysqli_fetch_array($result)) {
            $credits = $foundRecipient['credits'];
            $debits = $foundRecipient['debits'];

            if ($credits == NULL) {
                $nextLoad = $nextLoad - $debits;
            } else {
                $nextLoad = $nextLoad + $credits;
            }
        }
    }
    $balanceQuery = "SELECT * 
            FROM transactions 
            WHERE recipient = '{$onitId}' 
            AND creationDateTime > '{$formattedMonth}'";
    $result = mysqli_query($connection, $balanceQuery);
    confirm_query($result, $connection);
    if(mysqli_num_rows($result) > 0){
        $balance = 0;
        while ($foundRecipient = mysqli_fetch_array($result)) {
            $credits = $foundRecipient['credits'];
            $debits = $foundRecipient['debits'];

            if ($credits == NULL) {
                $balance = $balance - $debits;
            } else {
                $balance = $balance + $credits;
            }
        }
    }
    $purBalQuery = "SELECT * 
            FROM transactions 
            WHERE recipient = '{$onitId}' 
            AND creationDateTime > '{$formattedMonth}'
            AND type = 'purchase'";
    $result = mysqli_query($connection, $purBalQuery);
    confirm_query($result, $connection);
    if(mysqli_num_rows($result) > 0){
        $purBal = 0;
        while ($foundRecipient = mysqli_fetch_array($result)) {
            $credits = $foundRecipient['credits'];
            $debits = $foundRecipient['debits'];

            if ($credits == NULL) {
                $purBal = $purBal - $debits;
            } else {
                $purBal = $purBal + $credits;
            }
        }
    }
    $refBalQuery = "SELECT * 
            FROM transactions 
            WHERE recipient = '{$onitId}' 
            AND creationDateTime > '{$formattedMonth}'
            AND type != 'purchase'";
    $result = mysqli_query($connection, $refBalQuery);
    confirm_query($result, $connection);
    if(mysqli_num_rows($result) > 0){
        $refBal = 0;
        while ($foundRecipient = mysqli_fetch_array($result)) {
            $credits = $foundRecipient['credits'];
            $debits = $foundRecipient['debits'];

            if ($credits == NULL) {
                $refBal = $refBal - $debits;
            } else {
                $refBal = $refBal + $credits;
            }
        }
    }
    $referralsQuery = "SELECT *
            FROM users 
            WHERE referralCode = '{$onitId}'";
            $resultSet = mysqli_query($connection, $referralsQuery);
            confirm_query($resultSet, $connection);
    if (mysqli_num_rows($resultSet) == 0) {
            $yourReferrals = 0;
            $yourSubReferrals = 0;
            $projLoad = 0;
        } else {
            $yourReferrals = mysqli_num_rows($resultSet);
            $yourSubReferrals = 0;
            while($referral = mysqli_fetch_assoc($resultSet)) {
                $rOnitId = $referral['onitId'];
                $subReferrals = 0;
                
                $query = "SELECT *";
                $query .= "FROM users ";
                $query .= "WHERE referralCode = '{$rOnitId}' ";
                $resultSet2 = mysqli_query($connection, $query);
                confirm_query($resultSet2, $connection);
                
                if(mysqli_num_rows($resultSet2) > 0) {
                    while($subReferral = mysqli_fetch_assoc($resultSet2)) {
                        $subReferrals++;
                    }
                }
                $yourSubReferrals = $yourSubReferrals + $subReferrals;
            }
            $projLoad = ($yourReferrals * 35) + ($yourSubReferrals * 20);
    }
    $_SESSION['nextLoad'] = $nextLoad;
    $_SESSION['balance'] = $balance;
    $_SESSION['purBal'] = $purBal;
    $_SESSION['refBal'] = $refBal;
    $_SESSION['projLoad'] = $projLoad;
    $_SESSION['referrals'] = $yourReferrals;
    $_SESSION['subReferrals'] = $yourSubReferrals;
}

function getOnits ($onitId, $connection) {
    //create user's account
    $query = "SELECT * FROM account WHERE userId = '{$onitId}' LIMIT 1";
    $result = mysqli_query($connection, $query);
    confirm_query($result, $connection);
    
    while ($foundAcct = mysqli_fetch_array($result)) {
        $refOnits = $foundAcct['refBal'];
        $purOnits = $foundAcct['purBal'];
        $totOnits = $foundAcct['balance'];
    }
    return array($refOnits, $purOnits, $totOnits);
}

function replaceClass ($onitId, $currentClass, $connection) {
    $query = "UPDATE users SET class = '{$currentClass}' WHERE onitId = '{$onitId}'";
    $result = mysqli_query($connection, $query);
    confirm_query($result, $connection);
}

function updateClass ($userClass, $referrals, $onitId, $connection) {
    //check if user's class is correct
    if ($referrals < 15) {
        $currentClass = "pawn";
        if ($currentClass != $userClass) {
             replaceClass($onitId, $currentClass, $connection);
        } 
        return $currentClass;
    } else {//check how many KNIGHT referrals user has
        $query = "SELECT * FROM users WHERE referralCode = '{$onitId}'";
        $result = mysqli_query($connection, $query);
        confirm_query($result, $connection);
        
        if (mysqli_num_rows($result) < 15) {
            $currentClass = "knight";
            if ($currentClass != $userClass) {
             replaceClass($onitId, $currentClass, $connection);
            } 
            return $currentClass;
        } else {
            $knights = 0;
            while ($foundRefs = mysqli_fetch_array($result)) {
                if ($foundRefs['class'] == "knight") {
                    $knights++;
                }
            }
            if ($knights < 15) {
                $currentClass = "knight";
                if ($currentClass != $userClass) {
                 replaceClass($onitId, $currentClass, $connection);
                } 
                return $currentClass;
            } else {
                $currentClass = "king";
                if ($currentClass != $userClass) {
                 replaceClass($onitId, $currentClass, $connection);
                }   
                return $currentClass;
            }
        }
    }
}

function fbUpdate($onitId, $fbID, $firstName, $lastName, $fbToken, $imgUrl, $connection) {
    $query = "UPDATE users SET firstName = '{$firstName}', lastName = '{$lastName}', fbID = '{$fbID}', fbToken = '{$fbToken}', imgUrl = '{$imgUrl}' WHERE onitId = '{$onitId}'";
    $result = mysqli_query($connection, $query);
    confirm_query($result, $connection);
}

function verificationEmail ($email_address, $firstName, $onitId, $verCode) {
    //need css
	$link = "<a href='http://252f6c14.ngrok.io/~macbookair/onit5/_/components/php/verifyUser.php?id=" . $onitId . "&verCode=" . $verCode . "'>CLICK HERE</a>";	
    $to      = $email_address;
		$subject = 'WELCOME! Verify your account';
		$message = '<html><body><p>Hello ' . $firstName . ',</p>' .  
				   '<p>Welcome to the world of 5Onit.</p>' . 
				   '<p>Click the link below to complete your account setup.</p>' .  
				   '<p><b>Account Verification:</b> ' . $link . '</p>' . 
				   '<p>Thank you!</p>' . 
				   '<p>5Onit Support</p></body></html>';

///////////////////////////////////////////////////////////////////////////////////

		$mail = new PHPMailer();

		$mail->IsSMTP(); // set mailer to use SMTP
		$mail->Host = "smtpout.secureserver.net";  // specify main and backup server
		$mail->SMTPAuth = true;     // turn on SMTP authentication
		$mail->Username = "james@aliasmobile.com";  // SMTP username
		$mail->Password = "james"; // SMTP password

		$mail->From = "info@5Onit.com";
		$mail->FromName = "5Onit Support";
		$mail->AddAddress($to);                  // name is optional
		$mail->AddReplyTo("info@5Onit.com", "5Onit Support");
		$mail->addBCC("james@aliasmobile.com");

		$mail->WordWrap = 50;                                 // set word wrap to 50 characters
		$mail->IsHTML(true);                                  // set email format to HTML

		$mail->Subject = $subject;
		$mail->Body    = $message;
		$mail->AltBody = $message;

		if(!$mail->Send())
		{
		   $msg = "Message could not be sent.";
		   $msg += "Mailer Error: " . $mail->ErrorInfo;
		   $data = array('status'=>1, 'msg'=>$msg);
		   $json = json_encode($data);
		   echo $json;
		   exit;
		}

		   $msg = "Message has been sent.";
		   $data = array('status'=>4, 'msg'=>$msg);
		   $json = json_encode($data);
		   //echo $json;

}

function newReferrer ($email_address, $firstName, $name, $referrals) {
        //need css
		$to      = $email_address;
		$subject = 'CONGRATULATIONS! You have received a new referral';
		$message = '<html><body><p>Hello ' . $firstName . ',</p>' .  
				   '<p>All of your hard work has paid off!</p>' . 
				   '<p>You\'ve just received a new referral...' . $name . '.</p>' .  
				   '<p><b>Total Referrals:</b> ' . $referrals . '</p>' . 
				   '<p>Log into your account now to share with more of your social media connections.</p>' . 
				   '<p>Thank you!</p>' . 
				   '<p>5Onit Support</p></body></html>';

///////////////////////////////////////////////////////////////////////////////////

		$mail = new PHPMailer();

		$mail->IsSMTP();                                      // set mailer to use SMTP
		$mail->Host = "smtpout.secureserver.net";  // specify main and backup server
		$mail->SMTPAuth = true;     // turn on SMTP authentication
		$mail->Username = "james@aliasmobile.com";  // SMTP username
		$mail->Password = "james"; // SMTP password

		$mail->From = "info@5Onit.com";
		$mail->FromName = "5Onit Support";
		$mail->AddAddress($to);                  // name is optional
		$mail->AddReplyTo("info@5Onit.com", "5Onit Support");
		$mail->addBCC("james@aliasmobile.com");

		$mail->WordWrap = 50;                                 // set word wrap to 50 characters
		$mail->IsHTML(true);                                  // set email format to HTML

		$mail->Subject = $subject;
		$mail->Body    = $message;
		$mail->AltBody = $message;

		if(!$mail->Send())
		{
		   $msg = "Message could not be sent.";
		   $msg += "Mailer Error: " . $mail->ErrorInfo;
		   $data = array('status'=>1, 'msg'=>$msg);
		   $json = json_encode($data);
		   echo $json;
		   exit;
		}

		   $msg = "Message has been sent.";
		   $data = array('status'=>4, 'msg'=>$msg);
		   $json = json_encode($data);
		   //echo $json;

}

function newReferrerPlus ($email_address, $firstName, $name, $referrals) {
        //need css
		$to      = $email_address;
		$subject = 'CONGRATULATIONS! A new referral AND a Promotion.';
		$message = '<html><body><p>Hello ' . $firstName . ',</p>' .  
				   '<p>All of your hard work is continuing to pay off!</p>' . 
				   '<p>You\'ve just received a new referral...' . $name . '.</p>' .  
				   '<p>That\'s not all...that new referral gave qualified you for a promotion!!</p>' .  
				   '<p><b>Total Referrals:</b> ' . $referrals . '</p>' . 
				   '<p>Log into your account now to share with more of your social media connections.</p>' . 
				   '<p>Thank you!</p>' . 
				   '<p>5Onit Support</p></body></html>';

///////////////////////////////////////////////////////////////////////////////////

		$mail = new PHPMailer();

		$mail->IsSMTP();                                      // set mailer to use SMTP
		$mail->Host = "smtpout.secureserver.net";  // specify main and backup server
		$mail->SMTPAuth = true;     // turn on SMTP authentication
		$mail->Username = "james@aliasmobile.com";  // SMTP username
		$mail->Password = "james"; // SMTP password

		$mail->From = "info@5Onit.com";
		$mail->FromName = "5Onit Support";
		$mail->AddAddress($to);                  // name is optional
		$mail->AddReplyTo("info@5Onit.com", "5Onit Support");
		$mail->addBCC("james@aliasmobile.com");

		$mail->WordWrap = 50;                                 // set word wrap to 50 characters
		$mail->IsHTML(true);                                  // set email format to HTML

		$mail->Subject = $subject;
		$mail->Body    = $message;
		$mail->AltBody = $message;

		if(!$mail->Send())
		{
		   $msg = "Message could not be sent.";
		   $msg += "Mailer Error: " . $mail->ErrorInfo;
		   $data = array('status'=>1, 'msg'=>$msg);
		   $json = json_encode($data);
		   echo $json;
		   exit;
		}

		   $msg = "Message has been sent.";
		   $data = array('status'=>4, 'msg'=>$msg);
		   $json = json_encode($data);
		   //echo $json;

}

function newSubReferrer ($email_address, $firstName, $name, $referrals) {
        //need css
		$to      = $email_address;
		$subject = 'CONGRATULATIONS! Your referrals are at work';
		$message = '<html><body><p>Hello ' . $firstName . ',</p>' .  
				   '<p>You\'re earning without you knowing!</p>' . 
				   '<p>Your referral, ' . $name . ' just received a new referral.</p>' .  
				   '<p><b>Total Referrals:</b> ' . $referrals . '</p>' . 
				   '<p>Log into your account now to share with more of your social media connections.</p>' . 
				   '<p>Thank you!</p>' . 
				   '<p>5Onit Support</p></body></html>';

///////////////////////////////////////////////////////////////////////////////////

		$mail = new PHPMailer();

		$mail->IsSMTP();                                      // set mailer to use SMTP
		$mail->Host = "smtpout.secureserver.net";  // specify main and backup server
		$mail->SMTPAuth = true;     // turn on SMTP authentication
		$mail->Username = "james@aliasmobile.com";  // SMTP username
		$mail->Password = "james"; // SMTP password

		$mail->From = "info@5Onit.com";
		$mail->FromName = "5Onit Support";
		$mail->AddAddress($to);                  // name is optional
		$mail->AddReplyTo("info@5Onit.com", "5Onit Support");
		$mail->addBCC("james@aliasmobile.com");

		$mail->WordWrap = 50;                                 // set word wrap to 50 characters
		$mail->IsHTML(true);                                  // set email format to HTML

		$mail->Subject = $subject;
		$mail->Body    = $message;
		$mail->AltBody = $message;

		if(!$mail->Send())
		{
		   $msg = "Message could not be sent.";
		   $msg += "Mailer Error: " . $mail->ErrorInfo;
		   $data = array('status'=>1, 'msg'=>$msg);
		   $json = json_encode($data);
		   echo $json;
		   exit;
		}

		   $msg = "Message has been sent.";
		   $data = array('status'=>4, 'msg'=>$msg);
		   $json = json_encode($data);
		   //echo $json;

}

function newSubReferrerPlus ($email_address, $firstName, $name, $referrals) {
        //need css
		$to      = $email_address;
		$subject = 'CONGRATULATIONS! A new referral AND a Promotion.';
		$message = '<html><body><p>Hello ' . $firstName . ',</p>' .  
				   '<p>All of your hard work is continuing to pay off!</p>' . 
				   '<p>You\'ve just received a new referral...' . $name . '.</p>' .  
				   '<p>That\'s not all...that new referral gave qualified you for a promotion!!</p>' .  
				   '<p><b>Total Referrals:</b> ' . $referrals . '</p>' . 
				   '<p>Log into your account now to share with more of your social media connections.</p>' . 
				   '<p>Thank you!</p>' . 
				   '<p>5Onit Support</p></body></html>';

///////////////////////////////////////////////////////////////////////////////////

		$mail = new PHPMailer();

		$mail->IsSMTP();                                      // set mailer to use SMTP
		$mail->Host = "smtpout.secureserver.net";  // specify main and backup server
		$mail->SMTPAuth = true;     // turn on SMTP authentication
		$mail->Username = "james@aliasmobile.com";  // SMTP username
		$mail->Password = "james"; // SMTP password

		$mail->From = "info@5Onit.com";
		$mail->FromName = "5Onit Support";
		$mail->AddAddress($to);                  // name is optional
		$mail->AddReplyTo("info@5Onit.com", "5Onit Support");
		$mail->addBCC("james@aliasmobile.com");

		$mail->WordWrap = 50;                                 // set word wrap to 50 characters
		$mail->IsHTML(true);                                  // set email format to HTML

		$mail->Subject = $subject;
		$mail->Body    = $message;
		$mail->AltBody = $message;

		if(!$mail->Send())
		{
		   $msg = "Message could not be sent.";
		   $msg += "Mailer Error: " . $mail->ErrorInfo;
		   $data = array('status'=>1, 'msg'=>$msg);
		   $json = json_encode($data);
		   echo $json;
		   exit;
		}

		   $msg = "Message has been sent.";
		   $data = array('status'=>4, 'msg'=>$msg);
		   $json = json_encode($data);
		   //echo $json;

}

function emailReferrer ($referrerId, $name, $connection) {
    //find the referrer
    $query = "SELECT * FROM users WHERE onitId = '{$referrerId}' LIMIT 1";
    $result = mysqli_query($connection, $query);
    confirm_query($result, $connection);
    
    while ($referrer = mysqli_fetch_array($result)) {
        $firstName = $referrer['firstName'];
        $email_address = $referrer['email'];
        $class = $referrer['class'];
    }
    //count how many referrals the referrer has
    $query2 = "SELECT *";
    $query2 .= "FROM users ";
    $query2 .= "WHERE referralCode = '{$referrerId}'";
    $resultSet2 = mysqli_query($connection, $query2);
    confirm_query($resultSet2, $connnection);
    $referrals = 0;
    while($foundRef = mysqli_fetch_array($resultSet2)) {
        $referrals++;
        $knights = 0;
        if ($foundRef == "knight") {
            $knights++;
        }
    }
    //check if user's class is correct
    if ($referrals < 15) {
        $currentClass = "pawn";
        if ($currentClass != $class) {
             replaceClass($referrerId, $currentClass, $connection);
             //send a demotion email??
             newReferrer ($email_address, $firstName, $name, $referrals); 
        } else {
             newReferrer ($email_address, $firstName, $name, $referrals);  
        }
        
    } else {//either knight or king
        if ($knights < 15) {
            $currentClass = "knight";
            if ($currentClass != $class) {//promotion
                replaceClass($referrerId, $currentClass, $connection);
                newReferrerPlus ($email_address, $firstName, $name, $referrals);
            } else {
                newReferrer ($email_address, $firstName, $name, $referrals);
            }
            
        } else {
            $currentClass = "king";
            if ($currentClass != $class) {
                replaceClass($referrerId, $currentClass, $connection);
                newReferrerPlus ($email_address, $firstName, $name, $referrals);
            } else {
                newReferrer ($email_address, $firstName, $name, $referrals);
            }
            
        }
        
    }
}

function emailSubReferrer ($referrerId, $name, $connection) {
    //find the subReferrer
    $query = "SELECT * FROM users WHERE onitId = '{$referrerId}' LIMIT 1";
    $result = mysqli_query($connection, $query);
    confirm_query($result, $connection);
    
    while ($referrer = mysqli_fetch_array($result)) {
        $firstName = $referrer['firstName'];
        $email_address = $referrer['email'];
        $class = $referrer['class'];
    }
    //count how many referrals the referrer has
    $query2 = "SELECT *";
    $query2 .= "FROM users ";
    $query2 .= "WHERE referralCode = '{$referrerId}'";
    $resultSet2 = mysqli_query($connection, $query2);
    confirm_query($resultSet2, $connnection);
    $referrals = 0;
    while($foundRef = mysqli_fetch_array($resultSet2)) {
        $referrals++;
        $knights = 0;
        if ($foundRef == "knight") {
            $knights++;
        }
    }
    //check if user's class is correct
    if ($referrals < 15) {
        $currentClass = "pawn";
        if ($currentClass != $class) {
             replaceClass($referrerId, $currentClass, $connection);
             //send a demotion email??
             newSubReferrer ($email_address, $firstName, $name, $referrals); 
        } else {
             newSubReferrer ($email_address, $firstName, $name, $referrals);  
        }
        
    } else {//either knight or king
        if ($knights < 15) {
            $currentClass = "knight";
            if ($currentClass != $class) {//promotion
                replaceClass($referrerId, $currentClass, $connection);
                newSubReferrerPlus ($email_address, $firstName, $name, $referrals);
            } else {
                newSubReferrer ($email_address, $firstName, $name, $referrals);
            }
            
        } else {
            $currentClass = "king";
            if ($currentClass != $class) {
                replaceClass($referrerId, $currentClass, $connection);
                newSubReferrerPlus ($email_address, $firstName, $name, $referrals);
            } else {
                newSubReferrer ($email_address, $firstName, $name, $referrals);
            }
            
        }
        
    }
}

function goHome() {
    //need css
    $page  = "<p id='newMember'>Congratulations! You are now a member of the 5Onit family.</p>";
    $page .= "<p>Click the button below to get started.</p>";
    $page .= "<button id='regComplete' onclick='window.location=\"http://localhost/~macbookair/onit5/index.php\"'>HOME</button>";
    echo $page;
}
?>