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
    $required_fields = array('first_name', 'last_name', 'email', 'phone', 'referrer_name', 'ref_id', 'password', 'promoCode', 'priceCode');
    $errors = array_merge($errors, check_required_fields($required_fields, $_REQUEST));

    $fields_with_lengths = array('password' => 30);
    $errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_REQUEST));

    $first_name = trim($_REQUEST['first_name']);
    $last_name = trim($_REQUEST['last_name']);
    $display_name = $first_name . " " . $last_name;
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
    $giftMethod = "";
    $methodUsername = "";
    $promoCode = trim($_REQUEST['promoCode']);
    $priceCode = trim($_REQUEST['priceCode']);
    $name = $first_name . " " . $last_name;
    

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
            
                $msg = array();
                $msg[0] = "Error";
                $msg[1] = "This email is already used by " . $name . "."; 
                echo json_encode($msg);
            } else {
                //see if inviter has an open Earth petal
                $query5 = "SELECT *";
                $query5 .= "FROM users ";
                $query5 .= "WHERE id = '{$_SESSION['id']}'";
                $resultSet5 = mysqli_query($connection, $query5);
                confirm_query($resultSet5, $connection);
            
                while($found_inviter = mysqli_fetch_array($resultSet5)) {
                    $inviter_lotus_id = $found_inviter['lotus_id'];
                    $inviter_air_id = $found_inviter['air_id'];
                    $inviter_earth_id = $found_inviter['earth_id'];
                    $inviter_gen = $found_inviter['gen'];
                    $board_brand = $found_inviter['board_brand'];
                }
    
                $query6 = "SELECT *";
                $query6 .= "FROM users ";
                $query6 .= "WHERE air_id = '{$inviter_lotus_id}'";
                $resultSet6 = mysqli_query($connection, $query6);
                confirm_query($resultSet6, $connection);
            
                if(mysqli_num_rows($resultSet6) > 1) {//add referral as a seed
                    $tlf_id = createTLFid();
                    $current_time = date('Y-m-d H:i:s');
                    //Create new user	
                    $query2 = "INSERT INTO users (
                            creation_date_time,
                            first_name, 
                            last_name, 
                            display_name,		
                            email, 	
                            hashed_password,
                            phone,
                            fireDate,
                            sowDate,
                            tlf_id,
                            referrer_name,
                            referrer,
                            promoCode,
                            terms
                            ) VALUES (
                            '{$current_time}', 
                            '{$first_name}', 
                            '{$last_name}',  
                            '{$display_name}', 
                            '{$email}', 
                            '{$hashed_password}',
                            '{$phone}',
                            '{$fireDate}',
                            '{$fireDate}',
                            '{$tlf_id}',
                            '{$referrer_name}',
                            '{$ref_id}',
                            '{$promoCode}',
                            1
                        )";

                $result2 = mysqli_query($connection, $query2);

                if (mysqli_affected_rows($connection) > 0) {//Success!

                    //add gift method
                    $query3 = "INSERT INTO gift_methods (
                            tlf_id,
                            gift_method,
                            method_username
                            ) values (
                            '{$tlf_id}',
                            '{$giftMethod}',
                            '{$methodUsername}'
                    )";

                    $result3 = mysqli_query($connection, $query3);

                    //Create new milestone	
                    $query4 = "INSERT INTO milestones (
                            tlf_id, 
                            ref_id
                            ) VALUES (
                            '{$tlf_id}', 
                            '{$ref_id}'
                        )";

                    $result4 = mysqli_query($connection, $query4);
                    if (mysqli_affected_rows($connection) > 0) {//Success!

                    //send welcome email
                    //welcomeEmail($email, $first_name, $tlf_id, $temp_password);

                    session_destroy();

                    $msg = array();
                    $msg[0] = "Success";
                    $msg[1] = $name; 
                    $msg[2] = $email;
                    $msg[3] = $tlf_id;
                    $msg[4] = $promoCode;
                    $msg[5] = $priceCode;
                    echo json_encode($msg);
                    } else {
                        //Display error message..
                        $msg = array();
                        $msg[0] = "Error";
                        $msg[1] = mysqli_error($connection); 
                        echo json_encode($msg); 
                      }	

                  } else {
                    //Display error message..
                    $msg = array();
                    $msg[0] = "Error";
                    $msg[1] = mysqli_error($connection); 
                    echo json_encode($msg); 
                  }	
                } else {//place referral on flower
                    $tlf_id = createTLFid();
                    $gen = $inviter_gen + 1;
                    $lotus_id = createLotusId($connection, $tlf_id, $board_brand);
                    $current_time = date('Y-m-d H:i:s');
                    //Create new user	
                    $query2 = "INSERT INTO users (
                            creation_date_time,
                            first_name, 
                            last_name,  
                            display_name, 		
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
                            promoCode,
                            terms
                            ) VALUES (
                            '{$current_time}', 
                            '{$first_name}', 
                            '{$last_name}', 
                            '{$display_name}', 
                            '{$email}', 
                            '{$hashed_password}',
                            '{$phone}',
                            '{$fireDate}',
                            '{$fireDate}',
                            '{$tlf_id}',
                            '{$lotus_id}',
                            '{$inviter_lotus_id}',
                            '{$inviter_air_id}',
                            '{$inviter_earth_id}',
                            '{$gen}',
                            '{$referrer_name}',
                            '{$ref_id}',
                            '{$promoCode}',
                            1
                        )";

                $result2 = mysqli_query($connection, $query2);

                if (mysqli_affected_rows($connection) > 0) {//Success!

                    //add gift method
                    $query3 = "INSERT INTO gift_methods (
                            tlf_id,
                            gift_method,
                            method_username
                            ) values (
                            '{$tlf_id}',
                            '{$giftMethod}',
                            '{$methodUsername}'
                    )";

                    $result3 = mysqli_query($connection, $query3);

                    //Create new milestone	
                    $query4 = "INSERT INTO milestones (
                            tlf_id, 
                            ref_id
                            ) VALUES (
                            '{$tlf_id}', 
                            '{$ref_id}'
                        )";

                    $result4 = mysqli_query($connection, $query4);
                    if (mysqli_affected_rows($connection) > 0) {//Success!

                    //send welcome email
                    //welcomeEmail($email, $first_name, $tlf_id, $temp_password);

                    session_destroy();
                    
                    $msg = array();
                    $msg[0] = "Success";
                    $msg[1] = $name;   
                    $msg[2] = $email;
                    $msg[3] = $tlf_id;
                    $msg[4] = $promoCode;
                    $msg[5] = $priceCode;
                    echo json_encode($msg); 
                    } else {
                        //Display error message.
                        $msg = array();
                        $msg[0] = "Error";
                        $msg[1] = mysqli_error($connection); 
                        echo json_encode($msg); 
                      }	

                  } else {
                    //Display error message.
                    $msg = array();
                    $msg[0] = "Error";
                    $msg[1] = mysqli_error($connection); 
                    echo json_encode($msg); 
                  }	
                }
            }
    } else {
        $msg = array();
        $msg[0] = "Error";
        $msg[1] = print_r($errors); 
        echo json_encode($msg);   
    }

	
?>