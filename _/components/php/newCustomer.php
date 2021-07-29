<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("stripe/init.php"); ?>
<?php 
// newCustomer.php - called the red hat registration form
// to collect payment information and make first charge
//
// (c) 2020, TLF
// Written by James Misa 

date_default_timezone_set('America/Los_Angeles');
$errors = array();

    // perform validations on the form data
    $required_fields = array('source','email', 'tlf_id', 'priceCode');
    $errors = array_merge($errors, check_required_fields($required_fields, $_REQUEST));

    $email = trim($_REQUEST['email']);
    $source = trim($_REQUEST['source']);
    $tlf_id = $_REQUEST['tlf_id'];
    $priceCode = trim($_REQUEST['priceCode']);
if($errors) {
    echo "There was no email";
} else {
    
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE tlf_id = '{$tlf_id}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    while($found_user = mysqli_fetch_array($resultSet)) {
        $inviter = $found_user['referrer_name'];
        $fire_date_unix = $found_user['fireDate'];
        $water_date_unix = $fire_date_unix + 60*60*24*21;
        $fire_date = date("m/d/Y", $fire_date_unix);
        $water_date = date("m/d/Y", $water_date_unix);
        $first_name = $found_user['first_name'];
    }
    \Stripe\Stripe::setApiKey("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");

    $customer = \Stripe\Customer::create(array(
                  "email" => $email,
                  "description" => "Standard Service subscription for " . $name,
                  "source" => $source // obtained with Stripe.js
                ));
    $last4 = $customer['sources']['data'][0]['card']['last4'];
    $exp_month = $customer['sources']['data'][0]['card']['exp_month'];
    $exp_year = $customer['sources']['data'][0]['card']['exp_year'];
    $country = $customer['sources']['data'][0]['card']['country'];
    $brand = $customer['sources']['data'][0]['card']['brand'];
    $id = $customer['id'];
    
    $today = strtotime(date("m/d/Y"));
    $trial = $today + 60*60*24*30;

    $subscription = \Stripe\Subscription::create([
                      "customer" => $id,
                      "items" => [
                        [
                          "price" => $priceCode,
                        ],
                      ],
                      "trial_end" => $trial,
                    ]);

    $newCustomer = "INSERT INTO customers (
                            tlf_id,
                            custId, 
                            sourceId, 		
                            subId, 
                            brand,
                            last4,
                            exp_month,
                            exp_year,
                            country
                            ) VALUES (
                            '{$tlf_id}', 
                            '{$id}', 
                            '{$source}', 
                            '{$subscription["id"]}',
                            '{$brand}',
                            '{$last4}',
                            '{$exp_month}',
                            '{$exp_year}',
                            '{$country}'
                        )";
    $result = mysqli_query($connection, $newCustomer);
    confirm_query($result, $connection);
    
    $_SESSION['first_name'] = $first_name;
    $_SESSION['fire_date'] = $fire_date;
    $_SESSION['water_date'] = $water_date;
    
    //welcomeEmail ($email_address, $first_name, $fire_date, $water_date, $inviter);
    
    $msg = "Congrats! You're free to login.";
    echo $msg;
}
?>


