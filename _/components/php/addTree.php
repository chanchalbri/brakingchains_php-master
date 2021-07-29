<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
// addTree.php - called by the orgView.php form
// to place a tree from a tree
//
// (c) 2020, TLF
// Written by James Misa 

$tree_id = trim($_REQUEST['tree_id']);
$host_lotus_id = trim($_REQUEST['parent_id']);
$pre_date = trim($_REQUEST['fireDateTree']);
$fireDate = strtotime($pre_date);

if($host_lotus_id == "007") {
    $air_id = "none";
    $earth_id = "none";
    $water_id = "007";
    $gift_amt = "100";
    $board_brand = "gate";
    $gen = "1";
    $flower = "1";
} else if($host_lotus_id == "777") {
    $air_id = "none";
    $earth_id = "none";
    $water_id = "777";
    $gift_amt = "500";
    $board_brand = "garden";
    $gen = "1";
    $flower = "1";
    $ext = "_500";
    $water = "N/A";
    $water_phone = "N/A";
    $water_email = "N/A";
    $water_method = "N/A";
} else {
    $query = "SELECT * ";
    $query .= "FROM users ";
    $query .= "WHERE id = '{$host_lotus_id}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    $found_host = mysqli_fetch_array($resultSet);
    $air_id = $found_host['lotus_id'];
    $earth_id = $found_host['air_id'];
    $water_id = $found_host['earth_id'];
    $gift_amt = $found_host['gift_amt'];
    $board_brand = $found_host['board_brand'];
    $gen = $found_host['gen'] + 1;
    $flower = intval(1);
}
    

    $query2 = "SELECT * ";
    $query2 .= "FROM users ";
    $query2 .= "WHERE tlf_id = '{$tree_id}' LIMIT 1";
    $resultSet2 = mysqli_query($connection, $query2);
    confirm_query($resultSet2, $connection);
    
    $found_tree = mysqli_fetch_array($resultSet2);
    $first_name = $found_tree['first_name'];
    $last_name = $found_tree['last_name'];
    $display_name = $first_name . " " . $last_name;
    $email = $found_tree['email'];
    $hashed_password = $found_tree['hashed_password'];
    $promoCode = $found_tree['promoCode'];
    $referrer_name = $found_tree['referrer_name'];
    $referrer = $found_tree['referrer'];
    $stripe_id = $found_tree['stripe_id'];
    $wordpress_user_id = $found_tree['wordpress_user_id'];

    $lotus_id = createLotusId($connection, $tree_id, $board_brand);

    
    $water = getUserName($connection, $water_id);
    $water_phone = getUserPhone($connection, $water_id);
    $water_email = getUserEmail($connection, $water_id);
    $water_method = getWaterMethod($connection, $water_id);
    
    $current_time = date('Y-m-d H:i:s');
    //Create new flower	
    $query3 = "INSERT INTO users (
            creation_date_time,
            first_name, 
            last_name, 		
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
            referrer_ten8,
            flower,
            promoCode,
            view,
            gift_amt,
            board_brand,
            display_name,
            stripe_id,
            wordpress_user_id
            ) VALUES (
            '{$current_time}', 
            '{$first_name}', 
            '{$last_name}', 
            '{$email}', 
            '{$hashed_password}',
            '{$phone}',
            '{$fireDate}',
            '{$fireDate}',
            '{$tree_id}',
            '{$lotus_id}',
            '{$air_id}',
            '{$earth_id}',
            '{$water_id}',
            '{$gen}',
            '{$referrer_name}',
            '{$referrer}',
            '{$referrer}',
            1,
            '{$promoCode}',
            0,
            '{$gift_amt}',
            '{$board_brand}',
            '{$display_name}',
            '{$stripe_id}',
            '{$wordpress_user_id}'
        )";

    $resultSet3 = mysqli_query($connection, $query3);
    confirm_query($resultSet3, $connection);

    if(mysqli_affected_rows($connection) == 1) {
        //messageNewFire($connection, $phone, $first_name, $water_id, $fireDate);
        //messageWater($connection, $phone, $name, $water_id, $fireDate);
        if($host_lotus_id == "007") {
            
        } else {
           welcomeEmailGarden($email, $water, $water_phone, $water_email, $water_method, $pre_date);  
        }
        echo "Tree created!";
    } else {
        echo "Cannot add tree " . $tlf_id;
    }

?>