<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
// addFlower.php - called by the myFlowers.php form
// to convert a seed to a flower
//
// (c) 2020, TLF
// Written by James Misa 


if(isset($_REQUEST['email'])){
    
    $email_address = trim($_REQUEST['email']);
    $query = "SELECT * ";
    $query .= "FROM users ";
    $query .= "WHERE email = '{$email_address}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    if(mysqli_num_rows($resultSet) > 0) {
        while($users = mysqli_fetch_array($resultSet)) {
        $email_address = $users['email'];
        $first_name = $users['first_name'];
        $tlf_id = $users['tlf_id'];
        $temp_password = 'manase';
        
        firstEmail($email_address, $first_name, $tlf_id, $temp_password);
        }
        echo "Email Sent";
    } else {
        echo "This email " . $email_address . " address does not exist";
    }
} 

?>