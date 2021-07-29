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
$_SESSION['navbar'] = 1;
?>
               <style>
                 .roots {
                    height: 800px;
                    width: 100%;
                    background: url(../brakingchains/images/The_Eden_Project.jpg);
                    background-position: center center;
                    background-repeat: no-repeat;
                    background-size: 800px 100%;
                }
               </style>
              <?php include "_/components/php/new_header.php"; ?>
              <!--<h1 class="elements-title"><span class="lotus">Building Black Wall Street!</span><br><br><br>Not Across City Blocks <br><br>But Across Nations!</h1>-->
              <?php if(isset($temp_password)){include "_/components/php/verify.php";} ?>
              <div class="roots">
              <?php //if (!logged_in()) {
                    //include "_/components/php/landingPage3.php";
                    //} else {
                    //include "_/components/php/mainPage.php";
                    //} ?>
              </div>
          </div><!--content-->
          <?php include "_/components/php/new_footer.php"; ?> 
    