<?php require_once("_/components/php/includes/session.php"); ?>
<?php require_once("_/components/php/includes/connection.php"); ?>
<?php require_once("_/components/php/includes/functions.php"); ?>
<?php require_once("_/components/php/stripe/init.php"); ?>
<?php 
// verifyUser.php - called by the link sent to new user via email
// to verify the email of the new user with the code sent in the link
//
// (c) 2018, 5Onit
// Written by James Misa 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>vizaone -- Home</title>
    <link href="https://fonts.googleapis.com/css?family=Bubblegum+Sans|Calligraffitti|Crafty+Girls|Homemade+Apple|Kaushan+Script|Marck+Script|Playball|Yellowtail" rel="stylesheet">
    <link href="_/css/bootstrap.css" rel="stylesheet">
    <link href="_/css/mystyles.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
  </head>
<?php
date_default_timezone_set('America/Los_Angeles');

\Stripe\Stripe::setApiKey("sk_test_7PVq0iU8tYVWhQ3Ca1DwON0n");

// perform validations on the form data
$required_fields = array('id', 'verCode');

include "_/components/php/header.php"; 
if(validate_form($required_fields)) {//link has missing or invalid id or verification code
        echo "We're sorry...this link is no longer valid.";//add resend link option
    } else {
        $onitId = trim($_REQUEST['id']);
        $verCodeRcvd = trim($_REQUEST['verCode']);

        $query = "SELECT * FROM users WHERE onitId = '{$onitId}' LIMIT 1";
            $resultSet = run_query($query, $connection);
    
        if(mysqli_num_rows($resultSet) == 1) {//we found our user
            while ($foundUser = mysqli_fetch_array($resultSet)) {
                $parentCode = $foundUser['parentCode'];
                $gParentCode = $foundUser['gParentCode'];
                $verCode = $foundUser['verCode'];
                $verified = $foundUser['verified'];
                $userId = $foundUser['id'];
                $email = $foundUser['email'];
                $firstName = $foundUser['firstName'];	
                $lastName = $foundUser['lastName'];		
                $imgUrl = $foundUser['imgUrl'];	
                $fbID = $foundUser['fbID'];	
                $fbToken = $foundUser['fbToken'];	
                $onitId = $foundUser['onitId'];
                $class= $foundUser['class'];
                $admin = $foundUser['admin'];
                $creationDateTime = $foundUser['creationDateTime'];
                $name = $firstName . " " . $lastName;
                }

                if($verified == 1) {//already verified
                    echo "<p>Your account has already been verified. Go to login page to enter your credentials.</p>";
                } elseif ($verCode == $verCodeRcvd) {//verification code is correct
                    $query2 = "UPDATE users SET verified = 1 WHERE onitId = '{$onitId}'";
                    $resultSet2 = run_query($query2, $connection);
                    
                    $memberSince = date('M Y', strtotime($creationDateTime));

                    $_SESSION['memberSince'] = $memberSince;
                    $_SESSION['userId'] = $userId;
                    $_SESSION['email'] = $email;
                    $_SESSION['firstName'] = $firstName;	
                    $_SESSION['lastName'] = $lastName;	
                    $_SESSION['imgUrl'] = $imgUrl;
                    $_SESSION['fbID'] = $fbID;
                    $_SESSION['fbToken'] = $fbToken;	
                    $_SESSION['onitId'] = $onitId;
                    $_SESSION['class'] = $class;
                    $_SESSION['admin'] = $admin;
                    $_SESSION['name'] = $name;
                    $_SESSION['parentCode'] = $parentCode;
                    $_SESSION['gParentCode'] = $gParentCode;
                    
                    echo '<body id="class">
                            <section class="container">
                            
                                <div class="content row">
                                    <?php include "_/components/php/header.php"; ?>
                                    <section class="main col col-lg-12">
                                    </section><!--main-->
                                </div><!--content-->

                                <section class="container1">
                                    <div class="content row text-center">
                                    
                                        <section class="col col-xs-12">
                                            <h1 class="visible-lg-block">You\'re Almost There!</h1>
                                            <h2 class="visible-md-block">You\'re Almost There!</h2>
                                            <h3 class="visible-sm-block">You\'re Almost There!</h3>
                                            <h4 class="visible-xs-block">You\'re Almost There!</h4>
                                            
                                            <p class="text-muted">
                                                Let\'s get your subscription payments set up by paying your first month\'s subscription fee of $5.
                                            </p>
                                            <div class="col col-xs-8 col-xs-offset-2 text-center">
                                                <div class="panel panel-primary">
                                                    <div class="panel-heading">5ONIT SUBSCRIPTION - $5/MONTH</div>
                                                    <div class="panel-body">
                                                        <p class="text-muted">
                                                            What\'s more than a monthly 5Onit subscription?
                                                        </p>
                                                        <p class="text-muted">
                                                            -One visit to Starbucks
                                                        </p>
                                                        <p class="text-muted">
                                                            -a McDonald\'s Happy Meal
                                                        </p>
                                                        <p class="text-muted">
                                                            -2 gallons of gas
                                                        </p>
                                        </div>
                                        </div>
                                            </div>
                                        </section>
                                    </div>
                                </section>
                            </section>
                            <div id="myForm">
                                <form action="/charge" method="post" id="payment-form">
                                            <div class="form-row">
                                                <label for="card-element">
                                                  Credit or debit card
                                                </label>
                                                <div id="card-element">
                                                  <!-- A Stripe Element will be inserted here. -->
                                                </div>

                                                <!-- Used to display form errors. -->
                                                <div id="card-errors" role="alert"></div>
                                            </div>
                                                <input type="text" id="name" name="name" placeholder="Full Name" value="' . $name . '"/>
                                                <input type="text" id="address" name="address" placeholder="Address"/>
                                                <input type="text" id="city" name="city" placeholder="City"/>
                                                <input type="text" id="zip" name="zip" placeholder="Postal Code"/>
                                                <input type="text" id="country" name="country" placeholder="Country"/>
                                                <input type="email" id="email" name="email" placeholder="Email" value="' . $email . '"/>
                                                <input type="hidden" id="firstName" name="firstName" placeholder="firstName" value="' . $firstName . '"/>
                                            <button id="paymentSub">Submit Payment</button>
                                        </form>
                                    </div>
                          </body>';

                } else {//verification code is incorrect
                    echo "<p>This is a bad link.</p>";
                }
        } else {
            echo "<p>This is a bad link.</p>";
        }
}
?>
<script src="_/js/myscript.js"></script>
<script src="https://js.stripe.com/v3/"></script>
<script>
// Create a Stripe client.
var stripe = Stripe("pk_test_5pJfWjrXddKnocO6lrvzG1Gf");

// Create an instance of Elements.
var elements = stripe.elements();

// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
  base: {
    color: '#32325d',
    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
    fontSmoothing: 'antialiased',
    fontSize: '16px',
    '::placeholder': {
      color: '#aab7c4'
    }
  },
  invalid: {
    color: '#fa755a',
    iconColor: '#fa755a'
  }
};

// Create an instance of the card Element.
var card = elements.create('card', {style: style});

// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');

// Handle real-time validation errors from the card Element.
card.addEventListener('change', function(event) {
  var displayError = document.getElementById('card-errors');
  if (event.error) {
    displayError.textContent = event.error.message;
  } else {
    displayError.textContent = '';
  }
});

// Create a source or display an error when the form is submitted.
var form = document.getElementById('payment-form');

form.addEventListener('submit', function(event) {
  event.preventDefault();
    var name = document.getElementById('name').value;
    var address = document.getElementById('address').value;
    var zip = document.getElementById('zip').value;
    var city = document.getElementById('city').value;
    var email = document.getElementById('email').value;
    var firstName = document.getElementById('firstName').value;
    var ownerInfo = {
      owner: {
        name: name,
        address: {
          line1: address,
          city: city,
          postal_code: zip,
          country: 'US'
        },
        email: email
      },
    };

  stripe.createSource(card, ownerInfo).then(function(result) {
    if (result.error) {
      // Inform the user if there was an error
      var errorElement = document.getElementById('card-errors');
      errorElement.textContent = result.error.message;
    } else {
      // Send the source to your server
      stripeSourceHandler(result.source, email, firstName);
    }
  });
});

function stripeSourceHandler(source, email, firstName) {
    var dataString = 'source=' + source.id + '&email=' + email;
        jQuery.ajax({
         type: "POST",
         url: "_/components/php/newCustomer.php",
         data: dataString,
         success: function(msg){
             alert(msg); 
             window.location = "/index.php?msg=" + firstName;
         },
         error: function(){
         alert("failure");
         }
        });
}

</script>

