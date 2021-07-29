<?php require_once("_/components/php/includes/session.php"); ?>
<?php require_once("_/components/php/includes/connection.php"); ?>
<?php require_once("_/components/php/includes/functions.php"); ?>
<?php 
// support.php - from nav bar
// in order to show contact info for flowers and roots
//
// (c) 2020, TLF
// Written by James Misa

?>
<!DOCTYPE html>
<html lang="en">
  <head>
   
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>TLF --Seeds</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Krub:ital,wght@1,600&display=swap" rel="stylesheet">
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
  <?php include "_/components/php/header.php"; 

$first_name = $_SESSION['first_name'];
$fire_date = $_SESSION['fire_date'];
$water_date = $_SESSION['water_date'];



echo '<div class="receiptWrapper">' .
        '<p>Hello ' . $first_name . ',</p>' .  
       '<p>Congratulations, you have successfully registered and have been given full login access.</p>' . 
       '<p>You have joined a community of like-minded individuals that support, empower and motivate one another to go after their goals, dreams and aspirations.</p>' .
       '<p>We would like to thank you for seeing the vision of The Lotus Family which is based on the principles of Ujamaa Cooperative Economics.</p>' .
       '<p>As a part of our Community, you now have immediate access to the following:</p>' .
       '<ol style="margin-left:20px">' . 
        '<li>Full access to the Lotus software</li>' .
        '<li>Administrative and Technical support</li>' .
        '<li>Weekly Co-Op training calls</li>' .
        '<li>Access to our Co-Op Business Directory</li>' .
        '<li>And much more...</li>' .
       '</ol>' . 
       '<h5 style="color: blue;">Your Fire (SOW) Date is ' . $fire_date . '</h5>' .
       '<h5 style="color: blue;">Your Water (Harvest) date is ' . $water_date . '</h5>' .
       '<h5>Here are some tasks you MUST accomplish in preparation for your Sow Day.</h5>' .
       '<ol style="margin-left:20px">' . 
        '<li>Attend ALL training calls</li>' .
            '<ul style="margin-left:20px">' .
            '<li>New Member Orientation (Overview) - Sunday (6 pm PT/ 9 pm ET)</li>' .
            '<li>Basic Training (The Invitation) - Monday (6:40 pm PT/ 9:40 pm ET)</li>' .
            '<li>Advanced Training (The Strategy) - Wednesday (6:40 pm PT/ 9:40 pm ET)</li>' .
            '</ul>' .
        '<li>Utilize the TLF Invitation Systems (Live and Video)</li>' .
        '<li>Follow the Daily Success Schedule</li>' .
        '<li>Reach out to your Roots (See “Family” screen in back office)</li>' .
       '</ol>' .
       '<p>We look forward to experiencing amazing success together as we continue to grow as a family.</p>' .
       '<p>To your success!</p>' .
       '<p>TLF Task Force</p></body></html></div>';
    ?>
    
    <?php include "_/components/php/footer.php"; ?>
      </section><!--container-->
     
  </body>
</html>