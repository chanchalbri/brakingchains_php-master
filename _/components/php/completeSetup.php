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
        $first_name = $users['first_name'];
        $tlf_id = $users['tlf_id'];
        $hashed_password = $users['hashed_password'];
        $temp_password = "manase";
        $hashed_temp_password = '7cfc9f8c79d1c1d618f77adc5cf8bb229b94c93d78394f4418ebdc56e2be712a';
        
            if($hashed_password == $hashed_temp_password) {
            $createPassword = 
                '<h2 class="welcome_msg">Welcome ' . $first_name . ', let\'s create a new password.</h2>
                <form>
                  <div class="form-group">
                    <input type="hidden" class="form-control" id="temp_password" aria-describedby="temp_password" value="' . $temp_password . '">
                  </div>
                  <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Enter New Password">
                  </div>
                  <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" placeholder="Confirm Password">
                  </div>
                    <div class="form-group">
                    <input type="hidden" class="form-control" 
                    id="tlf_id" name="tlf_id" value="' . $tlf_id . '" placeholder="TLF ID" readonly/>
                    </div>
                  <button type="submit" id="passSubmit" class="btn btn-primary btn-block">Submit</button>
                </form>'; 
                
            } else {
                echo "A password has already been setup for this account";
            }
        }
        echo $createPassword;
    } else {
        echo "This email " . $email_address . " address does not exist";
    }
} 
?>