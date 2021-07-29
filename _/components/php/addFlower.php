<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
// addFlower.php - called by the myFlowers.php form
// to convert a seed to a flower
//
// (c) 2020, TLF
// Written by James Misa 

$seed_id = trim($_REQUEST['seed_id']);
$host_lotus_id = trim($_REQUEST['parent_id']);
$pre_date = trim($_REQUEST['fireDate']);
$fireDate = strtotime($pre_date);

    $query2 = "SELECT * ";
    $query2 .= "FROM users ";
    $query2 .= "WHERE id = '{$seed_id}'";
    $resultSet2 = mysqli_query($connection, $query2);
    confirm_query($resultSet2, $connection);
    
    while($found_seed = mysqli_fetch_array($resultSet2)) {
        $name = $found_seed['first_name'] . " " . $found_seed['last_name'];
        $first_name = $found_seed['first_name'];
        $phone = $found_seed['phone'];
        $tlf_id = $found_seed['tlf_id'];
        $email_address = $found_seed['email'];
    }

if($host_lotus_id == "007") {
    $air_id = "none";
    $earth_id = "none";
    $water_id = "007";
    $gift_amt = "100";
    $board_brand = "gate";
    $gen = "1";
    $flower = "1";
    $ext = "_100";
} else if($host_lotus_id == "777") {
    $air_id = "none";
    $earth_id = "none";
    $water_id = "777";
    $gift_amt = "500";
    $board_brand = "garden";
    $gen = "1";
    $flower = "1";
    $ext = "_500";
    $water = "N/A";
    $water_phone = "N/A";
    $water_email = "N/A";
    $water_method = "N/A";
} else {
    $query = "SELECT * ";
    $query .= "FROM users ";
    $query .= "WHERE id = '{$host_lotus_id}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    while($found_host = mysqli_fetch_array($resultSet)) {
        $air_id = $found_host['lotus_id'];
        $earth_id = $found_host['air_id'];
        $water_id = $found_host['earth_id'];
        $gift_amt = $found_host['gift_amt'];
        $board_brand = $found_host['board_brand'];
        $gen = $found_host['gen'] + 1;
        $flower = intval(1);
    }
    $water = getUserName($connection, $water_id);
    $water_phone = getUserPhone($connection, $water_id);
    $water_email = getUserEmail($connection, $water_id);
    $water_method = getWaterMethod($connection, $water_id);
    
    if($board_brand == "garden") {
        $ext = "_500";
    } else if ($board_brand == "gate") {
        $ext = "_100";
    } else {
        $ext = "_0";
    }
}
    
    $lotus_id = $tlf_id . $ext;
    $query = "UPDATE users 
              SET lotus_id = '{$lotus_id}',
                  fireDate = '{$fireDate}',
                  sowDate = '{$fireDate}',
                  air_id = '{$air_id}',
                  earth_id = '{$earth_id}',
                  water_id = '{$water_id}',
                  gift_amt = '{$gift_amt}',
                  board_brand = '{$board_brand}',
                  flower = 1,
                  gen = '{$gen}'
              WHERE id='{$seed_id}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    
    
    if(mysqli_affected_rows($connection) == 1) {
        //messageNewFire($connection, $phone, $first_name, $water_id, $fireDate);
        //messageWater($connection, $phone, $name, $water_id, $fireDate);
        if($host_lotus_id == "007") {
            
        } else {
           welcomeEmailGarden($email_address, $water, $water_phone, $water_email, $water_method, $pre_date);  
        }
        echo "Tree created!";
    } else {
        echo "Cannot add seed " . $tlf_id;
    }


?>