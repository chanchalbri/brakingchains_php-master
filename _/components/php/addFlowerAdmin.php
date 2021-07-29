<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
// addFlower.php - called by the myFlowers.php form
// to convert a seed to a flower
//
// (c) 2020, TLF
// Written by James Misa 

$flower = trim($_REQUEST['flower']);
$host_lotus_id = trim($_SESSION['focus_flower_id']);
$pre_date = trim($_REQUEST['fireDate']);
$fireDate = strtotime($pre_date);

if($flower == 'Yourself') {
    $query = "SELECT * ";
    $query .= "FROM users ";
    $query .= "WHERE lotus_id = '{$host_lotus_id}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    while($found_host = mysqli_fetch_array($resultSet)) {
        $earth_id = $found_host['air_id'];
        $water_id = $found_host['earth_id'];
        $board_brand = $found_host['board_brand'];
        $gen = $found_host['gen'] + 1;
        $flower = intval(1);
    }
    
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
    $email = $_SESSION['email'];
    $hashed_password = $_SESSION['hashed_password'];
    $phone = $_SESSION['phone'];
    $tlf_id = $_SESSION['tlf_id'];
    $promoCode = $_SESSION['promoCode'];
    $referrer_name = $first_name . " " . $last_name;
    $referrer = $tlf_id;
    $lotus_id = createLotusId($connection, $tlf_id, $board_brand);
    
    $current_time = date('Y-m-d H:i:s');
    //Create new flower	
    $query2 = "INSERT INTO users (
            creation_date_time,
            first_name, 
            last_name, 		
            email, 	
            hashed_password,
            phone,
            fireDate,
            sowDate,
            tlf_id,
            lotus_id,
            air_id,
            earth_id,
            water_id,
            gen,
            referrer_name,
            referrer,
            flower,
            promoCode
            ) VALUES (
            '{$current_time}', 
            '{$first_name}', 
            '{$last_name}', 
            '{$email}', 
            '{$hashed_password}',
            '{$phone}',
            '{$fireDate}',
            '{$fireDate}',
            '{$tlf_id}',
            '{$lotus_id}',
            '{$host_lotus_id}',
            '{$earth_id}',
            '{$water_id}',
            '{$gen}',
            '{$referrer_name}',
            '{$ref_id}',
            '{$flower}',
            '{$promoCode}'
        )";

    $resultSet2 = mysqli_query($connection, $query2);
    confirm_query($resultSet2, $connection);
    if(mysqli_affected_rows($connection) > 0) {
        echo "Flower created!";
    } else {
        echo "Cannot update seed " . $tlf_id;
    }
} else {
    $num = count($_SESSION['flowersAdmin']);
    for($i=0; $i<$num; $i++) {
        if($flower == $_SESSION['flowersAdmin'][$i]['name']) {
            $tlf_id = trim($_SESSION['flowersAdmin'][$i]['tlf_id']);
        }
    }
  $query = "SELECT * ";
    $query .= "FROM users ";
    $query .= "WHERE lotus_id = '{$host_lotus_id}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    while($found_host = mysqli_fetch_array($resultSet)) {
        $earth_id = $found_host['air_id'];
        $water_id = $found_host['earth_id'];
        $board_brand = $found_host['board_brand'];
        $gen = $found_host['gen'] + 1;
        $flower = intval(1);
    }
    
    $query2 = "SELECT * ";
    $query2 .= "FROM users ";
    $query2 .= "WHERE tlf_id = '{$tlf_id}'";
    $resultSet2 = mysqli_query($connection, $query2);
    confirm_query($resultSet2, $connection);
    
    while($found_flower = mysqli_fetch_array($resultSet2)) {
        $first_name = $found_flower['first_name'];
        $last_name = $found_flower['last_name'];
        $email = $found_flower['email'];
        $hashed_password = $found_flower['hashed_password'];
        $phone = $found_flower['phone'];
        $referrer_name = $found_flower['referrer_name'];
        $referrer = $found_flower['referrer'];
        $promoCode = $found_flower['promoCode'];
        $lotus_id = createLotusId($connection, $tlf_id, $board_brand);
    }
    
    $current_time = date('Y-m-d H:i:s');
    //Create new flower	
    $query2 = "INSERT INTO users (
            creation_date_time,
            first_name, 
            last_name, 		
            email, 	
            hashed_password,
            phone,
            fireDate,
            sowDate,
            tlf_id,
            lotus_id,
            air_id,
            earth_id,
            water_id,
            gen,
            referrer_name,
            referrer,
            flower,
            promoCode
            ) VALUES (
            '{$current_time}', 
            '{$first_name}', 
            '{$last_name}', 
            '{$email}', 
            '{$hashed_password}',
            '{$phone}',
            '{$fireDate}',
            '{$fireDate}',
            '{$tlf_id}',
            '{$lotus_id}',
            '{$host_lotus_id}',
            '{$earth_id}',
            '{$water_id}',
            '{$gen}',
            '{$referrer_name}',
            '{$ref_id}',
            '{$flower}',
            '{$promoCode}'
        )";

    $resultSet2 = mysqli_query($connection, $query2);
    confirm_query($resultSet2, $connection);
    if(mysqli_affected_rows($connection) > 0) {
        //welcomeEmail($email);
        echo "Flower created!";
    } else {
        echo "Cannot update seed " . $tlf_id;
    }
}

?>