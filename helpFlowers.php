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
              
            <h2><i class="fa fa-exclamation-triangle"></i> S.O.S FLOWERS</h2>

          
          <div class="container">
              <?php include "_/components/php/distressed_flowers.php"; ?>
            </div>
          
              <?php 
                $tlf_id = $_SESSION['tlf_id'];
                $query = sprintf("SELECT * FROM users WHERE referrer='%s' && flower=0 ORDER BY fireDate ASC", 
                        mysqli_real_escape_string($connection, $tlf_id));
                        $result = mysqli_query($connection, $query);
                        confirm_query($result, $connection);

                $options = '<option>Yourself</option>';
                if(mysqli_num_rows($result) > 0) {
                    $_SESSION['seeds'] = array();
                    $i = 0;
                    while($found_seed = mysqli_fetch_array($result)) {
                        $name = $found_seed['first_name'] . " " . $found_seed['last_name'];
                        $seed_tlf_id = $found_seed['tlf_id'];
                        $options = $options . '<option>' . $name . '</option>';
                        $_SESSION['seeds'][$i] = array();
                        $_SESSION['seeds'][$i]['name'] = $name;
                        $_SESSION['seeds'][$i]['tlf_id'] = $seed_tlf_id;
                        $i++;
                    }
                }

              ?>
            <!-- Modal -->
            <div class="modal fade" id="addFlower" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Add Flower</h4>
                        </div><!--modal-header-->

                       <!-- Modal Body -->
                        <div class="modal-body">
                            <form class="form-horizontal" data-toggle="validator" id="addFlowerForm" role="form">

                            <div class="form-group">
                                <label for="addSeed">Select Seed to Add</label>
                                <select class="form-control" id="addSeed">'
                                   <?php echo $options ?> 
                                '</select>
                              </div>

                              <div class="form-group">
                                <label  class="sr-only" for="fireDate">Enter Fire Date</label>
                                <div class="col-sm-12" inputGroupContainer>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                        <input type="date" class="form-control" 
                                        id="fireDate" name="fireDate"  placeholder="Fire Date"/>
                                    </div><!--input-group-->
                                    <p class="desc">Enter Fire Date - MUST be a Sunday</p>
                                </div><!--inputGroupContainer-->
                            </div><!--form-group-->

                              <div class="form-group">
                                <div class="col-sm-12" inputGroupContainer>
                                    <div class="input-group">
                                        <input type="hidden" class="form-control" 
                                        id="lotus_id" name="lotus_id" value="<?php echo $_SESSION['focus_flower_id'];  ?>" placeholder="Lotus ID" readonly/>
                                    </div><!--input-group-->
                                </div><!--inputGroupContainer-->
                            </div><!--form-group-->

                            </form><!--form-horizontal--> 
                        </div><!--modal-body-->

                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" id="addSeedSubmit" name="submit" class="btn btn-primary">Create Flower</button>
                        </div><!--modal-footer-->
                    </div><!--modal-content-->
                </div><!--modal-dialog-->
            </div><!--modal login-->
          
          <?php include "_/components/php/footer.php"; ?>
      </section><!--container-->
      
  </body>
</html>
