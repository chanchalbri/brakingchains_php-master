<?php require_once("_/components/php/includes/session.php"); ?>
<?php require_once("_/components/php/includes/connection.php"); ?>
<?php require_once("_/components/php/includes/functions.php"); ?>
<?php 
// index.php - landing page of the TLF website
// will show login button
//
// (c) 2020, TLF
// Written by James Misa

if(isset($_REQUEST['id'])) {$_SESSION['id'] = $_REQUEST['id'];} 
if(isset($_REQUEST['tlf_id'])) {$tlf_id = $_REQUEST['tlf_id'];} 
if(isset($_REQUEST['name'])) {$name = $_REQUEST['name'];} 

    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE id = '{$_SESSION['id']}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    while($found_user = mysqli_fetch_array($resultSet)) {
        $name = $found_user['first_name'] . " " . $found_user['last_name'];
        $tlf_id = $found_user['tlf_id'];
        $promoCode = $found_user['promoCode'];
        if($promoCode == 'REDHAT') {//no trial
            $price = 'price_1H6hsiGkFLnj68yK1kQM6fKY';
            $trial = '';
        } elseif($promoCode == 'TLOKJ720') {//30day 
            $price = 'price_1H8WXUGkFLnj68yKWCgroxex';
            $trial = '<h2 style="font-family:sans-serif; color:red;">*30 Day Free Trial*</h2>';
        } elseif($promoCode == 'TLOCMM720') {//30day 
            $price = 'price_1H8WXUGkFLnj68yKWCgroxex';
            $trial = '<h2 style="font-family:sans-serif; color:red;">*30 Day Free Trial*</h2>';
        } elseif($promoCode == 'TLODJ720') {//30day 
            $price = 'price_1H8WXUGkFLnj68yKWCgroxex';
            $trial = '<h2 style="font-family:sans-serif; color:red;">*30 Day Free Trial*</h2>';
        } else {//30day
            $price = 'price_1H8atlGkFLnj68yKS0Oasf4z';
            $trial = '<h2 style="font-family:sans-serif; color:red;">*30 Day Free Trial*</h2>';
        }
        $_SESSION['trial'] = $trial;
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>TLF</title>
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
              <h2 class="elements-title2">Welcome to the</h2>
              <h1 class="elements-title"><span class="lotus">Breaking Chains </span><br><span style="font-size:2vw;">Private Cooperative</span></h1>
              <div class="col-md-12">
                   <h3 class="how">You're in the right place</h3>
                  <hr>
                  <div class="description">
                   <p>Our mission is to provide a home for like-minded individuals to work together and practice the Universal Laws of sowing and reaping in a safe environment where everyone can reach their goals, dreams and aspirations.</p>
                   <hr>
                    <h3 class="how">Our community includes:</h3>
                      
                      <ul class="community">
                        <li>Complete virtual back office</li>
                        <li>One-touch gift verification system</li>
                        <li>Ongoing member communication</li>
                        <li>Highly successful leadership network</li>
                        <li>Amazing wealth creation opportunity</li>
                        <li>And so much more!</li>
                      </ul>
                    <hr>
                    <p>Simply follow your Inviter through each step of the process, and your Invitees will follow you, making this a real team effort.</p>

                    <p>And our automated system tracks your movement in real time every step of the way!</p>
                  </div>
              </div>
              <!--
             <button type="button" 
                class="btn btn-block btn-primary btn-large btn-block"  
                data-toggle="modal" 
                data-target="#newRegister">Register Now</button>-->
          </div><!--content-->
          <?php include "_/components/php/footer.php"; ?>
      </section><!--container-->

<?php 
    echo registerModal($promoCode, $price, $tlf_id, $name); 
    echo showTerms();
    echo showPrivacy();
    echo paymentForm($trial);
?>

    
  </body>
</html>

<script src="https://js.stripe.com/v3/"></script>
<script>
    
function disableSubmit() {
  document.getElementById("regSubmit").disabled = true;
 }

  function activateButton(element) {

      if(element.checked) {
        document.getElementById("regSubmit").disabled = false;
       }
       else  {
        document.getElementById("regSubmit").disabled = true;
      }

  }

</script>