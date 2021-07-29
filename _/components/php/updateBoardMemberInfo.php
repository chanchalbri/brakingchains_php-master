<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
// addFlower.php - called by the myFlowers.php form
// to convert a seed to a flower
//
// (c) 2020, TLF
// Written by James Misa 

$inviter = trim($_REQUEST['inviter']);
$first_name = trim($_REQUEST['first_name']);
$last_name = trim($_REQUEST['last_name']);
$email = trim($_REQUEST['email']);
$phone = trim($_REQUEST['phone']);
$promoCode = trim($_REQUEST['promoCode']);
$tlf_id = trim($_REQUEST['tlf_id']);


    $num = count($_SESSION['boardWater']);
    for($i=0; $i<$num; $i++) {
        if($inviter == $_SESSION['boardWater'][$i]['name']) {
            $inviter_id = trim($_SESSION['boardWater'][$i]['tlf_id']);
        }
    }

    $inviterEmailQuery = "SELECT * FROM users WHERE tlf_id = '{$inviter_id}' LIMIT 1";
    $resultSet = mysqli_query($connection, $inviterEmailQuery);
    confirm_query($resultSet, $connection);

    $found_inviter = mysqli_fetch_array($resultSet);
    $inviter_email = $found_inviter['email'];

    $query = "UPDATE users 
              SET first_name = '{$first_name}',
                  last_name = '{$last_name}',
                  email = '{$email}',
                  phone = '{$phone}',
                  promoCode = '{$promoCode}',
                  referrer_name = '{$inviter_email}'
              WHERE tlf_id='{$tlf_id}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);

    if(mysqli_affected_rows($connection)) {
        $log = "User info for " . $tlf_id . " was updated to First Name: " . $first_name . ", Last Name: " . $last_name . ", Email: " . $email . ", Phone: " . $phone . ", PromoCode: " . $promoCode . ", and Inviter: " . $inviter_id;
        $type = "Edit Info";
        $user = $_SESSION['first_name'] . " " . $_SESSION['last_name'];
        //addLog($connection, $user, $type, $log);
        echo "User Updated!";
    } else {
        echo "Something went wrong!";
    }
    

?>