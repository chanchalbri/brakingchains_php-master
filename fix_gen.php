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
    <title>TLF -- MyFlowers</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Krub:ital,wght@1,600&display=swap" rel="stylesheet">
    <link href="_/css/bootstrap.css" rel="stylesheet">
    <link href="_/css/mystyles.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://kit.fontawesome.com/7b30bafaf6.js" crossorigin="anonymous"></script>
  </head>
  <body id="user">
      <section class="container">
          <?php include "_/components/php/header.php"; ?>
          
          <?php 
        
            $id = '101';
            $gen = '102';
            
            for($i=0; $i<5; $i++) {
                $query = "SELECT *";
                $query .= "FROM users ";
                $query .= "WHERE gen = '{$id}'";
                $resultSet = mysqli_query($connection, $query);
                confirm_query($resultSet, $connection);

                while($found_user = mysqli_fetch_array($resultSet)) {
                    $lotus_id = $found_user['lotus_id'];

                    $query = "UPDATE users SET gen = '{$gen}' WHERE air_id='{$lotus_id}'";
                    $result = mysqli_query($connection, $query);
                }
                $id++;
                $gen++;
            }

          
            $gen = '102';
            $fire_date = '1581840000' + 7*24*60*60;
          
          for($i=0; $i<5; $i++) {
            $query = "UPDATE users SET fireDate = '{$fire_date}' WHERE gen='{$gen}'";
            $result = mysqli_query($connection, $query);
              
              $gen++;
              $fire_date = $fire_date + 7*24*60*60;
          }
            
          
            
            
          
          
          ?>
          
          <?php include "_/components/php/footer.php"; ?>
      </section><!--container-->
      
  </body>
</html>