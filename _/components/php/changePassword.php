<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
// changePassword.php - called by the user.php form
// to change a user's password
//
// (c) 2020, TLF
// Written by James Misa 

// START FORM PROCESSING
$errors = array();

    // perform validations on the form data
    $required_fields = array('password', 'currPassword', 'email');
    $errors = array_merge($errors, check_required_fields($required_fields, $_REQUEST));

    $fields_with_lengths = array('password' => 30);
    $errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_REQUEST));

    $currPassword = trim($_REQUEST['currPassword']);
    $hashed_currPassword = hash('sha256', $currPassword);
    $email = trim($_REQUEST['email']);
    $password = trim($_REQUEST['password']);   
    $hashed_password = hash('sha256', $password);

    if (empty($errors)) {

        //let's update user's password	
        $query = "SELECT * ";
        $query .= "FROM users ";
        $query .= "WHERE email = '{$email}' ";
        $query .= "AND hashed_password = '{$hashed_currPassword}' ";
        $query .= "LIMIT 1";
        $result = mysqli_query($connection, $query);
        
        if(mysqli_num_rows($result) == 1) {//this is the right user
            $found_user = mysqli_fetch_array($result);

                $query = "UPDATE users SET hashed_password = '{$hashed_password}' WHERE email='{$email}'";
                $result = mysqli_query($connection, $query);
            $msg = "Password updated.";
            echo $msg;
            
        } else {
            $msg = "ID and password combo - " . $tlf_id . " - did not match";
            echo $msg; 
        }         
    } else {
        $msg = "We have errors";
        echo $msg . print_r($errors);
    }

	
?>