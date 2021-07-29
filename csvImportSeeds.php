<?php require_once("_/components/php/includes/session.php"); ?>
<?php require_once("_/components/php/includes/connection.php"); ?>
<?php require_once("_/components/php/includes/functions.php"); ?>
<?php 
// myflowers.php - called by the TLF website - header.php
// to display user info and log out button
//
// (c) 2020, TLF
// Written by James Misa
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TLF -- ImportSeeds</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="_/css/bootstrap.css" rel="stylesheet">
    <link href="_/css/mystyles.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body id="user">
      <section class="container">
          <div class="content row">
              <?php include "_/components/php/header.php"; ?>
          </div><!--content-->
<?php 
 $csv = "eden_migration2https://breakingchainsprivatecoop.com/joinnow.php?id=19011.csv";
 $promoCode = "";

          $file = fopen($csv,"r");
            while(! feof($file))
              {
              $import = (fgetcsv($file));
                $first_name = addslashes($import[0]);
                $last_name = addslashes($import[1]);
                $display_name = $first_name . " " . $last_name;
                $email = $import[2];
                $phone = $import[3];
                $inviter_email = $import[4];
                
                if($inviter_email == "") {
                    $inviter_email = "marylboyde@gmail.com";
                }
                $inviter_tlf = getInviter_tlf($connection, $inviter_email);
                
                if($email == ""){$email = $first_name . "@me.com";}
                if($phone == ""){$phone = "555-555-5555";}
                
                $password = $last_four . "password";
                $hashed_password = hash('sha256', $password);
                $tlf_id = getTLFID($connection, $first_name, $last_name);
                
                $query = "SELECT *";
                $query .= "FROM users ";
                $query .= "WHERE email = '{$email}' ";
                $query .= "LIMIT 1";
                $resultSet = mysqli_query($connection, $query);
                confirm_query($resultSet, $connection);
                
                if(mysqli_num_rows($resultSet) == 0) {
                    $current_time = date('Y-m-d H:i:s');
                $fireDate = $current_time;
                    //Create new user	
                    $query2 = "INSERT INTO users (
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
                            flower,
                            display_name,
                            referrer_name,
                            referrer,
                            view
                            ) VALUES (
                            '{$current_time}', 
                            '{$first_name}', 
                            '{$last_name}', 
                            '{$email}', 
                            '{$hashed_password}',
                            '{$phone}',
                            '{$fireDate}',
                            '{$fireDate}',
                            '{$tlf_id}',
                            NULL,
                            NULL,
                            NULL,
                            NULL,
                            0,
                            '{$display_name}',
                            '{$inviter_email}',
                            '{$inviter_tlf}',
                            0
                        )";

                $resultSet2 = mysqli_query($connection, $query2);
                confirm_query($resultSet2, $connection);
                } 
              }
            fclose($file);  
          
          echo "Import complete.";
    
?>
