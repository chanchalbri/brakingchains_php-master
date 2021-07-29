<?php require_once("_/components/php/includes/session.php"); ?>
<?php require_once("_/components/php/includes/connection.php"); ?>
<?php require_once("_/components/php/includes/functions.php"); ?>
<?php 
// index.php - landing page of the TLF website
// will show login button
//
// (c) 2020, TLF
// Written by James Misa

if(isset($_REQUEST['temp_password'])) {$temp_password = $_REQUEST['temp_password'];} 
if(isset($_REQUEST['tlf_id'])) {$tlf_id = $_REQUEST['tlf_id'];} 
if(isset($_REQUEST['name'])) {$name = $_REQUEST['name'];} 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>BEES</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Krub:ital,wght@1,600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rock+Salt&display=swap" rel="stylesheet">
    <link href="_/css/bootstrap.css" rel="stylesheet">
    <link href="_/css/mystyles.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
    <script src="https://kit.fontawesome.com/7b30bafaf6.js" crossorigin="anonymous"></script>
  </head>
  <body id="home">
      <section class="container" ng-app="">
          <div class="content row">
              <?php include "_/components/php/header.php"; ?>
              <h1 class="elements-title">BEES...Coming Soon.<span class="lotus"></span></h1>
              <?php if(isset($temp_password)){include "_/components/php/verify.php";} ?>
              <?php //if (!logged_in()) {
                    //include "_/components/php/landingPage3.php";
                    //} else {
                    //include "_/components/php/mainPage.php";
                    //} ?>
          </div><!--content-->
          <?php include "_/components/php/footer.php"; ?> 
      </section><!--container-->    
  </body>
</html>