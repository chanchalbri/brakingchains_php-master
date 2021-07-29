<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
// processLogin.php - called by the login.php form 
// to process login validation
//
// (c) 2020, TLF
// Written by James Misa 

date_default_timezone_set('America/Los_Angeles');
// START FORM PROCESSING
$errors = array(); 

    // perform validations on the form data
    $required_fields = array('email', 'password');
    $errors = array_merge($errors, check_required_fields($required_fields, $_REQUEST));

    $email = trim($_REQUEST['email']);
    $password = trim($_REQUEST['password']);
    $hashed_password = hash('sha256', $password);

    if (empty($errors)) {
        // Check database to see if username and the hashed password exist there.
        $query = "SELECT * ";
        $query .= "FROM users ";
        $query .= "WHERE email = '{$email}' ";
        $query .= "AND hashed_password = '{$hashed_password}' ";
        $query .= "ORDER BY creation_date_time ASC ";
        $query .= "LIMIT 1";
        $resultSet = mysqli_query($connection, $query);
        confirm_query($resultSet, $connection);
        if (mysqli_num_rows($resultSet) == 1) {
            // username/password authenticated  
            while($foundUser = mysqli_fetch_array($resultSet)) {
                $tlf_id = $foundUser['tlf_id'];
                $_SESSION['tlf_id'] = $foundUser['tlf_id'];
                $_SESSION['first_name'] = $foundUser['first_name'];
                $_SESSION['last_name'] = $foundUser['last_name'];
                $_SESSION['display_name'] = $foundUser['display_name'];
                $_SESSION['email'] = $foundUser['email'];
                $_SESSION['phone'] = $foundUser['phone'];
                $_SESSION['hashed_password'] = $foundUser['hashed_password'];
                $_SESSION['referrer_name'] = $foundUser['referrer_name'];
                $_SESSION['referrer'] = $foundUser['referrer'];
                $formatted_fireDate = date("m/d/Y", (int)$foundUser['fireDate']);
                $_SESSION['fireDate'] = $formatted_fireDate;
                if($foundUser['air_id'] == NULL){$_SESSION['seed'] = 1;}else{$_SESSION['seed']=0;}
                $_SESSION['gen'] = $foundUser['gen'];
                $_SESSION['flower'] = $foundUser['flower'];
                $_SESSION['admin'] = $foundUser['admin'];
                $_SESSION['promoCode'] = $foundUser['promoCode'];
                $_SESSION['view'] = $foundUser['view'];
                $_SESSION['navbar'] = 1;
                $terms = $foundUser['terms'];
            }
            
            $query = "SELECT *";
            $query .= "FROM users ";
            $query .= "WHERE tlf_id = '{$tlf_id}'";
            $resultSet1 = mysqli_query($connection, $query);
            confirm_query($resultSet1, $connection);
            
            $flower_count = mysqli_num_rows($resultSet1);
            $_SESSION['flower_count'] = $flower_count;
            $_SESSION['flowers'] = array();
            $i=0;
            while($found_flowers = mysqli_fetch_array($resultSet1)) {
                $_SESSION['flowers'][$i] = array();
                $_SESSION['flowers'][$i]['first_name'] = $found_flowers['first_name'];
                $_SESSION['flowers'][$i]['last_name'] = $found_flowers['last_name'];
                $_SESSION['flowers'][$i]['email'] = $found_flowers['email'];
                $_SESSION['flowers'][$i]['phone'] = $found_flowers['phone'];
                $_SESSION['flowers'][$i]['referrer'] = $found_flowers['referrer'];
                $_SESSION['flowers'][$i]['lotus_id'] = $found_flowers['lotus_id'];
                $_SESSION['flowers'][$i]['water_id'] = $found_flowers['water_id'];
                $_SESSION['flowers'][$i]['gen'] = $found_flowers['gen']; 
                $formatted_fireDate = date("m/d/Y", $found_flowers['fireDate']); 
                $_SESSION['flowers'][$i]['fireDate'] = $formatted_fireDate;
                $_SESSION['flowers'][$i]['petal_count'] = getPetalCount($connection, $found_flowers['lotus_id']);
                $_SESSION['flowers'][$i]['eco_count'] = getEcoCount($connection, $found_flowers['lotus_id']);
                
                //get user's earths
                $_SESSION['flowers'][$i]['earths'] = array();
                $query = "SELECT *";
                $query .= "FROM users ";
                $query .= "WHERE air_id = '{$found_flowers['lotus_id']}'";
                $resultSet2 = mysqli_query($connection, $query);
                confirm_query($resultSet2, $connection);
                
                if(mysqli_num_rows($resultSet2) > 0){//user has earths
                    $_SESSION['number of earths'] = mysqli_num_rows($resultSet2);
                    $e = 0;
                    while($found_earth = mysqli_fetch_array($resultSet2)){//loop through earths
                    $_SESSION['flowers'][$i]['earths'][$e] = array();
                    $_SESSION['flowers'][$i]['earths'][$e]['first_name'] = $found_earth['first_name'];
                    $_SESSION['flowers'][$i]['earths'][$e]['last_name'] = $found_earth['last_name'];
                    $_SESSION['flowers'][$i]['earths'][$e]['email'] = $found_earth['email'];
                    $_SESSION['flowers'][$i]['earths'][$e]['phone'] = $found_earth['phone'];
                    $_SESSION['flowers'][$i]['earths'][$e]['referrer'] = $found_earth['referrer'];
                    $_SESSION['flowers'][$i]['earths'][$e]['lotus_id'] = $found_earth['lotus_id'];
                    $_SESSION['flowers'][$i]['earths'][$e]['water_id'] = $found_earth['water_id'];
                    $_SESSION['flowers'][$i]['earths'][$e]['gen'] = $found_earth['gen'];
                    $formatted_fireDate = date("m/d/Y", (int)$found_earth['fireDate']);
                    $_SESSION['flowers'][$i]['earths'][$e]['fireDate'] = $formatted_fireDate;
                    $_SESSION['flowers'][$i]['earths'][$e]['petal_count'] = getPetalCount($connection, $found_earth['lotus_id']);
                    $_SESSION['flowers'][$i]['earths'][$e]['eco_count'] = getEcoCount($connection, $found_earth['lotus_id']);
                       
                        //get user's earth's 2
                        $_SESSION['flowers'][$i]['earths'][$e]['airs'] = array();
                        $query = "SELECT *";
                        $query .= "FROM users ";
                        $query .= "WHERE air_id = '{$found_earth['lotus_id']}'";
                        $resultSet3 = mysqli_query($connection, $query);
                        confirm_query($resultSet3, $connection);
                        
                        if(mysqli_num_rows($resultSet3) > 0) {//user has airs
                            $ee = 0;
                            $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee] = array();
                            while($found_e_earth = mysqli_fetch_array($resultSet3)){//loop through airs
                                $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['first_name'] = $found_e_earth['first_name'];
                                $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['last_name'] = $found_e_earth['last_name'];
                                $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['email'] = $found_e_earth['email'];
                                $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['phone'] = $found_e_earth['phone'];
                                $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['referrer'] = $found_e_earth['referrer'];
                                $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['lotus_id'] = $found_e_earth['lotus_id'];
                                $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['water_id'] = $found_e_earth['water_id'];
                                $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['gen'] = $found_e_earth['gen'];
                                $formatted_fireDate = date("m/d/Y", $found_e_earth['fireDate']);
                                $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fireDate'] = $formatted_fireDate;
                                $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['petal_count'] = getPetalCount($connection, $found_e_earth['lotus_id']);
                                $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['eco_count'] = getEcoCount($connection, $found_e_earth['lotus_id']);
                                
                                //get user's earth's 3
                                $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'] = array();
                                $query = "SELECT *";
                                $query .= "FROM users ";
                                $query .= "WHERE air_id = '{$found_e_earth['lotus_id']}'";
                                $resultSet4 = mysqli_query($connection, $query);
                                confirm_query($resultSet4, $connection);

                                if(mysqli_num_rows($resultSet4) > 0) {//user has fires
                                    $eee = 0;
                                    $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee] = array();
                                    while($found_ee_earth = mysqli_fetch_array($resultSet4)){
                                        $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['first_name'] = $found_ee_earth['first_name'];
                                        $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['last_name'] = $found_ee_earth['last_name'];
                                        $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['email'] = $found_ee_earth['email'];
                                        $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['phone'] = $found_ee_earth['phone'];
                                        $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['referrer'] = $found_ee_earth['referrer'];
                                        $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['lotus_id'] = $found_ee_earth['lotus_id'];
                                        $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['water_id'] = $found_ee_earth['water_id'];
                                        $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['gen'] = $found_ee_earth['gen'];
                                        $formatted_fireDate = date("m/d/Y", $found_ee_earth['fireDate']);
                                        $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['fireDate'] = $formatted_fireDate;
                                        $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['petal_count'] = getPetalCount($connection, $found_ee_earth['lotus_id']);
                                        $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['eco_count'] = getEcoCount($connection, $found_ee_earth['lotus_id']);
                                        
                                        //get user's earth's 4
                                        $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['f-earths'] = array();
                                        $query = "SELECT *";
                                        $query .= "FROM users ";
                                        $query .= "WHERE air_id = '{$found_ee_earth['lotus_id']}'";
                                        $resultSet5 = mysqli_query($connection, $query);
                                        confirm_query($resultSet5, $connection);

                                        if(mysqli_num_rows($resultSet5) > 0) {//users fire has earths
                                            $eeee = 0;
                                            $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['f-earths'][$eeee] = array();
                                            while($found_eee_earth = mysqli_fetch_array($resultSet5)){
                                                $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['f-earths'][$eeee]['first_name'] = $found_eee_earth['first_name'];
                                                $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['f-earths'][$eeee]['last_name'] = $found_eee_earth['last_name'];
                                                $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['f-earths'][$eeee]['email'] = $found_eee_earth['email'];
                                                $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['f-earths'][$eeee]['phone'] = $found_eee_earth['phone'];
                                                $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['f-earths'][$eeee]['referrer'] = $found_eee_earth['referrer'];
                                                $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['f-earths'][$eeee]['lotus_id'] = $found_eee_earth['lotus_id'];
                                                $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['f-earths'][$eeee]['water_id'] = $found_eee_earth['water_id'];
                                                $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['f-earths'][$eeee]['gen'] = $found_eee_earth['gen'];
                                                $formatted_fireDate = date("m/d/Y", $found_eee_earth['fireDate']);
                                                $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['f-earths'][$eeee]['fireDate'] = $formatted_fireDate;
                                                $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['f-earths'][$eeee]['petal_count'] = getPetalCount($connection, $found_eee_earth['lotus_id']);
                                                $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['f-earths'][$eeee]['eco_count'] = getEcoCount($connection, $found_eee_earth['lotus_id']);
                                                
                                                //get user's earth's 5
                                                $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['f-earths'][$eeee]['f-airs'] = array();
                                                $query = "SELECT *";
                                                $query .= "FROM users ";
                                                $query .= "WHERE air_id = '{$found_eee_earth['lotus_id']}'";
                                                $resultSet6 = mysqli_query($connection, $query);
                                                confirm_query($resultSet6, $connection);

                                                if(mysqli_num_rows($resultSet6) > 0) {//users fire has airs
                                                    $eeeee = 0;
                                                    $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['f-earths'][$eeee]['f-airs'][$eeeee] = array();
                                                    while($found_eeee_earth = mysqli_fetch_array($resultSet6)){
                                                        $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['f-earths'][$eeee]['f-airs'][$eeeee]['first_name'] = $found_eeee_earth['first_name'];
                                                        $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['f-earths'][$eeee]['f-airs'][$eeeee]['last_name'] = $found_eeee_earth['last_name'];
                                                        $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['f-earths'][$eeee]['f-airs'][$eeeee]['email'] = $found_eeee_earth['email'];
                                                        $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['f-earths'][$eeee]['f-airs'][$eeeee]['phone'] = $found_eeee_earth['phone'];
                                                        $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['f-earths'][$eeee]['f-airs'][$eeeee]['referrer'] = $found_eeee_earth['referrer'];
                                                        $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['f-earths'][$eeee]['f-airs'][$eeeee]['lotus_id'] = $found_eeee_earth['lotus_id'];
                                                        $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['f-earths'][$eeee]['f-airs'][$eeeee]['water_id'] = $found_eeee_earth['water_id'];
                                                        $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['f-earths'][$eeee]['f-airs'][$eeeee]['gen'] = $found_eeee_earth['gen'];
                                                        $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['f-earths'][$eeee]['f-airs'][$eeeee]['water_id'] = $found_eeee_earth['water_id'];
                                                        $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['f-earths'][$eeee]['f-airs'][$eeeee]['petal_count'] = getPetalCount($connection, $found_eeee_earth['lotus_id']);
                                                        $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['f-earths'][$eeee]['f-airs'][$eeeee]['eco_count'] = getEcoCount($connection, $found_eeee_earth['lotus_id']);
                                                        
                                                        //get user's earth's 6
                                                        $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['f-earths'][$eeee]['f-airs'][$eeeeee]['f-fires'] = array();
                                                        $query = "SELECT *";
                                                        $query .= "FROM users ";
                                                        $query .= "WHERE air_id = '{$found_eeee_earth['lotus_id']}'";
                                                        $resultSet7 = mysqli_query($connection, $query);
                                                        confirm_query($resultSet7, $connection);

                                                        if(mysqli_num_rows($resultSet7) > 0) {//users fire has fires
                                                            $eeeeee = 0;
                                                            while($found_eeeee_earth = mysqli_fetch_array($resultSet7)){
                                                            $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['f-earths'][$eeee]['f-airs'][$eeeee]['f-fires'][$eeeeee] = array();
                                                                $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['f-earths'][$eeee]['f-airs'][$eeeee]['f-fires'][$eeeeee]['first_name'] = $found_eeeee_earth['first_name'];
                                                                $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['f-earths'][$eeee]['f-airs'][$eeeee]['f-fires'][$eeeeee]['last_name'] = $found_eeeee_earth['last_name'];
                                                                $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['f-earths'][$eeee]['f-airs'][$eeeee]['f-fires'][$eeeeee]['email'] = $found_eeeee_earth['email'];
                                                                $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['f-earths'][$eeee]['f-airs'][$eeeee]['f-fires'][$eeeeee]['phone'] = $found_eeeee_earth['phone'];
                                                                $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['f-earths'][$eeee]['f-airs'][$eeeee]['f-fires'][$eeeeee]['referrer'] = $found_eeeee_earth['referrer'];
                                                                $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['f-earths'][$eeee]['f-airs'][$eeeee]['f-fires'][$eeeeee]['lotus_id'] = $found_eeeee_earth['lotus_id'];
                                                                $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['f-earths'][$eeee]['f-airs'][$eeeee]['f-fires'][$eeeeee]['water_id'] = $found_eeeee_earth['water_id'];
                                                                $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['f-earths'][$eeee]['f-airs'][$eeeee]['f-fires'][$eeeeee]['gen'] = $found_eeeee_earth['gen'];
                                                                $formatted_fireDate = date("m/d/Y", $found_eeeee_earth['fireDate']);
                                                                $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['f-earths'][$eeee]['f-airs'][$eeeee]['f-fires'][$eeeeee]['fireDate'] = $formatted_fireDate;
                                                                $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['f-earths'][$eeee]['f-airs'][$eeeee]['f-fires'][$eeeeee]['petal_count'] = getPetalCount($connection, $found_eeeee_earth['lotus_id']);
                                                                $_SESSION['flowers'][$i]['earths'][$e]['airs'][$ee]['fires'][$eee]['f-earths'][$eeee]['f-airs'][$eeeee]['f-fires'][$eeeeee]['eco_count'] = getEcoCount($connection, $found_eeeee_earth['lotus_id']);
                                                                $eeeeee++;
                                                            }//loop through F-Fires
                                                        } 
                                                        $eeeee++;
                                                    }//loop through F-Airs
                                                } 
                                                $eeee++;
                                            }//loop through F-Fires
                                        } 
                                        $eee++;
                                    }//loop through fires
                                } 
                                $ee++;
                            }//loop through airs
                        }
                        $e++;
                    }//loop through earths
                }
                $i++;
            }//loop through flowers
            
            if($_SESSION['flower'] == 0) {
                $query = "SELECT *";
                $query .= "FROM milestones ";
                $query .= "WHERE tlf_id = '{$tlf_id}'";
                $resultSet = mysqli_query($connection, $query);
                confirm_query($resultSet, $connection);
                while($milestone = mysqli_fetch_array($resultSet)) {
                    $percentage = $milestone['percentage'];
                    if($percentage == 0){
                        $_SESSION['next_milestone'] = 'm_one';
                        } elseif ($percentage == 20) {
                            $_SESSION['next_milestone'] = 'm_two';
                        } elseif ($percentage == 40) {
                            $_SESSION['next_milestone'] = 'm_three';
                        } elseif ($percentage == 60) {
                            $_SESSION['next_milestone'] = 'm_four';
                        } elseif ($percentage == 80) {
                            $_SESSION['next_milestone'] = 'm_five';
                        } else {
                            $_SESSION['next_milestone'] = 'complete';
                        }
                    }
                    
                $_SESSION['percentage'] = $percentage;
            }
            $query = "SELECT * ";
            $query .= "FROM gift_methods ";
            $query .= "WHERE tlf_id = '{$tlf_id}'";
            $resultSet = mysqli_query($connection, $query);
            confirm_query($resultSet, $connection);
            
            if(mysqli_num_rows($resultSet) > 0) {
                $i = 0;
                $_SESSION['methods'] = array();
                while($method = mysqli_fetch_array($resultSet)) {
                    $_SESSION['methods'][$i] = array();
                    $_SESSION['methods'][$i]['gift_method'] = $method['gift_method'];
                    $_SESSION['methods'][$i]['method_username'] = $method['method_username'];
                    $i++;
                }
            } 
            
            $msg = array();
            $msg[0] = "Success";
            $msg[1] = $terms; 
            echo json_encode($msg);
        } else {//if username/password do not match
            $msg = array();
            $msg[0] = "Error";
            $msg[1] = "Username & Password combo do not match.";
            echo json_encode($msg);
        }
    } else {//if not empty errors
        $msg = array();
            $msg[0] = "Error";
            $msg[1] = "There are errors " . print_r($errors);
            echo json_encode($msg);
    }
?>
