<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
// addSeedAdminSubmit.php - called by the myFlowers.php form
// to convert a seed to a flower as an Admin
//
// (c) 2020, TLF
// Written by James Misa 

$seed = trim($_REQUEST['seed']);
$host_lotus_id = trim($_SESSION['focus_flower_id']);
$pre_date = trim($_REQUEST['fireDate']);
$fireDate = strtotime($pre_date);


    $num = count($_SESSION['seedsAdmin']);
    for($i=0; $i<$num; $i++) {
        if($seed == $_SESSION['seedsAdmin'][$i]['name']) {
            $tlf_id = trim($_SESSION['seedsAdmin'][$i]['tlf_id']);
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
        $gen = $found_host['gen'] + 1;
        $flower = intval(1);
    }
    
    $lotus_id = $tlf_id . "_0";
    $query = "UPDATE users 
              SET lotus_id = '{$lotus_id}',
                  fireDate = '{$fireDate}',
                  air_id = '{$host_lotus_id}',
                  earth_id = '{$earth_id}',
                  water_id = '{$water_id}',
                  gen = '{$gen}',
                  flower = '{$flower}'
              WHERE tlf_id='{$tlf_id}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    if(mysqli_affected_rows($connection) == 1) {
        echo "Flower created!";
    } else {
        echo "Cannot update seed " . $tlf_id;
    }


?>