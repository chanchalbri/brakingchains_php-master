<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
// addFlower.php - called by the myFlowers.php form
// to convert a seed to a flower
//
// (c) 2020, TLF
// Written by James Misa 
error_reporting(E_ALL);
ini_set('display_errors', 1);
$name = trim($_REQUEST['name']);


    $num = count($_SESSION['boardWater']);
   $tlf_id="";
    $board_inviter="";
    $first_name="";
    $last_name="";
    $email="";
    $phone="";
    $tlf_id="";
    $promoCode="";
    $board_ref_id="";
    for($i=0; $i<$num; $i++) {
        if($name == $_SESSION['boardWater'][$i]['name']) {
            $tlf_id = trim($_SESSION['boardWater'][$i]['tlf_id']);
        }
    }

    $query = "SELECT * ";
    $query .= "FROM users ";
    //$query .= "WHERE tlf_id = '{$tlf_id}'";
    $query .= "WHERE tlf_id = '5faa1a397f41a'";
    
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
     $msg = array();
    while($found_user = mysqli_fetch_array($resultSet)) {
        
        $first_name = $found_user['first_name'];
        $last_name = $found_user['last_name'];
        $email = $found_user['email'];
        $phone = $found_user['phone'];
        $promoCode = $found_user['promoCode'];
        $board_ref_email = $found_user['referrer_name'];
        $board_ref_id = "";
        $board_inviter = getReferrerName($connection, $board_ref_email);
     
    }
   
       $msg[0] = "Success";
      $msg[1] = $board_inviter;
      $msg[2] = $first_name;
      $msg[3] = $last_name;
      $msg[4] = $email;
      $msg[5] = $phone;
      $msg[6] = $tlf_id;
      $msg[7] = $promoCode;
      $msg[8] = $board_ref_id;
      echo json_encode($msg);

?>