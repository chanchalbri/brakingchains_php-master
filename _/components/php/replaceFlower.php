<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
// addSeedAdminSubmit.php - called by the myFlowers.php form
// to convert a seed to a flower as an Admin
//
// (c) 2020, TLF
// Written by James Misa 

$replacedFlower = trim($_REQUEST['replacedFlower']);
$addedFlower = trim($_REQUEST['addedFlower']);


    $num = count($_SESSION['flowersAdminReplace']);
    for($i=0; $i<$num; $i++) {
        if($replacedFlower == $_SESSION['flowersAdminReplace'][$i]['name']) {
            $flower_id = trim($_SESSION['flowersAdminReplace'][$i]['id']);
            $lotus_id_old = trim($_SESSION['flowersAdminReplace'][$i]['lotus_id']);
            $board_brand = trim($_SESSION['flowersAdminReplace'][$i]['board_brand']);
        } 
    }
    $num2 = count($_SESSION['flowersAdmin']);
    for($i=0; $i<$num2; $i++) {
        if($addedFlower == $_SESSION['flowersAdmin'][$i]['name']) {
            $tlf_id = trim($_SESSION['flowersAdmin'][$i]['tlf_id']);
        }
    }
    $query2 = "SELECT * ";
    $query2 .= "FROM users ";
    $query2 .= "WHERE tlf_id = '{$tlf_id}'";
    $resultSet2 = mysqli_query($connection, $query2);
    confirm_query($resultSet2, $connection);

    if(mysqli_num_rows($resultSet2) > 0) {
            while($found_flower = mysqli_fetch_array($resultSet2)) {
            $first_name = $found_flower['first_name'];
            $last_name = $found_flower['last_name'];
            $email = $found_flower['email'];
            $hashed_password = $found_flower['hashed_password'];
            $phone = $found_flower['phone'];
            $referrer_name = $found_flower['referrer_name'];
            $referrer = $found_flower['referrer'];
            $promoCode = $found_flower['promoCode'];
            $lotus_id = createLotusId($connection, $tlf_id, $board_brand);
        }

        $query3 = "UPDATE users 
                  SET first_name = '{$first_name}',
                      last_name = '{$last_name}',
                      email = '{$email}',
                      hashed_password = '{$hashed_password}',
                      phone = '{$phone}',
                      tlf_id = '{$tlf_id}',
                      lotus_id = '{$lotus_id}',
                      referrer_name = '{$referrer_name}',
                      referrer = '{$referrer}',
                      promoCode = '{$promoCode}'
                  WHERE id='{$flower_id}'";
        $resultSet3 = mysqli_query($connection, $query3);
        confirm_query($resultSet3, $connection);
        
            $query4 = "UPDATE users 
                      SET air_id = '{$lotus_id}'
                      WHERE air_id='{$lotus_id_old}'";
            $resultSet4 = mysqli_query($connection, $query4);
            confirm_query($resultSet4, $connection);

            $query5 = "UPDATE users 
                      SET earth_id = '{$lotus_id}'
                      WHERE earth_id='{$lotus_id_old}'";
            $resultSet5 = mysqli_query($connection, $query5);
            confirm_query($resultSet5, $connection);

            $query6 = "UPDATE users 
                      SET water_id = '{$lotus_id}'
                      WHERE water_id='{$lotus_id_old}'";
            $resultSet6 = mysqli_query($connection, $query6);
            confirm_query($resultSet6, $connection);

        echo "Tree Replaced!";
    } else {
        echo "User with tlf_id: " . $tlf_id . " not coming up";
    }
    
    

    

   


?>