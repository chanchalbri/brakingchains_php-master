<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
// newUser.php - called by the register.php form
// to create new user while ensuring user doesn't already exist
//
// (c) 2018, 5Onit
// Written by James Misa 

// START FORM PROCESSING
$string = file_get_contents("php://input", false, stream_context_create($options));
$json_a=json_decode($string,true);
$errors = array();

    // perform validations on the form data
    $required_fields = array('first_name', 'last_name', 'email', 'phone', 'fireDate', 'referrer_name', 'ref_id', 'password');
    $errors = array_merge($errors, check_required_fields($required_fields, $_REQUEST));

    $fields_with_lengths = array('password' => 30);
    $errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_REQUEST));

    $first_name = trim($_REQUEST['first_name']);
    $last_name = trim($_REQUEST['last_name']);
    $email = trim($_REQUEST['email']);
    $referrer_name = trim($_REQUEST['referrer_name']);
    $ref_id = trim($_REQUEST['ref_id']);
    $phone = trim($_REQUEST['phone']);
    $pre_date = trim($_REQUEST['fireDate']);
    $fireDate = strtotime($pre_date);
    //need to generate a temporary password
    //$temp_password = generateRandomString(); 
    $password = trim($_REQUEST['password']);
    $hashed_password = hash('sha256', $password);
    

    if (empty($errors)) {

    //This query is to confirm that this user does not already exist.	
    $query = sprintf("SELECT * FROM users WHERE email='%s'", 
        mysqli_real_escape_string($connection, $email));

        $result = mysqli_query($connection, $query);

        if (mysqli_num_rows($result) > 0) {//if exists pull tlf_id
                //User exists
                $existing_gifter = $first_name;
                while($found_user = mysqli_fetch_array($result)){
                    $tlf_id = $found_user['tlf_id'];
                    $name = $found_user['first_name'] . " " . $found_user['last_name'];
                }
            
                $msg = "This email is already used by " . $name . ".";
                $msg .= " Please use your existing login credentials.";
                echo $msg;
            } else {
                $tlf_id = createTLFid();
                $current_time = date('Y-m-d H:i:s');
                //Create new user	
                $query = "INSERT INTO users (
                        creation_date_time,
                        first_name, 
                        last_name, 		
                        email, 	
                        hashed_password,
                        phone,
                        fireDate,
                        tlf_id,
                        referrer_name,
                        referrer
                        ) VALUES (
                        '{$current_time}', 
                        '{$first_name}', 
                        '{$last_name}', 
                        '{$email}', 
                        '{$hashed_password}',
                        '{$phone}',
                        '{$fireDate}',
                        '{$tlf_id}',
                        '{$referrer_name}',
                        '{$ref_id}'
                    )";
            
            $result = mysqli_query($connection, $query);
            if (mysqli_affected_rows($connection) > 0) {//Success!
                
                //Create new milestone	
                $query2 = "INSERT INTO milestones (
                        tlf_id, 
                        ref_id
                        ) VALUES (
                        '{$tlf_id}', 
                        '{$ref_id}'
                    )";
            
                $result2 = mysqli_query($connection, $query2);
                if (mysqli_affected_rows($connection) > 0) {//Success!
                
                //send welcome email
                //welcomeEmail($email, $first_name, $tlf_id, $temp_password);

                $msg = "Congrats! You're free to login.";
                echo $msg;
                } else {
                    //Display error message.
                    echo "<p>New milestone setup failed.</p>";
                    echo "<p>" . mysqli_error($connection) . "</p>";
                  }	
                     
              } else {
                //Display error message.
                echo "<p>New Seed setup failed.</p>";
                echo "<p>" . mysqli_error($connection) . "</p>";
              }	
            }
    } else {
        $msg = "We have errors";
        echo $msg . "Errors: " . print_r($errors);
    }

	
?>