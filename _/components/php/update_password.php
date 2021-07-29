<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
// update_password.php - called by the verify.php form
// to update the new user's temp password
//
// (c) 2020, TLF
// Written by James Misa 

// START FORM PROCESSING
$errors = array();

    // perform validations on the form data
    $required_fields = array('password', 'temp_password', 'tlf_id');
    $errors = array_merge($errors, check_required_fields($required_fields, $_REQUEST));

    $fields_with_lengths = array('password' => 30);
    $errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_REQUEST));

    $temp_password = trim($_REQUEST['temp_password']);
    $hashed_temp_password = hash('sha256', $temp_password);
    $tlf_id = trim($_REQUEST['tlf_id']);
    $password = trim($_REQUEST['password']);  
    $hashed_password = hash('sha256', $password);

    if (empty($errors)) {

        //let's update user's password	
        $query = "SELECT * ";
        $query .= "FROM users ";
        $query .= "WHERE tlf_id = '{$tlf_id}' ";
        $query .= "AND hashed_password = '{$hashed_temp_password}' ";
        $query .= "LIMIT 1";
        $result = mysqli_query($connection, $query);
        
        if(mysqli_num_rows($result) == 1) {//this is the right user
            $found_user = mysqli_fetch_array($result);
                $lotus_id = $found_user['lotus_id'];

                $query = "UPDATE users SET hashed_password = '{$hashed_password}' WHERE lotus_id='{$lotus_id}'";
                $result = mysqli_query($connection, $query);
            $msg = "Password updated.";
            echo $msg;
            
        } else {
            $msg = "ID and password combo did not match";
            echo $msg; 
        }         
    } else {
        $msg = "We have errors";
        echo $msg . print_r($errors);
    }

	
?>