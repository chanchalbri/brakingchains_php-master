<?php require_once("_/components/php/includes/session.php"); ?>
<?php require_once("_/components/php/includes/connection.php"); ?>
<?php require_once("_/components/php/includes/functions.php"); ?>
<?php 
// user.php - called by the TLF website - header.php
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
    <title>TLF -- User</title>
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
          
          <div id="passwordSetup">
          <h2>This is only for flowers who have not setup a password yet.</h2>
         
            <button type="button" class="login btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#setup">Find Account</button>

            <!-- Modal -->
            <div class="modal fade" id="setup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Enter Email Address</h4>
                        </div><!--modal-header-->

                       <!-- Modal Body -->
                        <div class="modal-body">
                            <form class="form-horizontal" data-toggle="validator" id="loginForm" role="form">

                            <div class="form-group">
                                <label  class="sr-only" for="email">Email</label>
                                <div class="col-sm-12" inputGroupContainer>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                        <input type="email" class="form-control" 
                                        id="email" name="email" placeholder="Email"/>
                                    </div><!--input-group-->
                                </div><!--inputGroupContainer-->
                            </div><!--form-group-->

                            </form><!--form-horizontal--> 
                        </div><!--modal-body-->

                        <!-- Modal Footer -->
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" id="setupSubmit" name="submit" class="btn btn-primary">Search</button>
                        </div><!--modal-footer-->
                    </div><!--modal-content-->
                </div><!--modal-dialog-->
          </div>  
        

<?php include "_/components/php/footer.php"; ?>
     
