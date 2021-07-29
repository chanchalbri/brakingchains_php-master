<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>

<?php
// recordGifter.php - called by the harvests.php form
// to record a gift
//
// (c) 2020, TLF
// Written by James Misa 

$water_id = $_REQUEST['water_id'];
$fire_id = $_REQUEST['fire_id'];
$gifted_date = $_REQUEST['gifted_date'];
$gifter_key = md5($water_id);
$receiver_key = md5($fire_id);
$current_time = date('Y-m-d H:i:s');

$query="INSERT INTO harvests (
            creationDateTime,
            water_id, 
            fire_id, 		
            gift_date,
            gifter_key,
            receiver_key
            ) VALUES (
            '{$current_time}', 
            '{$water_id}', 
            '{$fire_id}', 
            '{$gifted_date}',
            '{$gifter_key}',
            '{$receiver_key}'
        )";

    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    $harvestID = mysqli_insert_id($connection);

    $query2 = "UPDATE users 
                  SET invGifted = 1
                  WHERE lotus_id='{$fire_id}'";
        $resultSet2 = mysqli_query($connection, $query2);
        confirm_query($resultSet2, $connection);

    // get phone number and name of gifter
    $gifter_phone = getPhone($connection, $fire_id);
    $gifter_name = getName($connection, $fire_id);
    $gifter_fname = getFirstName($connection, $fire_id);
/*
    // properly format the phone number
    $phone_number = preg_replace('/[^0-9]/','',$gifter_phone);
     if(strlen($phone_number) > 10) { //apply proper formatting to recipient's number - 11+ characters
            $countryCode = substr($phone_number, 0, strlen($phone_number)-10);
            $areaCode = substr($phone_number, -10, 3);
            $nextThree = substr($phone_number, -7, 3);
            $lastFour = substr($phone_number, -4, 4);

             $phone_number = '+1' . $areaCode . $nextThree . $lastFour;
        }
        else if(strlen($phone_number) == 10) { //apply proper formatting to recipient's number - 10 characters
            $areaCode = substr($phone_number, 0, 3);
            $nextThree = substr($phone_number, 3, 3);
            $lastFour = substr($phone_number, 6, 4);

            $phone_number = '+1' . $areaCode . $nextThree . $lastFour;
        }
        else if(strlen($phone_number) == 7) { //apply proper formatting to recipient's number - 7 characters
            $nextThree = substr($phone_number, 0, 3);
            $lastFour = substr($phone_number, 3, 4);

            $phone_number = $nextThree . '-' . $lastFour;
        }

    $gifter_phone = $phone_number;

     $config = new BandwidthLib\Configuration(
        array(
            'messagingBasicAuthUserName' => TLOB_USERNAME,
            'messagingBasicAuthPassword' => TLOB_PASSWORD
        )
    );

    $client = new BandwidthLib\BandwidthClient($config);

    $messagingClient = $client->getMessaging()->getClient();

    $from = "+12134592055";
    $to = array($gifter_phone);
    $link = "https://www.thelotus.online/gifter.php?id=" . $harvestID . "&key=" . $gifter_key . "&name=" . $gifter_name;
    $text = "Hello " . $gifter_fname . ", \n Your gift has been received and confirmed. \n Click the link below to sign your gift letter. \n" . $link . "\n The Lotus Online"; 

    $body = new BandwidthLib\Messaging\Models\MessageRequest();
    $body->applicationId = TLOB_APPID;
    $body->to = $to;
    $body->from = $from;
    $body->text = $text;

    try {
        $response = $messagingClient->createMessage("5006712", $body);
        $bw_resp = $response->getResult();
        print_r($bw_resp);
    } catch (Exception $e) {
        $bw_resp = $e;
        print_r($bw_resp);
    }
    
    // get phone number and name of gifted
    $receiver_phone = getPhone($connection, $water_id);
    $receiver_name = getName($connection, $water_id);
    $receiver_fname = getFirstName($connection, $water_id);

    // properly format the phone number
    $phone_number = preg_replace('/[^0-9]/','',$receiver_phone);
     if(strlen($phone_number) > 10) { //apply proper formatting to recipient's number - 11+ characters
            $countryCode = substr($phone_number, 0, strlen($phone_number)-10);
            $areaCode = substr($phone_number, -10, 3);
            $nextThree = substr($phone_number, -7, 3);
            $lastFour = substr($phone_number, -4, 4);

             $phone_number = '+1' . $areaCode . $nextThree . $lastFour;
        }
        else if(strlen($phone_number) == 10) { //apply proper formatting to recipient's number - 10 characters
            $areaCode = substr($phone_number, 0, 3);
            $nextThree = substr($phone_number, 3, 3);
            $lastFour = substr($phone_number, 6, 4);

            $phone_number = '+1' . $areaCode . $nextThree . $lastFour;
        }
        else if(strlen($phone_number) == 7) { //apply proper formatting to recipient's number - 7 characters
            $nextThree = substr($phone_number, 0, 3);
            $lastFour = substr($phone_number, 3, 4);

            $phone_number = $nextThree . '-' . $lastFour;
        }

    $receiver_phone = $phone_number;

    $config = new BandwidthLib\Configuration(
        array(
            'messagingBasicAuthUserName' => TLOB_USERNAME,
            'messagingBasicAuthPassword' => TLOB_PASSWORD
        )
    );

    $client = new BandwidthLib\BandwidthClient($config);

    $messagingClient = $client->getMessaging()->getClient();

    $from = "+12134592055";
    $to = array($receiver_phone);
    $link = "https://www.thelotus.online/receiver.php?id=" . $harvestID . "&key=" . $receiver_key . "&name=" . $receiver_name;
    $text = "Hello " . $receiver_fname . ", \n Congratulations on your new gift. \n Click the link below to sign your gift letter. \n" . $link . "\n The Lotus Online"; 

    $body = new BandwidthLib\Messaging\Models\MessageRequest();
    $body->applicationId = TLOB_APPID;
    $body->to = $to;
    $body->from = $from;
    $body->text = $text;

    try {
        $response = $messagingClient->createMessage("5006712", $body);
        $bw_resp = $response->getResult();
        print_r($bw_resp);
    } catch (Exception $e) {
        $bw_resp = $e;
        print_r($bw_resp);
    }
*/
    // send mail to gifter
    gifterSignatureEmail($connection, $fire_id, $gifter_key, $harvestID);

    // send mail to receiver
    receiverSignatureEmail($connection, $water_id, $receiver_key, $harvestID);

    $query2 = "UPDATE users SET flower = 1 WHERE lotus_id='{$fire_id}'";
    $result = mysqli_query($connection, $query2);