<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
// findReferrer.php - called by the login.php form
// to find the referrer of a new member
//
// (c) 2020, TLF
// Written by James Misa 

// START FORM PROCESSING

    $email = trim($_REQUEST['email']);	

        //find referrer	
        $query = "SELECT * ";
        $query .= "FROM users ";
        $query .= "WHERE email = '{$email}' ";
        $query .= "LIMIT 1";
        $resultSet = mysqli_query($connection, $query);
        confirm_query($resultSet, $connection);

        if(mysqli_affected_rows($connection) > 0) {
            while($found_referrer = mysqli_fetch_array($resultSet)) {
                $_SESSION['referrer_name'] = $found_referrer['first_name'] . " " . $found_referrer['last_name']; 
                $_SESSION['referrer_id'] = $found_referrer['tlf_id'];
                $msg = array();
                $msg[0] = 2;
                $msg[1] = $found_referrer['first_name'] . " " . $found_referrer['last_name']; 
                $msg[2] = $found_referrer['tlf_id'];
                $msg[3] = $found_referrer['promoCode'];
                if($msg[3] == 'REDHAT') {//no trial
                    $price = 'price_1H6hsiGkFLnj68yK1kQM6fKY';
                } elseif($msg[3] == 'TLOKJ720') {//10day 
                    $price = 'price_1H8WXUGkFLnj68yKWCgroxex';
                } elseif($msg[3] == 'TLOCMM720') {//10day 
                    $price = 'price_1H8WXUGkFLnj68yKWCgroxex';
                } elseif($msg[3] == 'TLODJ720') {//10day 
                    $price = 'price_1H8WXUGkFLnj68yKWCgroxex';
                } else {//30day
                    $price = 'price_1H8atlGkFLnj68yKS0Oasf4z';
                }
                $msg[4] = $price;
                echo json_encode($msg);
            }
        } else {
            $msg = array();
            $msg[0] = 1;
            echo json_encode($msg);
        }
	
?>