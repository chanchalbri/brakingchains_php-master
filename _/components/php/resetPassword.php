<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
// resetPassword.php - called by the admin_portal.php form
// to reset a user's password
//
// (c) 2020, TLF
// Written by James Misa 

$email = $_REQUEST['email'];

$query = "SELECT *";
        $query .= "FROM users ";
        $query .= "WHERE email = '{$email}'";
        $resultSet = mysqli_query($connection, $query);
        confirm_query($resultSet, $connection);

    if(mysqli_num_rows($resultSet) > 0) {
        while($found_user = mysqli_fetch_array($resultSet)) {
            $phone = $found_user['phone'];
        }
        $last_four = substr($phone, -4);
        $defPassword = "password" . $last_four;
        $hashed_def_password = hash('sha256', $defPassword);
        
        $query = "UPDATE users SET hashed_password = '{$hashed_def_password}' WHERE email='{$email}'";
        $result = mysqli_query($connection, $query);
        
        echo "Password has been reset";
    } else {
        echo "This email does not exist.";
    }