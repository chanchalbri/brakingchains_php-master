<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
// termsAgreed.php - called by the form modal on the seeds page
// to update the user's terms agreement field
//
// (c) 2020, TLF
// Written by James Misa 

$tlf_id = $_REQUEST['tlf_id'];

$query = "SELECT *";
$query .= "FROM users ";
$query .= "WHERE tlf_id = '{$tlf_id}'";
$resultSet = mysqli_query($connection, $query);
confirm_query($resultSet, $connection);

$found_user = mysqli_fetch_array($resultSet);
$email = $found_user['email'];

    //welcomeEmail($email);

    $query = "UPDATE users SET terms = 1 WHERE tlf_id='{$tlf_id}'";
    $result = mysqli_query($connection, $query);
    $msg = "Thank You!";
    echo $msg;

	
?>