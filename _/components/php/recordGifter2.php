<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
// resetPassword.php - called by the admin_portal.php form
// to reset a user's password
//
// (c) 2020, TLF
// Written by James Misa 

$water_id = $_REQUEST['water_id'];
$fire_id = $_REQUEST['fire_id'];
$gifted_date = $_REQUEST['gifted_date'];

$current_time = date('Y-m-d H:i:s');
$query = "INSERT INTO harvests (
            creationDateTime,
            water_id, 
            fire_id, 		
            gift_date
            ) VALUES (
            '{$current_time}', 
            '{$water_id}', 
            '{$fire_id}', 
            '{$gifted_date}'
        )";

    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);

$query2 = "UPDATE users SET flower = 1 WHERE lotus_id='{$fire_id}'";
$result = mysqli_query($connection, $query2);