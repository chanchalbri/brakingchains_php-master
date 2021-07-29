<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php

$num = 1;
$date = strtotime("5 April 2020");
$c_tlf_id = "130503042320_2";
$c_air_id = "123456";
$c_earth_id = "234567";
$c_water_id = "345678";

for($i=0; $i<$num; $i++) {
    $first_name = "James" . $i;
    $last_name = "Misa" . $i;
    $email = "james.misa." . $i . "@gmail.com";
    $password = "manase";
    $hashed_password = hash('sha256', $password);
    $phone = "510760250" . $i;
    $fireDate = $date;
    $tlf_id = createTLFid();
    $lotus_id = $tlf_id . "_" . $i;
    $gen = "16";
    $referrer = "James";
    $air_id = $c_tlf_id;
    $earth_id = $c_air_id;
    $water_id = $c_earth_id;
    
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
                        lotus_id,
                        tlf_id,
                        air_id, 
                        earth_id,
                        water_id, 
                        gen,
                        referrer
                        ) VALUES (
                        '{$current_time}', 
                        '{$first_name}', 
                        '{$last_name}', 
                        '{$email}', 
                        '{$hashed_password}',
                        '{$phone}',
                        '{$fireDate}',
                        '{$lotus_id}',
                        '{$tlf_id}',
                        '{$air_id}', 
                        '{$earth_id}',  
                        '{$water_id}', 
                        '{$gen}',
                        '{$referrer}'
                    )";
            
            $result = mysqli_query($connection, $query);
            confirm_query($result, $connection);
    $_SESSION['anything'] = "yes & " . $i;
    
    $num_2 = 4;
    for($e=2; $e<$num_2; $e++) {
        $first_name = "James" . $e;
        $last_name = "Misa" . $e;
        $email = "james.misa." . $e . "@gmail.com";
        $password = "manase";
        $hashed_password = hash('sha256', $password);
        $phone = "510760250" . $e;
        $fireDate = $date + 7;
        $tlf_id = createTLFid();
        $gen = $gen + 1;
        $referrer = "James";
        $air_id = $lotus_id;
        $earth_id = $c_tlf_id;
        $water_id = $c_air_id;
        $lotus_id = $tlf_id . "_1" . $e;

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
                            lotus_id,
                            tlf_id,
                            air_id, 
                            earth_id,
                            water_id, 
                            gen,
                            referrer
                            ) VALUES (
                            '{$current_time}', 
                            '{$first_name}', 
                            '{$last_name}', 
                            '{$email}', 
                            '{$hashed_password}',
                            '{$phone}',
                            '{$fireDate}',
                            '{$lotus_id}',
                            '{$tlf_id}',
                            '{$air_id}', 
                            '{$earth_id}',  
                            '{$water_id}', 
                            '{$gen}',
                            '{$referrer}'
                        )";

                $result = mysqli_query($connection, $query);
                confirm_query($result, $connection);
        $_SESSION['everything'] = "yes & " . $e;
    }
}


?>