<?php
ob_start();
require("PHPMailer_5.2.0/class.phpmailer.php");

global $harvest_front,$harvest_back,$family_front,$family_back;
$harvest_front='assets/one-page/images/harvest-front.jpg';
$harvest_back='assets/one-page/images/harvest-back.jpg';
$family_front='assets/one-page/images/Lotus.jpg';
$family_back='assets/one-page/images/family.jpg';
// functions.php - called by most files 
// to access custom php functions 
//
// (c) 2018, 5Onit
// Written by James Misa 

function confirm_query($result_set, $connection) {
    if (!$result_set) {
        $message = 'Invalid query: ' . mysqli_error($connection) . "\n";
        $message .= 'Whole query: ' . $result_set;
        die($message);
    } 
}

function check_required_fields($required_array) {
	$field_errors = array();
	foreach($required_array as $fieldname) {
		if (!isset($_REQUEST[$fieldname]) || (empty($_REQUEST[$fieldname]))) { 
			$field_errors[] = $fieldname; 
		}
	}
	return $field_errors;
}

function check_max_field_lengths($field_length_array) {
	$field_errors = array();
	foreach($field_length_array as $fieldname => $maxlength ) {
		if (strlen(trim(($_POST[$fieldname]))) > $maxlength) { $field_errors[] = $fieldname; }
	}
	return $field_errors;
}

function createTLFid () {
	date_default_timezone_set("America/Los_Angeles");
	$tlf_id = uniqid();

	return $tlf_id;
}

function createLotusId ($connection, $tlf_id, $board_brand) {
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE tlf_id = '{$tlf_id}' AND board_brand = '{$board_brand}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    $num = mysqli_num_rows($resultSet);
    if($num == 0) {
        if($board_brand == "gate") {
            $ext = "_100";
        } else if($board_brand == "garden") {
            $ext = "_500";
        }
        $lotus_id = $tlf_id . $ext;
    } else {
        $lotus_ids = array();
        $i = 0;
        while($found_boards = mysqli_fetch_array($resultSet)) {
            $lotus_id_old = $found_boards['lotus_id'];
            $suffix = substr($lotus_id_old, strpos($lotus_id_old, "_") + 1);
            $lotus_ids[$i] = $suffix;
            $i++;
        }
        $biggest = max($lotus_ids);
        $increment = $biggest + 1;
        $lotus_id = $tlf_id . "_" . $increment;
    }
    return $lotus_id;
}

function generateRandomString($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getContactInfo($connection, $lotus_id, $position) {
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE lotus_id = '{$lotus_id}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    while($found_contact = mysqli_fetch_array($resultSet)) {
        $name = $found_contact['first_name'] . " " . $found_contact['last_name'];
        $phone = $found_contact['phone'];
        $phone_number = preg_replace('/[^0-9]/','',$phone);
         if(strlen($phone_number) > 10) { //apply proper formatting to recipient's number - 11+ characters
                $countryCode = substr($phone_number, 0, strlen($phone_number)-10);
                $areaCode = substr($phone_number, -10, 3);
                $nextThree = substr($phone_number, -7, 3);
                $lastFour = substr($phone_number, -4, 4);

                 $phone_number = '(' . $areaCode . ') ' . $nextThree . '-' . $lastFour;
            }
            else if(strlen($phone_number) == 10) { //apply proper formatting to recipient's number - 10 characters
                $areaCode = substr($phone_number, 0, 3);
                $nextThree = substr($phone_number, 3, 3);
                $lastFour = substr($phone_number, 6, 4);

                $phone_number = '(' . $areaCode . ') ' . $nextThree . '-' . $lastFour;
            }
            else if(strlen($phone_number) == 7) { //apply proper formatting to recipient's number - 7 characters
                $nextThree = substr($phone_number, 0, 3);
                $lastFour = substr($phone_number, 3, 4);

                $phone_number = $nextThree . '-' . $lastFour;
            }
        $email = $found_contact['email'];
    }
    $contact_info = '<tr>
                      <td>' . $position . '</td>
                      <td>' . $name . '</td>
                      <td>' . $phone_number . '</td>
                      <td>' . $email . '</td>
                    </tr>';
    return $contact_info;
}

function getContactInfoInvitees($connection, $tlf_id) {
    $invitees = "";
    $invitees = $invitees . '<table class="table table-striped">
                                            <thead>
                                                <tr>
                                                  <th scope="col">ID</th>
                                                  <th scope="col">Name</th>
                                                  <th scope="col">Phone</th>
                                                  <th scope="col">Email</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE referrer = '{$tlf_id}' && flower = 1";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    while($found_contact = mysqli_fetch_array($resultSet)) {
        $name = $found_contact['first_name'] . " " . $found_contact['last_name'];
        $phone = $found_contact['phone'];
        $id = $found_contact['id'];
        $phone_number = preg_replace('/[^0-9]/','',$phone);
         if(strlen($phone_number) > 10) { //apply proper formatting to recipient's number - 11+ characters
                $countryCode = substr($phone_number, 0, strlen($phone_number)-10);
                $areaCode = substr($phone_number, -10, 3);
                $nextThree = substr($phone_number, -7, 3);
                $lastFour = substr($phone_number, -4, 4);

                 $phone_number = '(' . $areaCode . ') ' . $nextThree . '-' . $lastFour;
            }
            else if(strlen($phone_number) == 10) { //apply proper formatting to recipient's number - 10 characters
                $areaCode = substr($phone_number, 0, 3);
                $nextThree = substr($phone_number, 3, 3);
                $lastFour = substr($phone_number, 6, 4);

                $phone_number = '(' . $areaCode . ') ' . $nextThree . '-' . $lastFour;
            }
            else if(strlen($phone_number) == 7) { //apply proper formatting to recipient's number - 7 characters
                $nextThree = substr($phone_number, 0, 3);
                $lastFour = substr($phone_number, 3, 4);

                $phone_number = $nextThree . '-' . $lastFour;
            }
        $email = $found_contact['email'];
        $invitees = $invitees . '<tr>
                          <td>' . $id . '</td>
                          <td>' . $name . '</td>
                          <td>' . $phone_number . '</td>
                          <td>' . $email . '</td>
                        </tr>';
    }
    $invitees = $invitees . '</tbody></table>';
    return $invitees;
}

function getId($connection, $lotus_id) {
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE lotus_id = '{$lotus_id}' LIMIT 1";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    $found_tree = mysqli_fetch_array($resultSet);
    $id = $found_tree['id'];
    
    return $id;
}

function getFiresGiftedArray($connection, $water_id, $gift_date) {
    $query = "SELECT *";
    $query .= "FROM harvests ";
    $query .= "WHERE water_id = '{$water_id}' AND gift_date = '{$gift_date}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    $gifted = array();
    
    while($gifted_fires = mysqli_fetch_array($resultSet)) {
        $gifted[] = $gifted_fires['fire_id'];
    }
    return $gifted;
}

function getInviterName($connection, $inviter_id) {
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE tlf_id = '{$inviter_id}' LIMIT 1";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    while($found_referrer = mysqli_fetch_array($resultSet)) {
        $first_name = $found_referrer['first_name'];
        $last_name = $found_referrer['last_name'];
        $inviter_name = $first_name . " " . $last_name;
    }
    return $inviter_name;
}

function getFiresArray($connection, $lotus_id){
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE water_id = '{$lotus_id}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    $fires = array();
    
    while($found_fires = mysqli_fetch_array($resultSet)) {
        $fires[] = $found_fires['lotus_id'];
    }
    return $fires;
}

function getPhone($connection, $lotus_id) {
    $query = "SELECT * ";
    $query .= "FROM users ";
    $query .= "WHERE lotus_id = '{$lotus_id}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    $found_user = mysqli_fetch_array($resultSet);
    $phone = $found_user['phone'];
    
    return $phone;
}

function getName($connection, $lotus_id) {
    $query = "SELECT first_name, last_name ";
    $query .= "FROM users ";
    $query .= "WHERE lotus_id = '{$lotus_id}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    $found_user = mysqli_fetch_array($resultSet);
    $name = $found_user['first_name'] . " " . $found_user['last_name'];
    
    return $name;
}

function getFirstName($connection, $lotus_id) {
    $query = "SELECT first_name ";
    $query .= "FROM users ";
    $query .= "WHERE lotus_id = '{$lotus_id}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    $found_user = mysqli_fetch_array($resultSet);
    $name = $found_user['first_name'];
    
    return $name;
}

function getOtherFiresOld($connection, $water_id, $gift_date) {
    $allFires = getFiresArray($connection, $water_id);
    $giftedFires = getFiresGiftedArray($connection, $water_id, $gift_date);
    $otherFires = array_diff($allFires, $giftedFires);
    
    $contact_info = "";
    foreach($otherFires as $fire) {
            $query2 = "SELECT *";
            $query2 .= "FROM users ";
            $query2 .= "WHERE lotus_id = '{$fire}'";
            $resultSet2 = mysqli_query($connection, $query2);
            confirm_query($resultSet2, $connection);

            while($found_contact = mysqli_fetch_array($resultSet2)) {
            $fname = $found_contact['first_name'];
            $name = $found_contact['first_name'] . " " . $found_contact['last_name'];
            $phone = $found_contact['phone'];
            $phone_number = preg_replace('/[^0-9]/','',$phone);
             if(strlen($phone_number) > 10) { //apply proper formatting to recipient's number - 11+ characters
                    $countryCode = substr($phone_number, 0, strlen($phone_number)-10);
                    $areaCode = substr($phone_number, -10, 3);
                    $nextThree = substr($phone_number, -7, 3);
                    $lastFour = substr($phone_number, -4, 4);

                     $phone_number = '(' . $areaCode . ') ' . $nextThree . '-' . $lastFour;
                }
                else if(strlen($phone_number) == 10) { //apply proper formatting to recipient's number - 10 characters
                    $areaCode = substr($phone_number, 0, 3);
                    $nextThree = substr($phone_number, 3, 3);
                    $lastFour = substr($phone_number, 6, 4);

                    $phone_number = '(' . $areaCode . ') ' . $nextThree . '-' . $lastFour;
                }
                else if(strlen($phone_number) == 7) { //apply proper formatting to recipient's number - 7 characters
                    $nextThree = substr($phone_number, 0, 3);
                    $lastFour = substr($phone_number, 3, 4);

                    $phone_number = $nextThree . '-' . $lastFour;
                }
            $email = $found_contact['email'];
            $contact_info = $contact_info . '<tr>
                                      <td>' . $name . '</td>
                                      <td>' . $phone_number . '</td>
                                      <td>' . $email . '</td>
                                      <td><button class="btn btn-primary" onclick="addGiftedFire(\'' . $water_id . '\', \'' . $fire . '\', \'' . $gift_date . '\', \'' . $fname . '\');">pending</td>
                                    </tr>';
            }
    }
    return $contact_info;
}

function getFiresGiftedOld($connection, $lotus_id, $next_water) {
    $query = "SELECT *";
    $query .= "FROM harvests ";
    $query .= "WHERE water_id = '{$lotus_id}' AND gift_date = '{$next_water}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    $contact_info = "";
    while($gifted_fires = mysqli_fetch_array($resultSet)) {
        $gifted = $gifted_fires['fire_id'];
        $query2 = "SELECT *";
        $query2 .= "FROM users ";
        $query2 .= "WHERE lotus_id = '{$gifted}'";
        $resultSet2 = mysqli_query($connection, $query2);
        confirm_query($resultSet2, $connection);
        
        while($found_contact = mysqli_fetch_array($resultSet2)) {
        $name = $found_contact['first_name'] . " " . $found_contact['last_name'];
        $phone = $found_contact['phone'];
        $phone_number = preg_replace('/[^0-9]/','',$phone);
         if(strlen($phone_number) > 10) { //apply proper formatting to recipient's number - 11+ characters
                $countryCode = substr($phone_number, 0, strlen($phone_number)-10);
                $areaCode = substr($phone_number, -10, 3);
                $nextThree = substr($phone_number, -7, 3);
                $lastFour = substr($phone_number, -4, 4);

                 $phone_number = '(' . $areaCode . ') ' . $nextThree . '-' . $lastFour;
            }
            else if(strlen($phone_number) == 10) { //apply proper formatting to recipient's number - 10 characters
                $areaCode = substr($phone_number, 0, 3);
                $nextThree = substr($phone_number, 3, 3);
                $lastFour = substr($phone_number, 6, 4);

                $phone_number = '(' . $areaCode . ') ' . $nextThree . '-' . $lastFour;
            }
            else if(strlen($phone_number) == 7) { //apply proper formatting to recipient's number - 7 characters
                $nextThree = substr($phone_number, 0, 3);
                $lastFour = substr($phone_number, 3, 4);

                $phone_number = $nextThree . '-' . $lastFour;
            }
        $email = $found_contact['email'];
        $contact_info = $contact_info . '<tr>
                                  <td>' . $name . '</td>
                                  <td>' . $phone_number . '</td>
                                  <td>' . $email . '</td>
                                  <td><button class="btn btn-success"><i class="far fa-thumbs-up"></i></button></td>
                                </tr>';
        }
    }
    return $contact_info;
    
}


function getFires($connection, $lotus_id, $next_water) {
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE water_id = '{$lotus_id}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    $contact_info = "";
    while($found_contact = mysqli_fetch_array($resultSet)) {
        $fname = $found_contact['first_name'];
        $fire_id = $found_contact['lotus_id'];
        $name = $found_contact['first_name'] . " " . $found_contact['last_name'];
        $phone = $found_contact['phone'];
        $phone_number = preg_replace('/[^0-9]/','',$phone);
         if(strlen($phone_number) > 10) { //apply proper formatting to recipient's number - 11+ characters
                $countryCode = substr($phone_number, 0, strlen($phone_number)-10);
                $areaCode = substr($phone_number, -10, 3);
                $nextThree = substr($phone_number, -7, 3);
                $lastFour = substr($phone_number, -4, 4);

                 $phone_number = '(' . $areaCode . ') ' . $nextThree . '-' . $lastFour;
            }
            else if(strlen($phone_number) == 10) { //apply proper formatting to recipient's number - 10 characters
                $areaCode = substr($phone_number, 0, 3);
                $nextThree = substr($phone_number, 3, 3);
                $lastFour = substr($phone_number, 6, 4);

                $phone_number = '(' . $areaCode . ') ' . $nextThree . '-' . $lastFour;
            }
            else if(strlen($phone_number) == 7) { //apply proper formatting to recipient's number - 7 characters
                $nextThree = substr($phone_number, 0, 3);
                $lastFour = substr($phone_number, 3, 4);

                $phone_number = $nextThree . '-' . $lastFour;
            }
        $email = $found_contact['email'];
        $contact_info = $contact_info . '<tr>
                                  <td>' . $name . '</td>
                                  <td>' . $phone_number . '</td>
                                  <td>' . $email . '</td>
                                  <td><button class="btn btn-primary" onclick="addGiftedFire(\'' . $lotus_id . '\', \'' . $fire_id . '\', \'' . $next_water . '\', \'' . $fname . '\');">Pending</button></td>
                                </tr>';
    }
    return $contact_info;
}

function getOtherFires($connection, $water_id, $gift_date) {
    $allFires = getFiresArray($connection, $water_id);
    $giftedFires = getFiresGiftedArray($connection, $water_id, $gift_date);
    $otherFires = array_diff($allFires, $giftedFires);
    
    $contact_info = "";
    foreach($otherFires as $fire) {
            $query2 = "SELECT *";
            $query2 .= "FROM users ";
            $query2 .= "WHERE lotus_id = '{$fire}'";
            $resultSet2 = mysqli_query($connection, $query2);
            confirm_query($resultSet2, $connection);

            while($found_contact = mysqli_fetch_array($resultSet2)) {
            $fname = $found_contact['first_name'];
            $name = $found_contact['first_name'] . " " . $found_contact['last_name'];
            $phone = $found_contact['phone'];
            $phone_number = preg_replace('/[^0-9]/','',$phone);
             if(strlen($phone_number) > 10) { //apply proper formatting to recipient's number - 11+ characters
                    $countryCode = substr($phone_number, 0, strlen($phone_number)-10);
                    $areaCode = substr($phone_number, -10, 3);
                    $nextThree = substr($phone_number, -7, 3);
                    $lastFour = substr($phone_number, -4, 4);

                     $phone_number = '(' . $areaCode . ') ' . $nextThree . '-' . $lastFour;
                }
                else if(strlen($phone_number) == 10) { //apply proper formatting to recipient's number - 10 characters
                    $areaCode = substr($phone_number, 0, 3);
                    $nextThree = substr($phone_number, 3, 3);
                    $lastFour = substr($phone_number, 6, 4);

                    $phone_number = '(' . $areaCode . ') ' . $nextThree . '-' . $lastFour;
                }
                else if(strlen($phone_number) == 7) { //apply proper formatting to recipient's number - 7 characters
                    $nextThree = substr($phone_number, 0, 3);
                    $lastFour = substr($phone_number, 3, 4);

                    $phone_number = $nextThree . '-' . $lastFour;
                }
            $email = $found_contact['email'];
            $contact_info = $contact_info . '<tr>
                                      <td>' . $name . '</td>
                                      <td>' . $phone_number . '</td>
                                      <td>' . $email . '</td>
                                      <td>N/A</td>
                                      <td><button class="btn btn-primary" onclick="addGiftedFire(\'' . $water_id . '\', \'' . $fire . '\', \'' . $gift_date . '\', \'' . $fname . '\');">pending</button></td>
                                    </tr>';
            }
    }
    return $contact_info;
}

function getFiresGifted($connection, $lotus_id, $next_water) {
    $query = "SELECT *";
    $query .= "FROM harvests ";
    $query .= "WHERE water_id = '{$lotus_id}' AND gift_date = '{$next_water}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    $contact_info = "";
    while($gifted_fires = mysqli_fetch_array($resultSet)) {
        $harvestsID = $gifted_fires['id'];
        $is_gifter_sign = $gifted_fires['is_gifter_sign'];
        $is_receiver_sign = $gifted_fires['is_receiver_sign'];

        $gifted = $gifted_fires['fire_id'];
        $query2 = "SELECT *";
        $query2 .= "FROM users ";
        $query2 .= "WHERE lotus_id = '{$gifted}'";
        $resultSet2 = mysqli_query($connection, $query2);
        confirm_query($resultSet2, $connection);
        
        while($found_contact = mysqli_fetch_array($resultSet2)) {
        $name = $found_contact['first_name'] . " " . $found_contact['last_name'];
        $phone = $found_contact['phone'];
        $phone_number = preg_replace('/[^0-9]/','',$phone);
         if(strlen($phone_number) > 10) { //apply proper formatting to recipient's number - 11+ characters
                $countryCode = substr($phone_number, 0, strlen($phone_number)-10);
                $areaCode = substr($phone_number, -10, 3);
                $nextThree = substr($phone_number, -7, 3);
                $lastFour = substr($phone_number, -4, 4);

                 $phone_number = '(' . $areaCode . ') ' . $nextThree . '-' . $lastFour;
            }
            else if(strlen($phone_number) == 10) { //apply proper formatting to recipient's number - 10 characters
                $areaCode = substr($phone_number, 0, 3);
                $nextThree = substr($phone_number, 3, 3);
                $lastFour = substr($phone_number, 6, 4);

                $phone_number = '(' . $areaCode . ') ' . $nextThree . '-' . $lastFour;
            }
            else if(strlen($phone_number) == 7) { //apply proper formatting to recipient's number - 7 characters
                $nextThree = substr($phone_number, 0, 3);
                $lastFour = substr($phone_number, 3, 4);

                $phone_number = $nextThree . '-' . $lastFour;
            }
        $email = $found_contact['email'];
            if($is_gifter_sign == 1 && $is_receiver_sign == 1){
                $pdf = '<a href="download_pdf.php?id='.$harvestsID.'">Download</a>';
            }else{
                $pdf = 'Pending';
            }
        $contact_info = $contact_info . '<tr>
                                  <td>' . $name . '</td>
                                  <td>' . $phone_number . '</td>
                                  <td>' . $email . '</td>
                                  <td>' . $pdf . '</td>
                                  <td><button class="btn btn-success"><i class="far fa-thumbs-up"></i></button></td>
                                </tr>';
        }
    }
    return $contact_info;
    
}

function getNextGiftOld($connection, $tlf_id) {
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE tlf_id = '{$tlf_id}' AND flower = 1";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    $flower_contacts = '<div class="accordion">';
    $i=1;
    while($found_user = mysqli_fetch_array($resultSet)) {
        $id = $found_user['id'];
        $lotus_id = $found_user['lotus_id'];
        $air_id = $found_user['air_id'];
        $earth_id = $found_user['earth_id'];
        $water_id = $found_user['water_id'];
        $display_name = $found_user['display_name'];
        $fireDate = $found_user['fireDate'];
        $formatted_fireDate = date("m/d/Y", $fireDate);
        
        date_default_timezone_set('America/Los_Angeles');
        $today = strtotime(date("m/d/Y"));
        $mod_fireDate = $fireDate - 7*24*60*60;
        $diff = $today - $mod_fireDate;
        $days = round($diff /60/60/24);
        $weeks = ($days / 7);
        $harvests = ceil($weeks/4);
        $harvest = 4*7*24*60*60;
        $next_water = $mod_fireDate + ($harvests * $harvest);
        $water = date("m/d/Y", $next_water);
        
        $flower_contacts = $flower_contacts . 
        '<button type="button" class="btn btn-default btn-lg btn-block collapsed" data-toggle="collapse" data-target="#collapse' . $i . '" aria-expanded="true" aria-controls="collapse' . $i . '" style="margin-bottom:5px; font-family:sans-serif;"><span class="full-name">ID #' . $id . ' ( ' . $display_name . ') </span><span class="counts"> Next Harvest: ' . $water .  '</span></button>';
        
        $flower_contacts = $flower_contacts . '<div id="collapse' . $i . '" class="collapse" aria-labelledby="heading' . $i . '" data-parent=".accordion">
          <div class="card-body">';
        $flower_contacts = $flower_contacts . '<table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                      <th scope="col">Name</th>
                                                      <th scope="col">Phone</th>
                                                      <th scope="col">Email</th>
                                                      <th scope="col">Gifted</th>
                                                    </tr>
                                                </thead>
                                                <tbody>';
        $flower_contacts = $flower_contacts . getFiresGifted($connection, $lotus_id, $next_water);
        $flower_contacts = $flower_contacts . getOtherFires($connection, $lotus_id, $next_water);
        $flower_contacts = $flower_contacts . '</tbody>
                                        </table></div></div></div>';
        $i++;
    }
    $flower_contacts = $flower_contacts . '</div>';
    return $flower_contacts;
}

function getNextGift($connection, $tlf_id) {
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE tlf_id = '{$tlf_id}' AND view=0";


    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    global $harvest_front,$harvest_back; 
    //$flower_contacts = '<div class="accordion">';
     $flower_contacts = '';
    $i=1;
    while($found_user = mysqli_fetch_array($resultSet)) {
        $id = $found_user['id'];
        $lotus_id = $found_user['lotus_id'];
        $air_id = $found_user['air_id'];
        $earth_id = $found_user['earth_id'];
        $water_id = $found_user['water_id'];
        $fireDate = $found_user['fireDate'];
        $formatted_fireDate = date("m/d/Y", $fireDate);
        
        date_default_timezone_set('America/Los_Angeles');
        $today = strtotime(date("m/d/Y"));
        $mod_fireDate = $fireDate - 7*24*60*60;
        $diff = $today - $mod_fireDate;
        $days = round($diff /60/60/24);
        $weeks = ($days / 7);
        $harvests = ceil($weeks/4);
        $harvest = 4*7*24*60*60;
        $next_water = $mod_fireDate + ($harvests * $harvest);
        $water = date("m/d/Y", $next_water);
        
        $flower_contacts.='<div class="col-lg-4 mb-4">
                                    <div class="flip-card top-to-bottom">
                                        <div class="flip-card-front dark" data-height-xl="200" style="background-image: url(\''.$harvest_front.'\')">
                                            <div class="flip-card-inner">
                                                <div class="card bg-transparent border-0">
                                                    <div class="card-body">
                                                        <h3 class="card-title mb-0">Tree ID #' . $id . '</h3>
                                                        <span class="font-italic">Next Harvest : ' . $water .  ' </span>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flip-card-back" data-height-xl="200" style="background-image: url(\''.$harvest_back.'\')">
                                            <div class="flip-card-inner">
                                                <h3 class="mb-2 text-white">Next Harvest</h3>
                                                <p class="message">'.$harvestmessage.'</p>
                                                <span class="font-italic"> ' . $water .  '</span><br />
                                                <button type="button" class="btn btn-outline-light mt-2 view_detail_btn" data-flower_id="'.$id.'" data-lotus_id="'.$lotus_id.'" data-next_water="'.$next_water.'" data-gift="next"  aria-expanded="true" aria-controls="collapse' . $i . '" >View Details</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>';

         
       
        
       
        $i++;
    }
    //$flower_contacts = $flower_contacts . '</div>';
    return $flower_contacts;
}



function getInviterTLF($connection, $inviter_id) {
    if($inviter_id == "") {
        $inviter_name = "unlisted";
    } else {
        $query = "SELECT *";
        $query .= "FROM users ";
        $query .= "WHERE tlf_id = '{$inviter_id}' LIMIT 1";
        $resultSet = mysqli_query($connection, $query);
        confirm_query($resultSet, $connection);

        while($found_referrer = mysqli_fetch_array($resultSet)) {
            $first_name = $found_referrer['first_name'];
            $last_name = $found_referrer['last_name'];

            $name_split = str_split($last_name);
            $initial = $name_split[0] . ".";

            $inviter_name = "(" . $first_name . " " . $initial . ")";
        }
    }
    
    return $inviter_name;
}

function showSeeds($connection, $tlf_id) {
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE referrer = '{$tlf_id}' && flower = 0 ";
    $query .= "ORDER BY fireDate ASC";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    $num = 1;
    while($found_seeds = mysqli_fetch_array($resultSet)){
            $seed_name = $found_seeds['first_name'] . " " . $found_seeds['last_name'];
            $fireDate = $found_seeds['fireDate'];
            $formatted_fireDate = date("m/d/Y", $fireDate);
            $seed_tlf_id = $found_seeds['tlf_id'];  

            $query2 = sprintf("SELECT * FROM milestones WHERE tlf_id='%s'", 
            mysqli_real_escape_string($connection, $seed_tlf_id));

            $result2 = mysqli_query($connection, $query2); 
            while($found_milestone = mysqli_fetch_array($result2)) {
                $percentage = $found_milestone['percentage'];
            }
            echo '<button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#new-seed" disabled><span class="full-name">#' . $num . ": " . $seed_name . "</span>  Exp. Seed Date: " . $formatted_fireDate . '<span class="counts">' . $percentage . '%</span></button>';
            $num++;
        }
}

function getEcoSeeds($connection, $tlf_id) {
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE tlf_id = '{$tlf_id}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    $eco_seeds = "";
    while($found_user = mysqli_fetch_array($resultSet)) {
        $lotus_id = $found_user['lotus_id'];
        $query2 = "SELECT *";
        $query2 .= "FROM users ";
        $query2 .= "WHERE air_id = '{$lotus_id}'";
        $resultSet2 = mysqli_query($connection, $query2);
        confirm_query($resultSet2, $connection);
        
        while($found_earths = mysqli_fetch_array($resultSet2)) {
            $earth_lotus_id = $found_earths['lotus_id'];
            $name = $found_earths['first_name'] . " " . $found_earths['last_name'];
            $earth_tlf_id = $found_earths['tlf_id'];
            $eco_seeds = $eco_seeds . "<h1>Earth: " . $name . "</h1>";
            $eco_seeds = $eco_seeds . showSeeds($connection, $earth_tlf_id);
            $query3 = "SELECT *";
            $query3 .= "FROM users ";
            $query3 .= "WHERE air_id = '{$lotus_id}'";
            $resultSet3 = mysqli_query($connection, $query3);
            confirm_query($resultSet3, $connection);
            
            while($found_airs = mysqli_fetch_array($resultSet3)) {
                $air_lotus_id = $found_airs['lotus_id'];
                $name = $found_airs['first_name'] . " " . $found_airs['last_name'];
                $air_tlf_id = $found_airs['tlf_id'];
                $eco_seeds = $eco_seeds . "<h1>Air: " . $name . "</h1>";
                $eco_seeds = $eco_seeds . showSeeds($connection, $air_tlf_id);
                $query4 = "SELECT *";
                $query4 .= "FROM users ";
                $query4 .= "WHERE air_id = '{$lotus_id}'";
                $resultSet4 = mysqli_query($connection, $query4);
                confirm_query($resultSet4, $connection);
                
                while($found_fires = mysqli_fetch_array($resultSet4)) {
                    $fire_lotus_id = $found_fires['lotus_id'];
                    $name = $found_fires['first_name'] . " " . $found_fires['last_name'];
                    $fire_tlf_id = $found_fires['tlf_id'];
                    $eco_seeds = $eco_seeds . "<h1>Fire: " . $name . "</h1>";
                    $eco_seeds = $eco_seeds . showSeeds($connection, $fire_tlf_id);
                }
            }
        }
    }
    return $eco_seeds;
}

//////// add gifter signature email ////////////
function gifterSignatureEmail($connection, $lotus_id, $key, $harvestID) {
    //need css
    $query4 = "SELECT * ";
    $query4 .= "FROM users ";
    $query4 .= "WHERE lotus_id = '{$lotus_id}'";
    $resultSet4 = mysqli_query($connection, $query4);
    confirm_query($resultSet4, $connection);
    if(mysqli_num_rows($resultSet4) > 0) {
        $foundRow = mysqli_fetch_array($resultSet4);
        $first_name = $foundRow['first_name'];
        $last_name = $foundRow['last_name'];
        $email_address = $foundRow['email'];
        $lotus_id = $foundRow['lotus_id'];
    }
    $link = "<a href='https://www.breakingchainsprivatecoop.com/gifter.php?id=" . $harvestID . "&key=" . $key . "&name=" . $first_name . "'>CLICK HERE</a>";
    $to      = $email_address;//$email_address;
    $subject = 'Your gift has been confirmed! - Gifter';
    $message = '<html><body><p>Hello ' . $first_name . ',</p>' .
        '<p>Your gift has been received and confirmed.</p>' .
        '<p>Your gift letter is available online.</p>' .
        '<p>Click the link below </p>' .
        '<p><b>to Sign documents :</b> ' . $link . '</p>' .
        '<p>Thank you!</p>' .
        '<p>The Eden Project</p></body></html>';

//    if(mail($to, $subject, $message)){
//        $msg = "Message has been sent.";
//        $data = array('status'=>4, 'msg'=>$msg);
//        $json = json_encode($data);
//        exit();
//    }
//    exit();

    $mail = new PHPMailer();

    $mail->IsSMTP(); // set mailer to use SMTP
    $mail->Host = "smtpout.secureserver.net";  // specify main and backup server
    $mail->SMTPAuth = true;     // turn on SMTP authentication
    $mail->Username = "james@aliasmobile.com";  // SMTP username
    $mail->Password = "james"; // SMTP password

    $mail->setFrom("support@breakingchainsprivatecoop.com");
    $mail->FromName = "The Eden Project Support";
    $mail->AddAddress($to);                  // name is optional
    $mail->AddReplyTo("support@breakingchainsprivatecoop.com", "The Eden Project Support");
    $mail->addBCC("james@aliasmobile.com");

    $mail->WordWrap = 50;                                 // set word wrap to 50 characters
    $mail->IsHTML(true);                                  // set email format to HTML

    $mail->Subject = $subject;
    $mail->Body    = $message;
    $mail->AltBody = $message;

    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    if(!$mail->Send())
    {
        $msg = "Message could not be sent.";
        $msg += "Mailer Error: " . $mail->ErrorInfo;
        $data = array('status'=>1, 'msg'=>$msg);
        $json = json_encode($data);
        echo $json;
        exit;
    }

    $msg = "Message has been sent.";
    $data = array('status'=>4, 'msg'=>$msg);
    $json = json_encode($data);
    //echo $json;

}

//////// add receiver signature email ////////////
function receiverSignatureEmail($connection, $lotus_id, $key, $harvestID) {
    //need css
    $query41 = "SELECT * ";
    $query41 .= "FROM users ";
    $query41 .= "WHERE lotus_id = '{$lotus_id}'";
    $resultSet41 = mysqli_query($connection, $query41);
    confirm_query($resultSet41, $connection);
    if(mysqli_num_rows($resultSet41) > 0) {
        $foundRow1 = mysqli_fetch_array($resultSet41);
        $first_name_R = $foundRow1['first_name'];
        $last_name = $foundRow1['last_name'];
        $email_address = $foundRow1['email'];
        $lotus_id = $foundRow1['lotus_id'];
    }
    $linkr = "<a href='https://www.breakingchainsprivatecoop.com/receiver.php?id=" . $harvestID . "&key=" . $key . "&name=" . $first_name_R . "'>CLICK HERE</a>";
    $tor      = $email_address;//$email_address;
    $subjectr = 'You\'ve received a new gift!';
    $messager = '<html><body><p>Hello ' . $first_name_R . ',</p>' .
        '<p>Congratulations on receiving your new gift.</p>' .
        '<p>Your gift letter is available online.</p>' .
        '<p>Click the link below </p>' .
        '<p><b>to Sign documents :</b> ' . $linkr . '</p>' .
        '<p>Thank you!</p>' .
        '<p>The Eden Project</p></body></html>';

//    if(mail($tor, $subjectr, $messager)){
//        $msg = "Message has been sent.";
//        $data = array('status' => 4, 'msg' => $msg);
//        echo $json = json_encode($data);
//        exit();
//    }
//    exit();
    $mail = new PHPMailer();

    $mail->IsSMTP(); // set mailer to use SMTP
    $mail->Host = "smtpout.secureserver.net";  // specify main and backup server
    $mail->SMTPAuth = true;     // turn on SMTP authentication
    $mail->Username = "james@aliasmobile.com";  // SMTP username
    $mail->Password = "james"; // SMTP password

    $mail->setFrom("support@breakingchainsprivatecoop.com");
    $mail->FromName = "The Eden Project Support";
    $mail->AddAddress($tor);                  // name is optional
    $mail->AddReplyTo("support@breakingchainsprivatecoop.com", "The Eden Project Support");
    $mail->addBCC("james@aliasmobile.com");

    $mail->WordWrap = 50;                                 // set word wrap to 50 characters
    $mail->IsHTML(true);                                  // set email format to HTML

    $mail->Subject = $subjectr;
    $mail->Body    = $messager;
    $mail->AltBody = $messager;

    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    if(!$mail->Send())
    {
        $msg = "Message could not be sent.";
        $msg += "Mailer Error: " . $mail->ErrorInfo;
        $data = array('status'=>1, 'msg'=>$msg);
        $json = json_encode($data);
        echo $json;
        exit;
    }

    $msg = "Message has been sent.";
    $data = array('status'=>4, 'msg'=>$msg);
    $json = json_encode($data);
    //echo $json;

}

function getLastGiftOld($connection, $tlf_id) {
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE tlf_id = '{$tlf_id}' AND flower = 1";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    $flower_contacts = '<div class="accordion">';
    $i=11;
    while($found_user = mysqli_fetch_array($resultSet)) {
        $id = $found_user['id'];
        $lotus_id = $found_user['lotus_id'];
        $air_id = $found_user['air_id'];
        $earth_id = $found_user['earth_id'];
        $water_id = $found_user['water_id'];
        $display_name = $found_user['display_name'];
        $fireDate = $found_user['fireDate'];
        $formatted_fireDate = date("m/d/Y", $fireDate);
        
        date_default_timezone_set('America/Los_Angeles');
        $today = strtotime(date("m/d/Y"));
        $mod_fireDate = $fireDate - 7*24*60*60;
        $diff = $today - $mod_fireDate;
        $days = round($diff /60/60/24);
        $weeks = ($days / 7);
        $harvests = ceil($weeks/4)-1;
        $harvest = 4*7*24*60*60;
        $next_water = $mod_fireDate + ($harvests * $harvest);
        $water = date("m/d/Y", $next_water);
        
        if($harvests > 0) {
            $flower_contacts = $flower_contacts . 
            '<button type="button" class="btn btn-warning btn-lg btn-block collapsed" data-toggle="collapse" data-target="#collapse' . $i . '" aria-expanded="true" aria-controls="collapse' . $i . '" style="margin-bottom:5px; font-family:sans-serif;"><span class="full-name">ID #' . $id . ' ( ' . $display_name . ') </span><span class="counts"> Last Harvest: ' . $water .  '</span></button>';

            $flower_contacts = $flower_contacts . '<div id="collapse' . $i . '" class="collapse" aria-labelledby="heading' . $i . '" data-parent=".accordion">
              <div class="card-body">';
            $flower_contacts = $flower_contacts . '<table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                          <th scope="col">Name</th>
                                                          <th scope="col">Phone</th>
                                                          <th scope="col">Email</th>
                                                          <th scope="col">Gifted</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>';
            $flower_contacts = $flower_contacts . getFiresGifted($connection, $lotus_id, $next_water);
            $flower_contacts = $flower_contacts . getOtherFires($connection, $lotus_id, $next_water);
            $flower_contacts = $flower_contacts . '</tbody>
                                            </table></div></div></div>';
        }
        $i++;
    }
    $flower_contacts = $flower_contacts . '</div>';
    return $flower_contacts;
}



function getLastGift($connection, $tlf_id) {
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE tlf_id = '{$tlf_id}' AND view=0";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    // $flower_contacts = '<div class="accordion">';
    $flower_contacts="";
    $i=51;

     global $harvest_front,$harvest_back;
    while($found_user = mysqli_fetch_array($resultSet)) {
        $id = $found_user['id'];
        $lotus_id = $found_user['lotus_id'];
        $air_id = $found_user['air_id'];
        $earth_id = $found_user['earth_id'];
        $water_id = $found_user['water_id'];
        $fireDate = $found_user['fireDate'];
        $formatted_fireDate = date("m/d/Y", $fireDate);
        
        date_default_timezone_set('America/Los_Angeles');
        $today = strtotime(date("m/d/Y"));
        $mod_fireDate = $fireDate - 7*24*60*60;
        $diff = $today - $mod_fireDate;
        $days = round($diff /60/60/24);
        $weeks = ($days / 7);
        $harvests = ceil($weeks/4)-1;
        $harvest = 4*7*24*60*60;
        $next_water = $mod_fireDate + ($harvests * $harvest);
        $water = date("m/d/Y", $next_water);
        
        if($harvests > 0) {
            $flower_contacts.='<div class="col-lg-4 mb-4">
                                    <div class="flip-card top-to-bottom">
                                        <div class="flip-card-front dark" data-height-xl="200" style="background-image: url(\''.$harvest_front.'\')">
                                        <div class="flip-card-inner">
                                                <div class="card bg-transparent border-0">
                                                    <div class="card-body">
                                                        <h3 class="card-title mb-0">Tree ID #' . $id . '</h3>
                                                        <span class="font-italic">Last Harvest : ' . $water .  ' </span>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flip-card-back" data-height-xl="200" style="background-image: url(\''.$harvest_back.'\')">
                                            <div class="flip-card-inner">
                                               <h3 class="mb-2 text-white">Last Harvest</h3>
                                               <p class="message">'.$harvestmessage.'</p>
                                               <span class="font-italic"> ' . $water .  '</span><br />
                                                <button class="btn profile-btn" data-toggle="modal" data-target="#myModal">view Tree</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                               
                

        
        }
        $i++;
    }
    // $flower_contacts = $flower_contacts . '</div>';
    return $flower_contacts;
}

function getHoles($connection) {
    $start_date = "May 10th, 2020";
    $date_formatted = strtotime($start_date);
    
    $gen = "103";
    $potential = "11";
    
    date_default_timezone_set('America/Los_Angeles');
    $today = strtotime(date("m/d/Y"));
    $diff = $today - $date_formatted;
    $weeks = ceil($diff /60/60/24/7);
    
    $coming_gen = $weeks + 103;
    $fire_gens = array();
    while($coming_gen > 100) {
              $fire_gens[] = $coming_gen;
              $coming_gen = $coming_gen-4;
          }
    
    if(in_array('101',$fire_gens)){$first_style = 'class="table-warning"';}else{$first_style ='';}
    if(in_array('102',$fire_gens)){$second_style = 'class="table-warning"';}else{$second_style ='';}
    
    $holes_status = '<div class="card-body">
                        <table class="table table-striped">
                                <thead>
                                    <tr>
                                      <th scope="col">Date</th>
                                      <th scope="col">Gen</th>
                                      <th scope="col">Potential</th>
                                      <th scope="col">Actual</th>
                                      <th scope="col">Holes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ' . $first_style . '>
                                        <td>04/26/2020</td>
                                        <td>101</td>
                                        <td>2</td>
                                        <td>2</td>
                                        <td>0</td>
                                    </tr>
                                    <tr ' . $second_style . '>
                                        <td>05/03/2020</td>
                                        <td>102</td>
                                        <td>4</td>
                                        <td>4</td>
                                        <td>0</td>
                                    </tr>';
    
    $holes_detail = "<h2>Holes List by Generation</h2>";
    $total_pot = "";
    $total_actual = "";
    for($i=0; $i<$weeks; $i++) {
        $date = date("m/d/Y", $date_formatted);
        $query = "SELECT *";
        $query .= "FROM users ";
        $query .= "WHERE gen = '{$gen}'";
        $resultSet = mysqli_query($connection, $query);
        confirm_query($resultSet, $connection);
        
        $actual = mysqli_num_rows($resultSet);
        $holes = $potential - $actual;
        
        if(in_array($gen, $fire_gens)) {
            $line_style = 'class="table-warning"';
        } else {
            $line_style = '';
        }

        $holes_status = $holes_status . '<tr ' . $line_style . '>
                                            <td>' . $date . '</td>
                                            <td>' . $gen . '</td>
                                            <td>' . $potential . '</td>
                                            <td>' . $actual . '</td>
                                            <td>' . $holes . '</td>
                                        </tr>';
        $date_formatted = $date_formatted + (60*60*24*7);
        $flowers = findHoles($connection, $gen);
        $total_pot = $total_pot + $potential;
        $total_actual = $total_actual + $actual;
        $potential = $potential * 2;
        
        $holes_detail = $holes_detail . '<h3 class="generation">Generation ' . $gen . '</h3>
                                            <div class="card-body">
                        <table class="table table-striped">
                                <thead>
                                    <tr>
                                      <th scope="col">ID</th>
                                      <th scope="col">Name</th>
                                      <th scope="col">Holes</th>
                                    </tr>
                                </thead>';
        $holes_detail = $holes_detail . $flowers;
        $gen++;
    }
    $total_pot = $total_pot + 6;
    $total_actual = $total_actual + 6;
    $total_holes = $total_pot - $total_actual;
    $date = date("m/d/Y", $date_formatted);
    $holes_status = $holes_status . '<tr class="table-warning">
                                            <td>' . $date . '</td>
                                            <td>' . $gen . '</td>
                                            <td>' . $potential . '</td>
                                            <td>???</td>
                                            <td>???</td>
                                        </tr>';
    
    $holes_status = $holes_status . '</tbody></table></div>';
    $holes_status = $holes_status . '<div class="fire_note">highlighted Gens are currently in Fire week.</div>';
    $summary = '<div class="col d-flex justify-content-center">
                    <div class="card .mx-auto" style="width: 38rem;">
                      <div class="card-header bg-dark text-white">
                        TLF Status Totals 
                        </div>
                      <ul class="list-group list-group-flush">
                        <li class="list-group-item">Total Potential Positions: <span class="badge badge-pill badge-danger">' . $total_pot . '</span></li>
                        <li class="list-group-item">Total Actual Positions: <span class="badge badge-pill badge-danger">' . $total_actual . '</span></li>
                        <li class="list-group-item">Total Open Holes: <span class="badge badge-danger">' . $total_holes . '</span></li>
                        <a href="#" class="btn btn-primary"></a>
                      </ul>
                      </div>
                    </div>';
    $holes_status = $holes_status . $summary;
    $holes_status = $holes_status . $holes_detail;
    return $holes_status;
}

function findHoles($connection, $gen) {
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE gen = '{$gen}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    $holey_flowers = "";
    while($found_user = mysqli_fetch_array($resultSet)) {
        $lotus_id = $found_user['lotus_id'];
        $id = $found_user['id'];
        $name = $found_user['first_name'] . " " . $found_user['last_name'];
        
        $query2 = "SELECT *";
        $query2 .= "FROM users ";
        $query2 .= "WHERE air_id = '{$lotus_id}'";
        $resultSet2 = mysqli_query($connection, $query2);
        confirm_query($resultSet2, $connection);
        
        if(mysqli_num_rows($resultSet2) < 2) {
            $num = mysqli_num_rows($resultSet2);
            if($num == 0){$num = 2;}
            $holey_flowers = $holey_flowers . '<tr>
                                                <td> #' . $id . '</td>
                                                <td>' . $name . '</td>
                                                <td>' . $num . '</td>
                                            </tr>';
        }
    }
    return $holey_flowers;
}

function getInviteeCount($connection, $tlf_id) {
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE referrer = '{$tlf_id}' && flower = 1";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    $inviteeCount = mysqli_num_rows($resultSet);
    
    return $inviteeCount;
}

function messageNewFire($connection, $phone, $first_name, $water_lotus_id, $fire_date) {
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE lotus_id = '{$water_lotus_id}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    while($found_water = mysqli_fetch_array($resultSet)) {
        $water_name = $found_water['first_name'] . " " . $found_water['last_name'];
        $water_phone = $found_water['phone'];
        $water_tlf_id = $found_water['tlf_id'];
    }
    
    $query2 = "SELECT *";
    $query2 .= "FROM gift_methods ";
    $query2 .= "WHERE tlf_id = '{$water_tlf_id}'";
    $resultSet2 = mysqli_query($connection, $query2);
    confirm_query($resultSet2, $connection);
    
    while($found_method = mysqli_fetch_array($resultSet2)) {
        $method = $found_method['gift_method'];
        $method_username = $found_method['method_username'];
    }
    $formatted_fire_date = date("m/d/Y", $fire_date);
    $phone_number = preg_replace('/[^0-9]/','',$phone);
             if(strlen($phone_number) > 10) { //apply proper formatting to recipient's number - 11+ characters
                    $countryCode = substr($phone_number, 0, strlen($phone_number)-10);
                    $areaCode = substr($phone_number, -10, 3);
                    $nextThree = substr($phone_number, -7, 3);
                    $lastFour = substr($phone_number, -4, 4);

                     $phone_number = '+' . $countryCode . $areaCode . $nextThree . $lastFour;
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

                    $phone_number = $nextThree . $lastFour;
                }
    $params = '/messages';
    $body = 'TLF Support 
    Congatulations '. $first_name . ' on your new flower!
    Your Seed date is ' . $formatted_fire_date . '
    Your Tree is:
    ' . $water_name . ' - ' . $water_phone . '
    Gift Method: ' . $method . '
    Gift Username: ' . $method_username;
    $media = NULL;

     $host = AMB_HOST . AMB_USERID . $params;
     $fields = array('from' => AMB_PHONE, 'to' => $phone_number, 'text' => $body, 'media' => $media);
     $json_fields = json_encode($fields);
     $headers = array(
            'Content-Type:application/json',
            'Authorization: Basic '. base64_encode(AMB_USERNAME . ":" . AMB_PASSWORD) 
        );

        $curl = curl_init($host);
        curl_setopt_array($curl, array( 
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_HEADER => 0,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $json_fields,
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_RETURNTRANSFER => TRUE
            ));

        $return = curl_exec($curl);
        curl_close($curl); 

}

function messageWater($connection, $phone, $name, $water_lotus_id, $fire_date) {
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE lotus_id = '{$water_lotus_id}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    while($found_water = mysqli_fetch_array($resultSet)) {
        $water_name = $found_water['first_name'];
        $water_phone = $found_water['phone'];
        $water_tlf_id = $found_water['tlf_id'];
        $id = $found_water['id'];
    }
    $formatted_fire_date = date("m/d/Y", $fire_date);
    $phone_number = preg_replace('/[^0-9]/','',$phone);
             if(strlen($phone_number) > 10) { //apply proper formatting to recipient's number - 11+ characters
                    $countryCode = substr($phone_number, 0, strlen($phone_number)-10);
                    $areaCode = substr($phone_number, -10, 3);
                    $nextThree = substr($phone_number, -7, 3);
                    $lastFour = substr($phone_number, -4, 4);

                     $phone_number = '+' . $countryCode . $areaCode . $nextThree . $lastFour;
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

                    $phone_number = $nextThree . $lastFour;
                }
    $params = '/messages';
    $body = 'TLF Support 
    Congatulations '. $water_name . '!
    Your Tree ID# ' . $id . ' has a new Seed. 
    ' . $name . ' - ' . $phone_number . '
    Fire Date is ' . $formatted_fire_date;
    $media = NULL;

     $host = AMB_HOST . AMB_USERID . $params;
     $fields = array('from' => AMB_PHONE, 'to' => $phone_number, 'text' => $body, 'media' => $media);
     $json_fields = json_encode($fields);
     $headers = array(
            'Content-Type:application/json',
            'Authorization: Basic '. base64_encode(AMB_USERNAME . ":" . AMB_PASSWORD) 
        );

        $curl = curl_init($host);
        curl_setopt_array($curl, array( 
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_HEADER => 0,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $json_fields,
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_RETURNTRANSFER => TRUE
            ));

        $return = curl_exec($curl);
        curl_close($curl); 

}

function getFlowerContacts($connection, $tlf_id) {
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE tlf_id = '{$tlf_id}' AND view = 0";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);

    global $family_front,$family_back;
    
    // $flower_contacts = '<div class="accordion">';
    $flower_contacts = '';
    $i=1;
    while($found_user = mysqli_fetch_array($resultSet)) {
        $id = $found_user['id'];
        $lotus_id = $found_user['lotus_id'];
        if($lotus_id == "") {
             $air_id = "none";
             $earth_id = "none";
             $water_id = "none";
        } else {
            $air_id = $found_user['air_id'];
            $earth_id = $found_user['earth_id'];
            $water_id = $found_user['water_id'];
        }
        $fireDate = $found_user['fireDate'];
        $formatted_fireDate = date("m/d/Y", $fireDate);
        
      $flower_contacts.='<div class="col-lg-4 mb-4">
                         <div class="flip-card top-to-bottom">
                           <div class="flip-card-front dark" data-height-xl="200" style="background-image: url(\''.$family_front.'\');">
                                            <div class="flip-card-inner">

                                                <div class="card bg-transparent border-0">
                                                    <div class="card-body">
                                                        <h3 class="card-title mb-0">Flower ID #' . $id . ' </h3>
                                                        <span class="font-italic">Fire Date : ' . $formatted_fireDate . '</span>
                                                       
                                                    </div>
                                                </div>
                                            </div>
                  </div>
                
                <div class="flip-card-back" data-height-xl="200" style="background-image: url(\''.$family_back.'\');"><div class="flip-card-inner">
                                                <p class="mb-2 text-white message">'.$message.'</p>
                                                <h3 class="mb-2 text-white">My Family</h3>
                                                <button type="button" class="btn btn-outline-light mt-2 btn_view_detail_family" data-flower_id="'.$id.'" data-lotus_id="'.$lotus_id.'" data-water_id="'.$water_id.'"data-earth_id="'.$earth_id.'" data-air_id="'.$air_id.'" aria-expanded="true"  <button class="btn profile-btn" data-toggle="modal" data-target="#myModal">view Tree</button>

                                            </div>
                                       </div>

                        </div>
                    </div>';
            
        $i++;
    }
    // $flower_contacts = $flower_contacts . '</div>';
    return $flower_contacts;
}


function getFireCount($connection, $lotus_id) {
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE water_id = '{$lotus_id}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    $count = mysqli_num_rows($resultSet);
    return $count;
}

function getRefCount($connection, $tlf_id, $water_id) {
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE water_id = '{$water_id}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    $referral_count = 0;
    while($found_fire = mysqli_fetch_array($resultSet)) {
        $referrer = $found_fire['referrer'];
        if($referrer == $tlf_id) {
            $referral_count++;
        }
    }
    return $referral_count;
}

function getBorrowedReferrals($connection, $tlf_id, $lotus_id) {
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE air_id = '{$lotus_id}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    $referrals = "";
    while($found_earth = mysqli_fetch_array($resultSet)) {
        $referrer = $found_earth['referrer'];
        $referrer_name = $found_earth['referrer_name'];
        if($referrer != $tlf_id) {
            $referrals = $referrals . '<li class="list-group-item">Borrowed referral from: <span id="infoTable">' . $referrer_name . '</span></li>';
        }
    }
    return $referrals;
}

function getBoardStart($connection, $water_id) {
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE lotus_id = '{$water_id}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    while($found_water = mysqli_fetch_array($resultSet)) {
        $date = $found_water['creation_date_time'];
    }
    $old_date = date($date);
    $old_date_timestamp = strtotime($old_date);
    $new_date = date('m-d-Y', $old_date_timestamp);
    return $new_date;
}

function getRoots($connection, $lotus_id) {
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE lotus_id = '{$lotus_id}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    while($found_user = mysqli_fetch_array($resultSet)) {
        $gen = $found_user['gen'];
        $upline = $found_user['air_id'];
        $pre_date = $found_user['fireDate'];
        $fireDate = date("m/d/Y", $pre_date);
    }
    $gen_diff = $gen - '101';
    
    $flower_det = '<div class="col d-flex justify-content-center">
                    <div class="card .mx-auto" style="width: 38rem;">
                      <div class="card-header bg-dark text-white">
                        Seed Date: ' . $fireDate . ' Generation: ' . $gen . '</div>
                      <ul class="list-group list-group-flush">';
    
    for($i=0; $i<$gen_diff; $i++) {
        $query = "SELECT *";
        $query .= "FROM users ";
        $query .= "WHERE lotus_id = '{$upline}'";
        $resultSet = mysqli_query($connection, $query);
        confirm_query($resultSet, $connection);
        
        while($found_user = mysqli_fetch_array($resultSet)) {
            $upline = $found_user['air_id'];
            $pre_date = $found_user['fireDate'];
            $fireDate = date("m/d/Y", $pre_date);
            $gen = $found_user['gen'];
            $name = $found_user['first_name'] . ' ' . $found_user['last_name'];
            $id = $found_user['id'];
        }
        $flower_det = $flower_det . '<li class="list-group-item">#' . $id . ' - ' . $name . ' - Generation: ' . $gen . '</li>';
    }
    $flower_det = $flower_det . '<a href="#" class="btn btn-primary"    onclick="window.location.reload();">Back to tree list</a>
                      </ul>
                      </div>
                    </div>';
    return $flower_det;
}

                      '
                        <li class="list-group-item">Tree Name: ' . $water_name . '</li>
                        <li class="list-group-item">Tree Gift Method: ' . $water_method . '</li>
                        <li class="list-group-item">Open positions for ' . $sunday . '<span class="badge badge-pill badge-danger">' . $open_petals . '</span></li>
                        <li class="list-group-item">Existing Seeds for ' . $sunday . '<span class="badge badge-pill badge-danger">' . $next_seeds . '</span></li>
                        <li class="list-group-item">Needed Seeds for ' . $sunday . '<span class="badge badge-pill badge-danger">' . $needed_seeds . '</span></li>
                        <a href="#" class="btn btn-primary" onclick="window.location.reload();">Back to my flowers</a>
                      </ul>
                      </div>
                    </div>';

function getSeeds($connection, $tlf_id) {
    $query = sprintf("SELECT * FROM users WHERE referrer='%s' && flower=0 ORDER BY fireDate ASC", 
                mysqli_real_escape_string($connection, $tlf_id));

                $result = mysqli_query($connection, $query);
    
                $these_seeds = "";
                if (mysqli_num_rows($result) > 0) {
                        //User has seeds
                        $num = 1;
                        while($found_seeds = mysqli_fetch_array($result)){
                            $seed_name = $found_seeds['first_name'] . " " . $found_seeds['last_name'];
                            $fireDate = $found_seeds['fireDate'];
                            $formatted_fireDate = date("m/d/Y", $fireDate);
                            $seed_tlf_id = $found_seeds['tlf_id'];  
                                                                                         
                            $query2 = sprintf("SELECT * FROM milestones WHERE tlf_id='%s'", 
                            mysqli_real_escape_string($connection, $seed_tlf_id));

                            $result2 = mysqli_query($connection, $query2); 
                            while($found_milestone = mysqli_fetch_array($result2)) {
                                $percentage = $found_milestone['percentage'];
                            }
                            $these_seeds = $these_seeds . '<button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#new-seed" disabled><span class="full-name">#' . $num . ": " . $seed_name . "</span>  Exp. Seed Date: " . $formatted_fireDate . '<span class="counts">' . $percentage . '%</span></button>';
                            $num++;
                        }
                } else {
                    $these_seeds = $these_seeds . '<button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#new-seed" disabled><span class="full-name">No Registered Seeds</span></button>';
                }
    return $these_seeds;
}

function getPetalCount($connection, $lotus_id) {
    $petal_count = 0;
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE air_id = '{$lotus_id}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    $petal_count = $petal_count + mysqli_num_rows($resultSet);
    
    $query2 = "SELECT *";
    $query2 .= "FROM users ";
    $query2 .= "WHERE earth_id = '{$lotus_id}'";
    $resultSet2 = mysqli_query($connection, $query2);
    confirm_query($resultSet2, $connection);
    $petal_count = $petal_count + mysqli_num_rows($resultSet2);
    
    $query3 = "SELECT *";
    $query3 .= "FROM users ";
    $query3 .= "WHERE water_id = '{$lotus_id}'";
    $resultSet3 = mysqli_query($connection, $query3);
    confirm_query($resultSet3, $connection);
    $petal_count = $petal_count + mysqli_num_rows($resultSet3);
    
    return $petal_count;
}

function getFocusName($connection, $lotus_id) {
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE lotus_id = '{$lotus_id}' LIMIT 1";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    $found_focus = mysqli_fetch_array($resultSet);
    $name = $found_focus['display_name'];
    
    return $name;
}

function getTLFID($connection, $first_name, $last_name) {
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE first_name = '{$first_name}' AND last_name = '{$last_name}' ";
    $query .= "LIMIT 1";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    if(mysqli_num_rows($resultSet) == 1) {
        $found_user = mysqli_fetch_array($resultSet);
        $tlf_id = $found_user['tlf_id'];
    } else {
        $tlf_id = uniqid();
    }
    return $tlf_id;
}

function getInviter_tlf($connection, $inviter_email) {
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE email = '{$inviter_email}' ";
    $query .= "LIMIT 1";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    if(mysqli_num_rows($resultSet) == 0) {
        $inviterTLF = "";
    } else {
       while($found_email = mysqli_fetch_array($resultSet)) {
            $inviterTLF = $found_email['tlf_id'];
        } 
    }
    return $inviterTLF;
}

function getEcoCount($connection, $lotus_id) {
    $eco_count = 0;
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE air_id = '{$lotus_id}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    $eco_count = $eco_count + mysqli_num_rows($resultSet);
    
    $query2 = "SELECT *";
    $query2 .= "FROM users ";
    $query2 .= "WHERE earth_id = '{$lotus_id}'";
    $resultSet2 = mysqli_query($connection, $query2);
    confirm_query($resultSet2, $connection);
    $eco_count = $eco_count + mysqli_num_rows($resultSet2);
    
    $query3 = "SELECT *";
    $query3 .= "FROM users ";
    $query3 .= "WHERE water_id = '{$lotus_id}'";
    $resultSet3 = mysqli_query($connection, $query3);
    confirm_query($resultSet3, $connection);
    $eco_count = $eco_count + mysqli_num_rows($resultSet3);
    
    while($these_fires = mysqli_fetch_array($resultSet3)) {
        $fire_lotus_id = $these_fires['lotus_id'];
        $eco_count = $eco_count + getPetalCount($connection, $fire_lotus_id);
    }
    
    return $eco_count;
}

function getFireDate($connection, $lotus_id) {
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE lotus_id = '{$lotus_id}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    while($found_flower = mysqli_fetch_array($resultSet)) {
        $fireDate = $found_flower['fireDate'];
        $formatted_fireDate = date("m/d/Y", $fireDate);
    }
    return $formatted_fireDate;
}

function getSowDate($connection, $lotus_id) {
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE lotus_id = '{$lotus_id}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    while($found_flower = mysqli_fetch_array($resultSet)) {
        $sowDate = $found_flower['sowDate'];
        if($sowDate == "") {
            $formatted_sowDate = "";
        } else {
            $formatted_sowDate = date("m/d/Y", $sowDate);
        }
    }
    return $formatted_sowDate;
}

function getWaterName($connection, $lotus_id) {
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE lotus_id = '{$lotus_id}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    while($found_flower = mysqli_fetch_array($resultSet)) {
        $water_id = $found_flower['water_id'];
        $query2 = "SELECT *";
        $query2 .= "FROM users ";
        $query2 .= "WHERE lotus_id = '{$water_id}'";
        $resultSet2 = mysqli_query($connection, $query2);
        confirm_query($resultSet2, $connection);
        
        while($found_water = mysqli_fetch_array($resultSet2)) {
            $name = $found_water['first_name'] . " " . $found_water['last_name'];
        }
        
    }
    return $name;
}

function getUserName($connection, $lotus_id) {
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE lotus_id = '{$lotus_id}' LIMIT 1";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    if(mysqli_num_rows($resultSet) == 0) {
        $name = "Not Applicable";
    } else {
        $found_user = mysqli_fetch_array($resultSet);
        $name = $found_user['first_name'] . " " . $found_user['last_name'];
    }
    return $name;
}

function getUserPhone($connection, $lotus_id) {
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE lotus_id = '{$lotus_id}' LIMIT 1";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    if(mysqli_num_rows($resultSet) == 0) {
        $phone = "Not Applicable";
    } else {
        $found_user = mysqli_fetch_array($resultSet);
        $phone = $found_user['phone'];
    }
    return $phone;
}

function getUserEmail($connection, $lotus_id) {
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE lotus_id = '{$lotus_id}' LIMIT 1";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    if(mysqli_num_rows($resultSet) == 0) {
        $email = "Not Applicable";
    } else {
       $found_user = mysqli_fetch_array($resultSet);
       $email = $found_user['email'];
    }
    return $email;
}

function getWaterMethod($connection, $lotus_id) {
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE lotus_id = '{$lotus_id}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    while($found_flower = mysqli_fetch_array($resultSet)) {
        $water_id = $found_flower['water_id'];
        $query = "SELECT *";
        $query .= "FROM users ";
        $query .= "WHERE lotus_id = '{$water_id}'";
        $resultSet = mysqli_query($connection, $query);
        confirm_query($resultSet, $connection);
        
        while($found_water = mysqli_fetch_array($resultSet)) {
            $water_tlf = $found_water['tlf_id'];
        }
        $query2 = "SELECT *";
        $query2 .= "FROM gift_methods ";
        $query2 .= "WHERE tlf_id = '{$water_tlf}'";
        $resultSet2 = mysqli_query($connection, $query2);
        confirm_query($resultSet2, $connection);
        
        while($found_method = mysqli_fetch_array($resultSet2)) {
            $method = $found_method['gift_method'] . " - " . $found_method['method_username'];
        }
        
    }
    return $method;
}

function getWaterMethod2($connection, $water_id) {
        $query = "SELECT *";
        $query .= "FROM users ";
        $query .= "WHERE lotus_id = '{$water_id}'";
        $resultSet = mysqli_query($connection, $query);
        confirm_query($resultSet, $connection);
        
        while($found_water = mysqli_fetch_array($resultSet)) {
            $water_tlf = $found_water['tlf_id'];
        }
        $query2 = "SELECT *";
        $query2 .= "FROM gift_methods ";
        $query2 .= "WHERE tlf_id = '{$water_tlf}'";
        $resultSet2 = mysqli_query($connection, $query2);
        confirm_query($resultSet2, $connection);
        
        while($found_method = mysqli_fetch_array($resultSet2)) {
            $method = $found_method['gift_method'] . " - " . $found_method['method_username'];
        }
        
    return $method;
}

function getOpenPetals($connection, $lotus_id) {
    $query = "SELECT * ";
    $query .= "FROM users ";
    $query .= "WHERE lotus_id = '{$lotus_id}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    while($found_flower = mysqli_fetch_array($resultSet)) {
        $fireDate = $found_flower['fireDate'];
    }
    $sunday = strtotime("next Sunday");
    $diff = $sunday - $fireDate;
    $days = $diff / (60*60*7*24);
    $petals = pow(2,$days);
    
    return $petals;
}

function getNextSeeds($connection, $tlf_id) {
    $sunday = strtotime("next Sunday");
    $seed_count = 0;
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE referrer = '{$tlf_id}' AND fireDate = '{$sunday}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);

    $count = $count + mysqli_num_rows($resultSet);

    return $count;
}

function getNextSeedsAll($connection, $lotus_id, $tlf_id) {
    $seed_count = 0;
    $seed_count = $seed_count + getNextSeeds($connection, $tlf_id);
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE air_id = '{$lotus_id}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    if(mysqli_num_rows($resultSet) > 0) {
        while($found_earth = mysqli_fetch_array($resultSet)) {
        $earth_lotus_id = $found_earth['lotus_id'];
        $earth_tlf_id = $found_earth['tlf_id'];
        $seed_count = $seed_count + getNextSeeds($connection, $earth_tlf_id);
            $query2 = "SELECT *";
            $query2 .= "FROM users ";
            $query2 .= "WHERE air_id = '{$earth_lotus_id}'";
            $resultSet2 = mysqli_query($connection, $query2);
            confirm_query($resultSet2, $connection);
            
            if(mysqli_num_rows($resultSet2) > 0) {
                while($found_air = mysqli_fetch_array($resultSet2)) {
                $air_lotus_id = $found_earth['lotus_id'];
                $air_tlf_id = $found_earth['tlf_id'];
                $seed_count = $seed_count + getNextSeeds($connection, $air_tlf_id);
                    $query3 = "SELECT *";
                    $query3 .= "FROM users ";
                    $query3 .= "WHERE air_id = '{$air_lotus_id}'";
                    $resultSet3 = mysqli_query($connection, $query3);
                    confirm_query($resultSet3, $connection);
                    
                    if(mysqli_num_rows($resultSet3) > 0) {
                        while($found_fire = mysqli_fetch_array($resultSet3)) {
                        $fire_lotus_id = $found_fire['lotus_id'];
                        $fire_tlf_id = $found_fire['tlf_id'];
                        $seed_count = $seed_count + getNextSeeds($connection, $fire_tlf_id);
                            $query4 = "SELECT *";
                            $query4 .= "FROM users ";
                            $query4 .= "WHERE air_id = '{$fire_lotus_id}'";
                            $resultSet4 = mysqli_query($connection, $query4);
                            confirm_query($resultSet4, $connection);
                            
                            if(mysqli_num_rows($resultSet4) > 0) {
                                while($found_f_earth = mysqli_fetch_array($resultSet4)) {
                                $f_earth_lotus_id = $found_f_earth['lotus_id'];
                                $f_earth_tlf_id = $found_f_earth['tlf_id'];
                                $seed_count = $seed_count + getNextSeeds($connection, $f_earth_tlf_id);
                                    $query5 = "SELECT *";
                                    $query5 .= "FROM users ";
                                    $query5 .= "WHERE air_id = '{$f_earth_lotus_id}'";
                                    $resultSet5 = mysqli_query($connection, $query5);
                                    confirm_query($resultSet5, $connection);

                                    if(mysqli_num_rows($resultSet5) > 0) {
                                        while($found_f_air = mysqli_fetch_array($resultSet5)) {
                                        $f_air_lotus_id = $found_f_air['lotus_id'];
                                        $f_air_tlf_id = $found_f_air['tlf_id'];
                                        $seed_count = $seed_count + getNextSeeds($connection, $f_air_tlf_id);
                                            $query6 = "SELECT *";
                                            $query6 .= "FROM users ";
                                            $query6 .= "WHERE air_id = '{$f_air_lotus_id}'";
                                            $resultSet6 = mysqli_query($connection, $query6);
                                            confirm_query($resultSet6, $connection);

                                            if(mysqli_num_rows($resultSet6) > 0) {
                                                while($found_f_fire = mysqli_fetch_array($resultSet6)) {
                                                $f_fire_lotus_id = $found_f_fire['lotus_id'];
                                                $f_fire_tlf_id = $found_f_fire['tlf_id'];
                                                $seed_count = $seed_count + getNextSeeds($connection, $f_fire_tlf_id);
                                                }
                                            }//no f-fires
                                        }
                                    }//no f-airs
                                }
                            }//no f-earths
                        }
                    }//no fires   
                }
            }//no airs
        }
    }//no earths
    return $seed_count;
}

function getEcoCount2($connection, $lotus_id) {
    $eco_count = 0;
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE air_id = '{$lotus_id}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    if(mysqli_num_rows($resultSet) > 0){
        while($petal_air = mysqli_fetch_array($resultSet)){
           $lotus_id_air = $petal_air['lotus_id'];
           $petal_count_air = getPetalCount($connection, $lotus_id_air);
           $eco_count = $eco_count + $petal_count_air + 1; 
        }
    }
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE earth_id = '{$lotus_id}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    if(mysqli_num_rows($resultSet) > 0){
        while($petal_earth = mysqli_fetch_array($resultSet)){
           $lotus_id_earth = $petal_earth['lotus_id'];
           $petal_count_earth = getPetalCount($connection, $lotus_id_earth);
           $eco_count = $eco_count + $petal_count_earth; 
        }
    }
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE water_id = '{$lotus_id}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    if(mysqli_num_rows($resultSet) > 0){
        while($petal_water = mysqli_fetch_array($resultSet)){
           $lotus_id_water = $petal_water['lotus_id'];
           $petal_count_water = getPetalCount($connection, $lotus_id_water);
           $eco_count = $eco_count + $petal_count_water; 
        }
    }
    
    return $eco_count;
}

function welcomeEmail ($email_address) {
    //need css
        $to      = $email_address;
		$subject = 'WELCOME to The Eden Project!';
        $message = '<p>Welcome Chain Breaker!!</p>' .  
				   '<p>Thank you for seeing the vision of our <strong>Breaking Chains Private Cooperative.</strong>  You have decided to take part in an initiative and movement that is going to change the trajectory of your family’s lives.  You have joined a community of like-minded individuals that supports, empowers and motivates one another to go after their goals, dreams and aspirations as we create Black Wall Street not just across city blocks but across NATIONS!!  </p>' . 
                   '<p>As a part of our Community, you will now have access to the following:</p>'  .
                   '<ul style="margin-left:20px; font-weight:bold;">' . 
                    '<li>Breaking Chains Private Cooperative Referral Program</li>' .
                    '<li>Access to our Co-Op Business Directory</li>' .
                    '<li>Make Your Money Monday</li>' .
                    '<li>Wealth Wednesday</li>' .
                    '<li>Faith Friday</li>' .
                    '<li>Co-Op Talks </li>' .
                    '<li>B.R.I.D.G.E.S. (Bringing Real Investments During Global Economic Seasons)</li>' .
                    '<li>BEES (Black Economic Empowerment System)</li>' .
                    '<li>The Eden Project</li>' .
                    '<li>Tracking Software (Coming Soon)</li>' .
                    '<li>And Much Much More</li>' .
                   '</ul>' . 
                   '<p>My hope is that this Initiative blesses you and your family and helps you to create generational wealth! </p>' .
                   '<p>Blessings Upon Blessings,</p>' .
				   '<p>Mary L. Boyde</p>' .
				   '<p>Founder</p>' .
				   '<p style="color:grey;">Copyright Notice.  All materials contained within this document are protected by United States copyright law and may not be reproduced, distributed, transmitted, displayed, published, altered or broadcasted without the prior, express written permission of Breaking Chains Private Cooperative, LLC.  ©Copyright 2020 Breaking Chains Private Cooperative, LLC
                    </p></body></html>';

///////////////////////////////////////////////////////////////////////////////////

		$mail = new PHPMailer();

		$mail->IsSMTP(); // set mailer to use SMTP
		$mail->Host = "smtpout.secureserver.net";  // specify main and backup server
		$mail->SMTPAuth = true;     // turn on SMTP authentication
		$mail->Username = "james@aliasmobile.com";  // SMTP username
		$mail->Password = "james"; // SMTP password

		$mail->setFrom("support@breakingchainsprivatecoop.com");
		$mail->FromName = "The Eden Project Support";
		$mail->AddAddress($to);                  // name is optional
		$mail->AddReplyTo("support@breakingchainsprivatecoop.com", "The Eden Project Support");
		$mail->addBCC("james.misa@thelotus.online");

		$mail->WordWrap = 50;                                 // set word wrap to 50 characters
		$mail->IsHTML(true);                                  // set email format to HTML

		$mail->Subject = $subject;
		$mail->Body    = $message;
		$mail->AltBody = $message;
    
        $mail->SMTPOptions = array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            )
        );

		if(!$mail->Send())
		{
		   $msg = "Message could not be sent.";
		   $msg += "Mailer Error: " . $mail->ErrorInfo;
		   $data = array('status'=>1, 'msg'=>$msg);
		   $json = json_encode($data);
		   echo $json;
		   exit;
		}

		   $msg = "Message has been sent.";
		   $data = array('status'=>4, 'msg'=>$msg);
		   $json = json_encode($data);
		   //echo $json;

}

function welcomeEmailGarden ($email_address, $water, $water_phone, $water_email, $water_method, $sow_date) {
    //need css
        $to      = $email_address;
		$subject = 'WELCOME to The Eden Project!';
        $message = '<html><body style="margin:20px; max-width:700px;"><p>Welcome                Chain Breaker!!</p>' .  
				   '<p>Thank you for seeing the vision of our <strong>Breaking Chains Private Cooperative</strong> and participating in The Eden Project. The Eden Project is the financial support arm for our members. </p>' . 
                   '<p>Remember, there are 2 things that we ask:</p>'  .
                   '<ol style="margin-left:20px; font-weight:bold;">' . 
                    '<li>Sow your support to your “Tree of Life”</li>' .
                    '<li>Have two (2) like-minded, trustworthy friends or family accept the invitation to join theCooperative and The Eden Project.</li>' .
                   '</ol>' . 
                   '<p>Do not spoil it for them. You want them to see and hear it just like you did. So, don’t try to explain it. Let the presentation give the information for you. <mark>DO NOT POST THIS ON SOCIAL MEDIA!!! THIS GROUP CONSISTS OF FRIENDS AND FAMILY ONLY THAT HAVE BEEN PERSONALLY INVITED!!</mark> </p>' .
                   '<p><strong>You will sow your support to the following:</p>' .
                   '<p style="margin-left:20px;">Name: ' . $water . '</p>' .
                   '<p style="margin-left:20px;">Number: ' . $water_phone . '</p>' .
                   '<p style="margin-left:20px;">Email: ' . $water_email . '</p>' .
                   '<p style="margin-left:20px;">Support Method: ' . $water_method . '</p>' .
                   '<p style="margin-left:20px;">Date to Sow: ' . $sow_date . '</strong></p>' .
                   '<p>Blessings Upon Blessings,</p>' .
                   '<p><strong>Next Steps:</strong></p>' .
                    '<ol style="margin-left:20px;">' . 
                    '<li>Reply to this email with your preferred support method (i.e Zelle, CashApp, Paypal,Venmo, Xoom) and the information associated with that method.</li>' .
                    '<li>As soon as they are identified, send your referrals the Future Chain Breaker Welcomeemail. Don’t forget to add your referral link.</li>' .
                    '<li>Also send me their names, numbers, email addresses and support methods andsupporting information of your two (2) Seeds.</li>' .
                    '<li>The Thursday prior to your entry into Eden, your “Tree of Life” will send you a textand/or email to welcome you, introduce him/herself, and reiterate the method in whichhe/she would like to be supported. <mark>WHEN YOU RECEIVE THESE TEXTS and/or EMAILS,PLEASE REPLY TO THEM.</mark></li>' .
                    '<li><strong>JOIN THE EDEN PROJECT BY SOWING YOUR SEED SUPPORT TO YOUR TREE OF LIFE BY12:00 PM!!</strong></li>' .
                    '<li>Upon receipt of your support, your “Tree of Life” will send you a thank you text as well as let you know who your two (2) seeds will support the following week.</li>' .
                   '</ol>' . 
				   '<p>Now it\'s time to grow your Tree of Life.</p>' .
				   '<div style="border:1px solid black; border-radius:10px; padding:10px; margin-bottom:10px;"><p style="color:yellow;">THE GATE</p>' .
				   '<p"><strong>Week 1: </strong>You will join The Eden Project at The Gate.</p>' .
				   '<p><strong>Week 2: </strong> Your two (2) “seeds” will join The Eden Project at The Gate and you will move to “Seedling”</p>' .
				   '<p><strong>Week 3: </strong> The two people you invited will invite their two (2) “Seeds” each and you will move to “Plant”</p>' .
				   '<p><strong>Week 4: </strong> YOU ARE NOW THE TREE OF LIFE!!!! Those four (4) Seeds will invite their two (2) Seeds each and those eight (8) Seeds will each sow their support of $100 each to you.</p>' .
				   '<p><strong>CONGRATULATIONS, YOU HAVE NOW REAPED YOUR HARVEST AND WILL NOW ENTER THE GARDEN.</strong></p>' .
				   '<p><strong>Week 5: </strong> It’s time to Re-Sow. Take $100 from your $800 Harvest and Re-Sow your $100 seed support to the same “Tree of Life” you sowed into initially and in 21 days, reap your harvest again. Then do it all over again. It’s that simple.</p></div>' .
				   '<div style="border:1px solid black; border-radius:10px; padding:10px;"><p style="color:purple;">THE GARDEN</p>' .
				   '<p><strong>THE SUNDAY AFTER YOUR GATE HARVEST, YOU WILL TAKE $500 AND SOW INTO THE GARDEN.</strong></p>' .
                   '<p><strong>You will sow your support to the following:</p>' .
                   '<p style="margin-left:20px;">Name: ' . $water . '</p>' .
                   '<p style="margin-left:20px;">Number: ' . $water_phone . '</p>' .
                   '<p style="margin-left:20px;">Email: ' . $water_email . '</p>' .
                   '<p style="margin-left:20px;">Support Method: ' . $water_method . '</p>' .
                   '<p style="margin-left:20px;">Date to Sow: ' . $sow_date . '</strong></p>' .
				   '<p"><strong>Week 1: </strong>You will enter The Garden.</p>' .
				   '<p><strong>Week 2: </strong>The same two (2) Plants in your Tree from the Gate will follow you into The Garden and you will move to a Seedling in the Garden.</p>' .
				   '<p><strong>Week 3: </strong>The same four (4) Seedlings in your Tree from the Gate will follow you into The Garden and you will move to a Plant in the Garden.</p>' .
				   '<p><strong>Week 4: YOU ARE NOW THE TREE OF LIFE IN THE GARDEN!!!! </strong>Those same eight (8) Seeds that supported you in the Gate will each sow their support of $500 each to you in the Garden.</p>' .
				   '<p><strong>Week 5: </strong>It’s time to Re-Sow. Take $500 from your $4000 Harvest and Re-Sow your $500 seed support to the same “Tree of Life” you sowed into initially in The Garden and in 21 days, reap your harvest again. Then do it all over again. It’s that simple.</p></div>' .
				   '<p><strong>RENEGE OF SUPPORT</strong></p>' .
				   '<p>Your agreement to participate in The Eden Project is voluntary and this support is given freely and without coercion. This support is given without consideration and no repayment is expected or implied either in the form of cash or by future services.</p>' .
				   '<p><strong>THEREFORE, NO SUPPORTS WILL BE RETURNED. <mark>PLEASE BE VERY SURE ON YOUR DECISION TO JOIN THE EDEN PROJECT</mark></strong></p>' .
				   '<p>My hope is that this Initiative blesses you and your family.</p>' .
				   '<p><strong><mark>PLEASE RESPOND ACKNOWLEDGING THAT YOU HAVE CHOSEN TO PARTICIPATE IN THE EDEN PROJECT AND YOU ARE CLEAR ON ALL INFORMATION STATED ABOVE.</mark></strong></p>' .
				   '<p>Mary L. Boyde</p>' .
				   '<p>Founder</p>' .
				   '<p style="color:grey;">Copyright Notice.  All materials contained within this document are protected by United States copyright law and may not be reproduced, distributed, transmitted, displayed, published, altered or broadcasted without the prior, express written permission of Breaking Chains Private Cooperative, LLC.  ©Copyright 2020 Breaking Chains Private Cooperative, LLC
                    </p></body></html>';

///////////////////////////////////////////////////////////////////////////////////

		$mail = new PHPMailer();

		$mail->IsSMTP(); // set mailer to use SMTP
		$mail->Host = "smtpout.secureserver.net";  // specify main and backup server
		$mail->SMTPAuth = true;     // turn on SMTP authentication
		$mail->Username = "james@aliasmobile.com";  // SMTP username
		$mail->Password = "james"; // SMTP password

		$mail->setFrom("support@breakingchainsprivatecoop.com");
		$mail->FromName = "The Eden Project Support";
		$mail->AddAddress($to);                  // name is optional
		$mail->AddReplyTo("support@breakingchainsprivatecoop.com", "The Eden Project Support");
		$mail->addBCC("james.misa@thelotus.online");

		$mail->WordWrap = 50;                                 // set word wrap to 50 characters
		$mail->IsHTML(true);                                  // set email format to HTML

		$mail->Subject = $subject;
		$mail->Body    = $message;
		$mail->AltBody = $message;
    
        $mail->SMTPOptions = array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            )
        );

		if(!$mail->Send())
		{
		   $msg = "Message could not be sent.";
		   $msg += "Mailer Error: " . $mail->ErrorInfo;
		   $data = array('status'=>1, 'msg'=>$msg);
		   $json = json_encode($data);
		   echo $json;
		   exit;
		}

		   $msg = "Message has been sent.";
		   $data = array('status'=>4, 'msg'=>$msg);
		   $json = json_encode($data);
		   //echo $json;

}

///////////////////////////////////////////////////////////////////////////////////

function firstEmail ($email_address, $first_name, $tlf_id, $temp_password) {
    //need css
        $link = "<a href='http://thelotus.online?tlf_id=" . $tlf_id . "&temp_password=" . $temp_password . "&name=" . $first_name . "'>CLICK HERE</a>";	
        $to      = $email_address;
		$subject = 'WELCOME to the Lotus Family!';
		$message = '<html><body><p>Hello ' . $first_name . ',</p>' .  
				   '<p>Welcome to the world of the Lotus.</p>' . 
				   '<p>This is the initial email for existing flowers.</p>' . 
				   '<p>Click the link below to complete your account setup.</p>' .  
				   '<p><b>Account Verification:</b> ' . $link . '</p>' . 
				   '<p>Thank you!</p>' . 
				   '<p>TLF Task Force</p></body></html>';

		$mail = new PHPMailer();

		$mail->IsSMTP(); // set mailer to use SMTP
		$mail->Host = "smtpout.secureserver.net";  // specify main and backup server
		$mail->SMTPAuth = true;     // turn on SMTP authentication
		$mail->Username = "james@aliasmobile.com";  // SMTP username
		$mail->Password = "james"; // SMTP password

		$mail->setFrom("taskforce@thelotus.online");
		$mail->FromName = "TLF Task Force";
		$mail->AddAddress($to);                  // name is optional
		$mail->AddReplyTo("taskforce@thelotus.online", "TLF Task Force");
		$mail->addBCC("james@aliasmobile.com");

		$mail->WordWrap = 50;                                 // set word wrap to 50 characters
		$mail->IsHTML(true);                                  // set email format to HTML

		$mail->Subject = $subject;
		$mail->Body    = $message;
		$mail->AltBody = $message;
    
        $mail->SMTPOptions = array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            )
        );

		if(!$mail->Send())
		{
		   $msg = "Message could not be sent.";
		   $msg += "Mailer Error: " . $mail->ErrorInfo;
		   $data = array('status'=>1, 'msg'=>$msg);
		   $json = json_encode($data);
		   echo $json;
		   exit;
		}

		   $msg = "Message has been sent.";
		   $data = array('status'=>4, 'msg'=>$msg);
		   $json = json_encode($data);
		   //echo $json;

}

function testEmail ($email_address, $first_name, $tlf_id, $temp_password) {
        $link = "<a href='http://thelotus.online?tlf_id=" . $tlf_id . "&temp_password=" . $temp_password . "&name=" . $first_name . "'>CLICK HERE</a>";	
        $to      = $email_address;
		$subject = 'WELCOME to the Lotus Family!';
		$message = '<html><body><p>Hello ' . $first_name . ',</p>' .  
				   '<p>Welcome to the world of the Lotus.</p>' . 
				   '<p>This is the initial email for existing flowers.</p>' . 
				   '<p>Click the link below to complete your account setup.</p>' .  
				   '<p><b>Account Verification:</b> ' . $link . '</p>' . 
				   '<p>Thank you!</p>' . 
				   '<p>TLF Task Force</p></body></html>';

		$mail = new PHPMailer();

		$mail->IsSMTP(); // set mailer to use SMTP
		$mail->Host = "smtpout.secureserver.net";  // specify main and backup server
		$mail->SMTPAuth = true;     // turn on SMTP authentication
		$mail->Username = "james@aliasmobile.com";  // SMTP username
		$mail->Password = "james"; // SMTP password

		$mail->setFrom("taskforce@thelotus.online");
		$mail->FromName = "TLF Task Force";
		$mail->AddAddress($to);                  // name is optional
		$mail->AddReplyTo("taskforce@thelotus.online", "TLF Task Force");
		$mail->addBCC("james@aliasmobile.com");

		$mail->WordWrap = 50;                                 // set word wrap to 50 characters
		$mail->IsHTML(true);                                  // set email format to HTML

		$mail->Subject = $subject;
		$mail->Body    = $message;
		$mail->AltBody = $message;
    
        $mail->SMTPOptions = array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            )
        );

		if(!$mail->Send())
		{
		   $msg = "Message could not be sent.";
		   $msg += "Mailer Error: " . $mail->ErrorInfo;
		   $data = array('status'=>1, 'msg'=>$msg);
		   $json = json_encode($data);
		   echo $json;
		   exit;
		}

		   $msg = "Message has been sent.";
		   $data = array('status'=>4, 'msg'=>$msg);
		   $json = json_encode($data);
		   //echo $json;

}

function registerModal($promoCode, $price, $tlf_id, $name) {
   $modal = '<!-- Modal -->
<div class="modal fade" id="newRegister" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Become A Seed</h4>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form class="form-horizontal" data-toggle="validator" id="registerForm" role="form">

                <div class="form-group">
                    <label  class="sr-only" for="referrer_name">' . $name . '</label>
                    <div class="col-sm-12" inputGroupContainer>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" class="form-control referrer_name" 
                                   name="referrer_name" value="' . $name . '" disabled/>
                        </div><!--input-group-->
                        <p class="desc">Inviter</p>
                    </div><!--inputGroupContainer-->
                </div><!--form-group-->

                  <div class="form-group">
                    <label  class="sr-only" for="first_name">First Name</label>
                    <div class="col-sm-12" inputGroupContainer>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" class="form-control first_name" 
                            name="first_name" placeholder="First Name"/>
                        </div><!--input-group-->
                    </div><!--inputGroupContainer-->
                  </div><!--form-group-->

                    <div class="form-group">
                        <label  class="sr-only" for="last_name">Last Name</label>
                        <div class="col-sm-12" inputGroupContainer>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input type="text" class="form-control last_name" 
                                name="last_name" placeholder="Last Name"/>
                            </div><!--input-group-->
                        </div><!--inputGroupContainer-->
                    </div><!--form-group-->

                    <div class="form-group">
                        <label  class="sr-only" for="email">Email</label>
                        <div class="col-sm-12" inputGroupContainer>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <input type="email" class="form-control email" 
                                name="email" placeholder="Email"/>
                            </div><!--input-group-->
                        </div><!--inputGroupContainer-->
                    </div><!--form-group-->

                  <div class="form-group">
                    <label class="sr-only" for="phone" >Phone</label>
                    <div class="col-sm-12" inputGroupContainer>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                            <input type="tel" class="form-control phone"
                            name="phone" data-minlength="6" placeholder="Phone"/>
                        </div><!--input-group-->
                    </div><!--inputGroupContainer-->
                  </div><!--form-group-->

                    <div class="form-group">
                        <label  class="sr-only" for="fireDate">Targeted Fire Date</label>
                        <div class="col-sm-12" inputGroupContainer>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                <input type="date" class="form-control fireDate" 
                                name="fireDate"  placeholder="Seed Date"/>
                            </div><!--input-group-->
                            <p class="desc">Enter Seed Date (MUST BE A SUNDAY!)</p>
                        </div><!--inputGroupContainer-->
                    </div><!--form-group-->
                    
                    <div class="form-group">
                    <label class="sr-only" for="password" >Create a Password</label>
                    <div class="col-sm-12" inputGroupContainer>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input type="password" class="form-control password"
                            name="password" data-minlength="6" placeholder="Create a Password"/>
                        </div><!--input-group-->
                    </div><!--inputGroupContainer-->
                  </div><!--form-group-->
                    
                    <div class="form-group">
                    <label class="sr-only" for="confirmPassword" >Confirm Password</label>
                    <div class="col-sm-12" inputGroupContainer>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input type="password" class="form-control confirmPassword"
                            name="confirmPassword" data-minlength="6" placeholder="Confirm Password"/>
                        </div><!--input-group-->
                    </div><!--inputGroupContainer-->
                  </div><!--form-group-->
                    
                  <div class="form-group">
                    <label class="sr-only" for="promoCode" >Promo Code</label>
                    <div class="col-sm-12" inputGroupContainer>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
                            <input type="text" class="form-control promoCode"
                            name="promoCode" value="' . $promoCode . '" placeholder="Promo Code" disabled/>
                        </div><!--input-group-->
                        <p class="desc">Promo Code</p>
                    </div><!--inputGroupContainer-->
                  </div><!--form-group-->

                    <div class="form-group">
                        <div class="col-sm-12" inputGroupContainer>
                            <div class="input-group">
                                <input type="hidden" class="form-control ref_id" 
                                name="ref_id" value="' . $tlf_id . '" placeholder="Referrer Code" readonly/>
                            </div><!--input-group-->
                        </div><!--inputGroupContainer-->
                    </div><!--form-group-->

                    <div class="form-group">
                        <div class="col-sm-12" inputGroupContainer>
                            <div class="input-group">
                                <input type="hidden" class="form-control priceCode" 
                                name="priceCode" value="' . $price . '" placeholder="Price Code" readonly/>
                            </div><!--input-group-->
                        </div><!--inputGroupContainer-->
                    </div><!--form-group-->
                    
                    <div class="form-inline">
                        <div class="form-check">
                           <input class="form-check-input terms" type="checkbox" value="" onchange="activateButton(this)"/>
                          <label class="form-check-label" for="defaultCheck1">
                            I agree to the <a href="#privacy" data-toggle="modal" data-target="#privacy">Privacy Policy</a> and <a href="#terms" data-toggle="modal" data-target="#terms">Terms and Conditions</a>
                          </label>
                        </div>
                    </div><!--form-group-->

                </form> 
            </div><!--modal-body-->

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" id="regSubmit" name="submit" class="regSubmit btn btn-primary" disabled>Add</button>
            </div><!--modal-footer-->
        </div><!--modal-content-->
    </div><!--modal-dialog-->
</div><!--modal register-->
      ';
    
    return $modal;
}

function showTerms() {
    $terms = '<!-- Modal -->
<div class="modal fade" id="terms" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Terms & Conditions</h4>
            </div><!--modal-header-->
            
           <!-- Modal Body -->
            <div class="modal-body">
                <form class="form-horizontal" data-toggle="validator" id="loginForm1" role="form">
                    
                <div class="form-group">
                        <div class="wrapper">
<div class="terms">
<h4>Terms of Service</h4>

<p>Welcome to TheLotusOnline. This User Agreement ("Agreement") is a legal agreement between you ("you," "your") and TheLotusOnline, Inc. ("TheLotusOnline," "we," "our" or "us").
We want to make it easy for you to track and grow your Lotus flower, and have developed The Lotus Track & Grow service (the "Service," more fully described in Section 1 below) to help you. Before you can use the Service, we require that you accept the terms of this Agreement.

If you do not agree with these terms and do not want to be bound by this Agreement, you will not be granted any rights under this Agreement and you may not use or access the Service. Signing up for TheLotusOnline means you accept these terms:</p>

<h5>1. Your License</h5>

<p>TheLotusOnline grants you a personal, limited, non-exclusive, revocable, non-transferable license, without the right to sublicense, to electronically access and use the Service solely to track and grow your flower, and to manage the gifts you so receive. The Service includes our website, any programs, documentation, tools, internet-based services, components, and any updates (including website maintenance, service information, help content, or bug fixes) thereto provided to you by TheLotusOnline. You will be entitled to updates to the Service, subject to any additional terms made known to you at that time, when TheLotusOnline makes these updates available.</p>

<p>While we want you to enjoy the Service, you may not, nor may you permit any third party to do any of the following: (i) access or attempt to access TheLotusOnline systems, programs or data that are not made available for public use: (ii) copy, reproduce, republish, upload, post, transmit, resell or distribute in any way material from TheLotusOnline; (iii) permit any third party to use and benefit from the Service via a rental, lease, timesharing, or other arrangement; (iv) transfer any rights granted to you under this Agreement; (v) work around any of the technical limitations of the Service, use any tool to enable features or functionalities that are otherwise disabled in the Service, or decompile, disassemble or otherwise reverse engineer the Service, except to the extent that such restriction is expressly prohibited by law; (vi) perform or attempt to perform any actions that would interfere with the proper working of the Service, prevent access to or use of the Service by our other users, or impose an unreasonable or disproportionately large load on our infrastructure; or (vii) otherwise use the Service except as expressly allowed under this section.</p>

<h5>2. Ownership</h5>

<p>The Service is licensed and not sold. TheLotusOnline reserves all rights not expressly granted to you in this Agreement. The Service is protected by copyright, trade secret and other intellectual property laws. TheLotusOnline owns the title, copyright and other worldwide Intellectual Property Rights (as defined below) in the Service and all copies of the Service.

For the purposes of this Agreement, "Intellectual Property Rights" means all patent rights, copyright rights, moral rights, rights of publicity, trademark, trade dress and service mark rights, goodwill, trade secret rights and other intellectual property rights as may now exist or hereafter come into existence, and all applications therefore and registrations, renewals and extensions thereof, under the laws of any state, country, territory or other jurisdiction.

You may choose to or we may invite you to submit comments or ideas about the Service, including without limitation about how to improve the Service or our products ("Ideas"). By submitting any Idea, you agree that your disclosure is gratuitous, unsolicited and without restriction and will not place TheLotusOnline under any fiduciary or other obligation, and that we are free to use the Idea without any additional compensation to you, and/or to disclose the Idea on a non-confidential basis or otherwise to anyone. You further acknowledge that, by acceptance of your submission, TheLotusOnline does not waive any rights to use similar or related ideas previously known to TheLotusOnline, or developed by its employees, or obtained from sources other than you.</p>

<h5>3. Account Registration</h5>

<p>You must register and create a \'Member\' account to use the Service. When prompted by our registration process, you agree to (a) provide true, accurate, current and complete information about yourself, and (b) maintain and update this information to keep it true, accurate, current and complete. If any information provided by you is untrue, inaccurate, not current or incomplete, TheLotusOnline has the right to terminate your TheLotusOnline Account (\'Account\') and refuse any and all current or future use of the Service.</p>

<h5 id="subscription">4. SUBSCRIPTIONS AND BILLING</h5>
    
<p>4.1. Ongoing Subscription and Fees. We will bill you in advance for your subscription. Your subscription will continue and automatically renew on a recurring basis corresponding to the term of your subscription unless and until you cancel your subscription, or your account is otherwise suspended or terminated pursuant to these Terms. The Lotus Online reserves the right to change the terms of your subscription, including price, from time to time, effective as of the beginning of your next Billing Period following the date of the change. We will give you advance notice of these changes, but we will not be able to notify you of changes in any applicable taxes.</p>

<p>4.2 Payment Method. Unless otherwise indicated, you will be required to provide a credit card or other payment method accepted by The Lotus Online, as may be updated from time to time ("Payment Method"). We will charge your Payment Method a periodic subscription fee on a recurring basis corresponding to the term of your subscription, and any applicable taxes. You are solely responsible for any and all fees charged to your Payment Method. When you provide a Payment Method, we will attempt to verify the information you entered by processing an authorization hold. We do not charge you in connection with this authorization hold, but your available balance or credit limit may be reduced. If you want to use a different Payment Method than the one you signed up to use during registration, you may edit your Payment Method information by logging in on The Lotus Online Site and viewing your subscription details.</p>

<p>4.3 Billing Holds. In the event of a failed attempt to charge to your Payment Method (e.g. if your Payment Method has expired), we reserve the right to retry billing your Payment Method. In the event that you or we (through our payment service providers) update your Payment Method to remedy a change in validity or expiration date, we will automatically resume billing you for your subscription to the Services. We may suspend or cancel your access to the Services if we remain unable to successfully charge a valid Payment Method. We also reserve the right to pursue any amounts you fail to pay in connection with your subscription, including collection costs, bank overdraft fees, collection agency fees, reasonable attorneys\' fees, and arbitration or court costs.</p>

<p>We may offer you the ability to pause your subscription for a specified period of time. If you do not cancel before the end of the pause period, billing will resume automatically.</p>

<p>4.4 Billing Period. As used in these Terms, “billing” shall indicate either a charge or debit, as applicable, against your Payment Method. We will automatically bill your Payment Method on the later of the day you start your subscription or the day your free trial ends, and on each recurring billing date thereafter. Your “Billing Period” is the interval of time between each recurring billing date and corresponds to the term of your subscription. Where applicable, charges for one or more Services may be prorated for any partial month of service. To see your next recurring billing date, log in on the The Lotus Online Site and view your subscription details. You acknowledge that the timing of when you are billed and the amount billed each Billing Period may vary, including if your subscription began on a day not contained in a given month (e.g. if you have a monthly subscription and became a paying subscriber on January 31, your Payment Method would next be billed on February 28), due to free trials and other promotional offers, credits applied, or changes in your subscription or Payment Method.</p>

<p>4.5 Cancellation and Refunds. You can cancel your subscription by logging into your The Lotus Online account and following the instructions on your subscription page on The Lotus Online Site. See Section 4.9 for cancellation information if you pay for the Services through a third-party. You must cancel your subscription prior to 11:59 p.m. Eastern time on the day before your next recurring billing date in order to avoid being charged. If you cancel your subscription, you will continue to have access to the Service through the end of your current Billing Period. However, if you modify your subscription to switch from one Service to another Service during your Billing Period, you may not have continued access to your original Service. If you cancel, including if you switch your billing from The Lotus Online to a third-party, you will also forfeit any service, referral, or credits.</p>

<p>Payments are nonrefundable. If you cancel, modify your subscription, or if your account is otherwise terminated under these Terms, you will not receive a credit, including for partially used periods of Service. There are circumstances where The Lotus Online may provide credits on a case by case basis. The amount and form of such credits, and the decision to provide them, are at The Lotus Online\'s sole and absolute discretion.</p>

<p>4.6 Free Trials. On occasion, we may offer free trials to a particular Service, subject to specific terms explained during your sign-up. You can view details of your free trial on your The Lotus Online account page. The Lotus Online reserves the right to determine eligibility for free trials, which may vary based on factors including the Service selected, how recently you redeemed a free trial, and whether the Service is part of a combined offering. Certain limitations may also exist with respect to combining free trials with any other offers.</p>

<p>It is very important to understand that you will not receive a notice from The Lotus Online that your free trial has ended and that payment for your subscription is due. If you wish to avoid charges to your Payment Method, you must cancel your subscription prior to midnight Eastern Time on the last day of your free trial period. Because the Services are offered in multiple time zones, for consistency, a “day” for purposes of these Terms begins at 12:00 a.m. Eastern Time and ends at 11:59 p.m. Eastern time of that same calendar day. You may cancel your subscription at any time as described in the "Cancellation and Refunds" section of these Terms. If you cancel your subscription during a free trial or while using a promotional code or other credits, cancellation may be effective immediately.</p>

<p>4.7 Promotions. If we offer you a promotion (e.g., a promotional price or bundled subscription), the specific terms of the promotion will be disclosed during your sign-up or in other materials provided to you. We will begin billing your Payment Method for your subscription at the then-current, non-promotional price after your promotion ends unless you cancel prior to the end of your promotion or unless otherwise disclosed.</p>

<p>4.8 Third-Party Billing. You may choose to be billed for, or receive access to, the Services through a third-party, in which case, your billing relationship will be directly with that third-party, additional terms may apply, and Service offerings may be limited. If you want to cancel or modify your subscription or manage your billing, you may need to do so through your account with such third-party. The Lotus Online will not be liable to you for any claims arising out of or related to your purchase or use of third-party products or services.</p>

<h5>5. Protecting Your Information</h5>

<p>It is your sole responsibility to ensure that your account numbers, passwords, login details and any other security or access information used by you to use or access the Service is kept safe and confidential. You must prevent unauthorized access to and use of any of your information or data used with or stored in or by the Service (\'Account Data\'). You are responsible for all electronic communications sent to us or to any third party containing Account Data. When we receive communications containing your Account Data, we assume you sent it to us. You must immediately notify us if you become aware of any loss, theft or unauthorized use of any Account Data. We reserve the right to deny you access to the Service, in whole or in part, if we believe that any loss, theft or unauthorized use of any Account Data or access information has occurred. You grant us permission to anonymously combine your Account Data with that of other members in order to improve our services to you.</p>

<h5>6. Use of the Service</h5>

<p>We have the right and sole discretion to revise, update or otherwise modify the Service and to establish or change limits regarding the use of the Service. We will always attempt to notify you of any modifications with reasonable notice, by posting to TheLotusOnline website and/or sending you an email to the email address provided when you registered or subsequently updated by you. We reserve the right to make any such changes effective immediately to maintain the security of our system or to comply with any laws or regulations, and to provide with notice via email of such changes. We may also perform maintenance on the Service from time to time and this may result in service interruptions, delays, or errors. We will always attempt to provide prior notice of scheduled maintenance but cannot guarantee that notice will always be provided. You may be offered new services that may be in beta and not final. As such, the Service may contain errors and \'bugs\' that may result in its failure. You agree that we may contact you in order to assist you with the Service and obtain information needed to identify and fix any errors.</p>

<h5>7. Privacy</h5>

<p>Upon acceptance of this Agreement you confirm that you have read, understood and accepted TheLotusOnline’s Privacy Policy.</p>

<h5>8. Security</h5>

<p>We have implemented commercially reasonable technical and organizational measures designed to secure your personal information from accidental loss and from unauthorized access, use, alteration or disclosure. However, we cannot guarantee that unauthorized third parties will never be able to defeat those measures or use your personal information for improper purposes. You acknowledge that you provide your personal information at your own risk.</p>

<h5>9. No Warranty</h5>

<p>THE SERVICE IS PROVIDED ON AN \'AS IS\' AND \'AS AVAILABLE\' BASIS. USE OF THE SERVICE IS AT YOUR OWN RISK. TO THE MAXIMUM EXTENT PERMITTED BY APPLICABLE LAW, THE SERVICE IS PROVIDED WITHOUT WARRANTIES OF ANY KIND, WHETHER EXPRESS OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, IMPLIED WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, OR NON-INFRINGEMENT. NO ADVICE OR INFORMATION, WHETHER ORAL OR WRITTEN, OBTAINED BY YOU FROM COMPANY OR THROUGH THE SERVICE WILL CREATE ANY WARRANTY NOT EXPRESSLY STATED HEREIN. WITHOUT LIMITING THE FOREGOING, TheLotusOnline, ITS PROCESSORS, ITS PROVIDERS, ITS LICENSORS (AND THEIR RESPECTIVE SUBSIDIARIES, AFFILIATES, AGENTS, DIRECTORS, AND EMPLOYEES) DO NOT WARRANT THAT THE CONTENT IS ACCURATE, RELIABLE OR CORRECT; THAT THE SERVICE WILL MEET YOUR REQUIREMENTS; THAT THE SERVICE WILL BE AVAILABLE AT ANY PARTICULAR TIME OR LOCATION, UNINTERRUPTED OR SECURE; THAT ANY DEFECTS OR ERRORS WILL BE CORRECTED; OR THAT THE SERVICE IS FREE OF VIRUSES OR OTHER HARMFUL COMPONENTS. ANY CONTENT DOWNLOADED OR OTHERWISE OBTAINED THROUGH THE USE OF THE SERVICE IS DOWNLOADED AT YOUR OWN RISK AND YOU WILL BE SOLELY RESPONSIBLE FOR ANY DAMAGE TO YOUR PROPERTY OR LOSS OF DATA THAT RESULTS FROM SUCH DOWNLOAD.</p>

<p>TheLotusOnline DOES NOT WARRANT, ENDORSE, GUARANTEE, OR ASSUME RESPONSIBILITY FOR ANY PRODUCT OR SERVICE ADVERTISED OR OFFERED BY A THIRD PARTY THROUGH THE SERVICE OR ANY HYPERLINKED WEBSITE OR SERVICE, OR FEATURED IN ANY BANNER OR OTHER ADVERTISING, AND TheLotusOnline WILL NOT BE A PARTY TO OR IN ANY WAY MONITOR ANY TRANSACTION BETWEEN YOU AND THIRD-PARTY PROVIDERS OF PRODUCTS OR SERVICES</p>

<h5>10. Limitation of Liability and Damages</h5>
    
<p>By accepting these terms and conditions you agree that TheLotusOnline and its affiliates are not responsible and have no liability for indirect, incidental, consequential, special, exemplary, punitive or other damages under any contract, negligence, strict liability or other theory arising out of or relating in any way to your use of our service. TheLotusOnline will only be liable for costs and expenses incurred directly by you as a result of any negligent act or omission by us, provided that, under no circumstances shall our liability exceed the fees paid by you to TheLotusOnline for services rendered in the preceding 12 month period.</p>
    
<p>TO THE MAXIMUM EXTENT PERMITTED BY APPLICABLE LAW, TheLotusOnline AND ITS PROCESSORS (AND THEIR RESPECTIVE AFFILIATES, AGENTS, DIRECTORS, AND EMPLOYEES) ASSUME NO LIABILITY OR RESPONSIBILITY FOR ANY (I) ERRORS, MISTAKES, OR INACCURACIES OF CONTENT; (II) PERSONAL INJURY OR PROPERTY DAMAGE, OF ANY NATURE WHATSOEVER, RESULTING FROM YOUR ACCESS TO OR USE OF OUR SERVICE; (III) ANY UNAUTHORIZED ACCESS TO OR USE OF OUR SECURE SERVERS AND/OR ANY AND ALL PERSONAL INFORMATION STORED THEREIN; (IV) ANY INTERRUPTION OR CESSATION OF TRANSMISSION TO OR FROM THE SERVICE; (V) ANY BUGS, VIRUSES, TROJAN HORSES, OR THE LIKE THAT MAY BE TRANSMITTED TO OR THROUGH OUR SERVICE BY ANY THIRD PARTY; (VI) ANY ERRORS OR OMISSIONS IN ANY CONTENT OR FOR ANY LOSS OR DAMAGE INCURRED AS A RESULT OF THE USE OF ANY CONTENT POSTED, EMAILED, TRANSMITTED, OR OTHERWISE MADE AVAILABLE THROUGH THE SERVICE; AND/OR (VII) USER CONTENT OR THE DEFAMATORY, OFFENSIVE, OR ILLEGAL CONDUCT OF ANY THIRD PARTY. IN NO EVENT SHALL TheLotusOnline, ITS PROCESSORS, AGENTS, SUPPLIERS, OR LICENSORS (OR THEIR RESPECTIVE AFFILIATES, AGENTS, DIRECTORS, AND EMPLOYEES) BE LIABLE TO YOU FOR ANY CLAIMS, PROCEEDINGS, LIABILITIES, OBLIGATIONS, DAMAGES, LOSSES OR COSTS IN AN AMOUNT EXCEEDING THE AMOUNT OF FEES EARNED BY US IN CONNECTION WITH YOUR USE OF THE SERVICE DURING THE THREE (3) MONTH PERIOD IMMEDIATELY PRECEDING THE EVENT GIVING RISE TO THE CLAIM FOR LIABILITY.</p>
    
<p>THIS LIMITATION OF LIABILITY SECTION APPLIES WHETHER THE ALLEGED LIABILITY IS BASED ON CONTRACT, TORT, NEGLIGENCE, STRICT LIABILITY, OR ANY OTHER BASIS, EVEN IF TheLotusOnline HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGE. THE FOREGOING LIMITATION OF LIABILITY SHALL APPLY TO THE FULLEST EXTENT PERMITTED BY LAW IN THE APPLICABLE JURISDICTION.</p>
    
<p>The Service is controlled and operated from its facilities in the United States. TheLotusOnline makes no representations that the Service is appropriate or available for use in other locations. Those who access or use the Service from other jurisdictions do so at their own volition and are entirely responsible for compliance with all applicable United States and local laws and regulations, including but not limited to export and import regulations. You may not use the Service if you are a resident of a country embargoed by the United States, or are a foreign person or entity blocked or denied by the United States government. Unless otherwise explicitly stated, all materials found on the Service are solely directed to individuals located in the United States.</p>

<h5>11. Indemnity</h5>

<p>11.1 Customer agrees to defend, indemnify and hold harmless TheLotusOnline , its members, managers, officers, employees, attorneys, agents, and assigns from any and all claims, liabilities, losses, costs or damages whatsoever (herein “Claims”), including reasonable attorney’s fees, arising as a result of, or in any way connected with, the use of the System by any person, including but not limited to Customer or Authorized User (otherwise than as a result of any gross negligence on the part of TheLotusOnline, whether or not such Claims arise out of tort, contract or statute including, without limitation, (i) Claims caused by any act error, omission, fault or negligence of Customer or any Authorized User or any other party or their respective employees, customers or permitted assigns, or (ii) Claims arising under a warranty or representation by Customer to any Authorized User or to any third party in connection with the System, or (iii) Claims arising out of libel, slander, 
infringement of copyright, trademarks, service marks, trade secrets or patents, or breach in the privacy or security of transmissions directly or indirectly related to the use of the System, or (iv) Claims related to the rights of persons and entities that are not parties to this Agreement relating to the products and services provided directly or indirectly by TheLotusOnline that may include tools by which Customer or Authorized Users can contact third parties by phone, email and/or text messages (herein “Dissemination of Information”).</p>
    
<p>11.2 THELOTUSONLINE SPECIFICALLY DISCLAIMS ANY RESPONSIBILITY FOR DISSEMINATION OF INFORMATION. Customer represents and warrants that it will inquire of its own legal counsel as to the legality of any Dissemination of Information and/or actions in furtherance of such dissemination, and Customer assumes all responsibility for knowledge of, and compliance with, state and federal statutes, regulations, ordinances and other strictures governing the Dissemination of Information. Customer will use TheLotusOnline’ products, software and data base in full compliance with, and shall indemnify TheLotusOnline for failures of any person or entity, including but not limited to Customers and Authorized Users to fully comply with, all state and federal statutes, regulations, ordinances and other strictures governing the Dissemination of Information and/or actions in furtherance of such dissemination.</p>
    
<p>11.3 If TheLotusOnline receives notice of any Claim with respect to which it may be entitled to be indemnified by Customer hereunder it shall promptly give notice of the same to Customer. If Customer does not assume the defense of such Claim and unconditionally acknowledge its obligation to indemnify TheLotusOnline with respect thereto, TheLotusOnline shall be entitled to take such actions with regard thereto as it shall in its sole discretion determine including, but not limited to, de-activation of any Authorized User that it reasonably suspects is responsible for the conduct giving rise to the Claim and, if the misuse of the System is sufficiently serious, and after prior notice to Customer, to suspend all services provided hereunder until Customer is able to demonstrate to the reasonable satisfaction of TheLotusOnline that such misuse will not reoccur.
</p>

<h5>12. Representation and Warranties</h5>

<p>You represent and warrant to us that: (a) you are at least eighteen (18) years of age; (b) you are eligible to register and use the Service and have the right, power, and ability to enter into and perform under this Agreement; (c) the name identified by you when you registered is your name; (d) you are the owner of the email address and preferred gift method account information submitted in the registration process; and (e) you will not use the Service, directly or indirectly, for any fraudulent undertaking, illegal activity, or in any manner so as to interfere with the use of the Service.</p>

<h5>13. Consent to Electronic Communication</h5>

<p>We primarily communicate with you via your registered electronic addresses (e-mail and text). By registering for the services and accepting the terms of this Agreement, you affirmatively consent to receive notices electronically from us. You agree that we may provide all communications and transactions related to the services and your accounts, including without limitation agreements related to the Service, amendments or changes to such agreements, disclosures, notices, transaction information, statements, policies (including without limitation notices about our Privacy Policy), responses to claims, and other customer communications that we may be required to provide to you by law in electronic format. All communications by us will be sent either (a) via e-mail, (b) via text message, (c) by providing access to a Website that we designate in an e-mail notice to you, or (c) posting on our website. All Communications will be deemed to be in \'writing\' and received by you when sent to you. You are responsible for creating and maintaining your own records of such communications. You must send notices to us at the designated e-mail addresses on the website or through the submission forms on the website. We reserve the right to discontinue or modify how we provide communications. We will give you prior notice of any change. Your continued consent is required to use your account and the Service. To withdraw your consent, you will need to close your account.</p>

<h5>14. Limitation on Time to Sue</h5>
    
<p>Unless otherwise required by law, an action or proceeding by you to enforce an obligation, duty or right arising under this Agreement or by law must commence within one year after the cause of action accrues.</p>

<h5>15. Amendment</h5>
    
<p>We have the right to change or add to the terms of this Agreement at any time, and to change, delete, discontinue, or impose conditions on any feature or aspect of the Service with notice that we in our sole discretion deem to be reasonable in the circumstances, including such notice on our website at http://www.thelotus.online or any other website maintained or owned by us for the purposes of providing services in terms of this Agreement. Any use of the Service after our publication of any such changes shall constitute your acceptance of this Agreement as modified.</p>

<h5>16. Termination</h5>
    
<p>TheLotusOnline may permanently or temporarily terminate, suspend, or otherwise refuse to permit your access to the Service without notice and liability for any reason, including if in TheLotusOnline’s sole determination you violate any provision of this Agreement, or for no reason. Upon termination for any reason or no reason, you continue to be bound by this Agreement. We reserve the right (but have no obligation) to delete all of your information and Account Data stored on our servers if your membership is terminated or if you have not performed in accordance with the community rules and guidelines. Upon termination you must immediately stop using the Service and the license provided under this Agreement shall end. You also agree that upon termination in accordance with this section, TheLotusOnline shall not be liable to you or any third party for termination of access to the Service or deletion of your information or Account Data. The rights and obligations of Section 9 (Limitation of Liability and Damages) and Section 10 (Indemnity), will survive termination of this Agreement.</p>

<h5>17. Assignment</h5>
    
<p>This Agreement, and any rights and licenses granted hereunder, may not be transferred or assigned by you, but may be assigned by TheLotusOnline without restriction.</p>

<h5>18. General Provisions</h5>
    
<p>Except as expressly provided in this Agreement, these terms are a complete statement of the agreement between you and TheLotusOnline, and describe the entire liability of TheLotusOnline and its vendors and suppliers (including Processors) and your exclusive remedy with respect to your access and use of the Service. In the event of a conflict between this Agreement and the Privacy Policy, this Agreement shall prevail. If any provision of this Agreement is invalid or unenforceable under applicable law, then it shall be changed and interpreted to accomplish the objectives of such provision to the greatest extent possible under applicable law, and the remaining provisions will continue in full force and effect. This Agreement will be governed by California law as applied to agreements entered into and to be performed entirely within California, without regard to its choice of law or conflicts of law principles that would require application of law of a different jurisdiction, and applicable federal law.</p>
    
<h5>19. Arbitration Clause</h5>
    
<p>All disputes arising under this agreement shall be governed by and interpreted in accordance with the laws of California, without regard to principles of conflict of laws. The parties to this agreement will submit all disputes arising under this agreement to arbitration in Los Angeles, CA before a single arbitrator of the American Arbitration Association (“AAA”). The arbitrator shall be selected by application of the rules of the AAA, or by mutual agreement of the parties, except that such arbitrator shall be an attorney admitted to practice law in California. No party to this agreement will challenge the jurisdiction or venue provisions as provided in this section. No party to this agreement will challenge the jurisdiction or venue provisions as provided in this section. Nothing contained herein shall prevent the party from obtaining an injunction.</p>

</div>
</div>

                </div><!--form-group-->
                    
                </form><!--form-horizontal--> 
            </div><!--modal-body-->

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div><!--modal-footer-->
        </div><!--modal-content-->
    </div><!--modal-dialog-->
</div><!--modal login-->';
    
    return $terms;
}

function showPrivacy() {
    $privacy = '<!-- Modal -->
<div class="modal fade" id="privacy" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Privacy Policy</h4>
            </div><!--modal-header-->
            
           <!-- Modal Body -->
            <div class="modal-body">
                <form class="form-horizontal" data-toggle="validator" id="loginForm2" role="form">
                    
                <div class="form-group">
<div class="wrapper">
<div class="terms">

<p>TheLotusOnline respects your privacy and works hard to protect your personal information. We want you to understand how we may collect, store, use and protect any personal information. We will not share your information with anyone except as described in this Privacy Policy. When you registered for our services you agreed to accept this policy. We may change this policy at any time. We will post notifications of revised versions of our policy on our website, and revised policies will be immediately effective. Throughout this Privacy Policy, we will refer to our website and services collectively as the \"Service.\" Please note, this Privacy Policy does not apply to information we collect by other means than your use of the Service (including offline) or from other sources.</p>

<h4>Information We Collect</h4>

<p>When you register for or use a TheLotusOnline account, we collect the following information:
- When you register: we collect your name, phone number, email address, preferred gift method, and other related information.
- Additional information from or about you may also be collected in other ways, including responses to customer surveys or your communications with our customer service team.
**We use technology to help us collect information**</p>

<h4>Cookies</h4>

<p>It is important for us to track how our website is used, and we (or our service providers) may place "cookies" on your computer or device. Cookies are small data files that identify you when you use our services. You have the option to decline our cookies by using your browsers settings tools, but this may interfere with your use of our website and services.</p>

<h4>Protecting Personal Information</h4>

<p>Any information that can be used to identify a person is \"Personal Information\". This does not include information that has been aggregated or made anonymous. All information is securely stored on our servers in the United States. Our safeguards and procedures have been implemented to maintain the physical and electronic security of our services and your personal information. Our measures include firewalls, system-wide data encryption, physical and electronic access controls, and strict rules regarding the access and use of data on our system.</p>

<h4>Using Personal Information</h4>

<p>We use your Personal Information to provide you the features and functionality of the Service, and may share it with our trusted third parties, to ensure that you have a safe, high-performance experience when using the Service. When you use the Service, including contacting customer service or requesting technical support, in addition to many other interactions with TheLotusOnline, we will apply the information that we have collected. Knowing this information allows us to verify your identity, communicate with you and enforce our agreements with you. We may also use this information to measure how our members use the Service, and improve and enhance our offerings to you.
TheLotusOnline may use certain information about you without identifying you as an individual to third parties. We do this for purposes such as analyzing how the Service is used, diagnosing service or technical problems, maintaining security, and personalizing content.
We use cookies to: (a) remember information so that you will not have to re-enter it during your visit or the next time you visit the site; (b) provide custom, personalized content and information; (c) monitor the effectiveness of our Service; (d) monitor aggregate metrics such as total number of visitors and traffic; (e) diagnose or fix technology problems reported by our users or engineers that are associated with certain IP addresses; and (f) help you efficiently access your information after you sign in.</p>

<h4>Sharing Personal Information</h4>

<p>TheLotusOnline will not rent or sell your Personal Information to others. TheLotusOnline may share your Personal Information with members of TheLotusOnline or with third parties for the purpose of providing services to you (such as those described below). If we do this, such third parties\' use of your Personal Information will be bound by terms at least as restrictive as this Privacy Policy. We may store personal information in locations outside the direct control of TheLotusOnline (for instance, on servers or databases co-located with hosting providers).</p>

<p>Processing payment and deposit transactions requires that we share your personal information with third parties, including but not limited to:</p>
    
<ul style="margin-left: 20px;">
    <li>Service providers who provide us a range of essential operational services including fraud prevention, transaction processing, collections, direct marketing, and managed technology services. Our contracts dictate that these service providers only use your information in connection with the services they perform for us and not for their own benefit.</li>
    <li>Law enforcement authorities or government representatives who may require us to share information in order to comply with court order and other legal mandates, or when we believe that disclosure is necessary to report suspicious activities, prevent physical harm, financial loss, or violations of our agreements and policies.</li>
    <li>Other third parties, subject to your prior consent or direction.</li>
</ul>
    
<p>If TheLotusOnline becomes involved in a merger, acquisition, or any form of sale of some or all of its assets, we will ensure the confidentiality of any personal information involved in such transactions and provide notice before personal information is transferred and becomes subject to a different privacy policy.</p>
    
<p>Except as otherwise described in this Privacy Policy, TheLotusOnline will not disclose Personal Information to any third party unless required to do so by law or subpoena or if we believe that such action is necessary to (a) conform to the law, comply with legal process served on us or our affiliates, or investigate, prevent, or take action regarding suspected or actual illegal activities; (b) to enforce our Terms of Service and related agreements, take precautions against liability, to investigate and defend ourselves against any third-party claims or allegations, to assist government enforcement agencies, or to protect the security or integrity of our site; and (c) to exercise or protect the rights, property, or personal safety of TheLotusOnline, our Users or others.</p>
    
<h4>Compromise of Personal Information</h4>
    
<p>In the event that personal information is compromised as a result of a breach of security, TheLotusOnline will promptly notify those persons whose personal information has been compromised, in accordance with the notification procedures set forth in this Privacy Policy, by email, or as otherwise required by applicable law.</p>

<h4>Your Choices About Your Information</h4>

<p>You may, of course, decline to submit personally identifiable information through the Service, in which case TheLotusOnline may not be able to provide certain services to you. You may update or correct your account information at any time by logging in to your account. You can review and correct the information about you that TheLotusOnline keeps on file by contacting us as described below.</p>

<h4>Links to Other Web Sites</h4>

<p>TheLotusOnline is not responsible for the practices employed by websites linked to or from our website, nor the information or content contained therein. Please remember that when you use a link to go from our website to another website, our Privacy Policy is no longer in effect. Your browsing and interaction on any other website, including those that have a link on our website, is subject to that website\'s own rules and policies. Please read over those rules and policies before proceeding.</p>

<h4>Notification Procedures</h4>

<p>It is our policy to provide notifications, whether such notifications are required by law or are for marketing or other business related purposes, to you via email notice, written or hard copy notice, or through conspicuous posting of such notice on our website, as determined by TheLotusOnline in its sole discretion. We reserve the right to determine the form and means of providing notifications to you.</p>

<h4>Changes to Our Privacy Policy</h4>

<p>If we change our privacy policies and procedures, we will post those changes on our website to keep you aware of what information we collect, how we use it and under what circumstances we may disclose it. Changes to this Privacy Policy are effective when they are posted on this page.</p>

<h4>Contact us with any questions</h4>

<p>Please contact our Privacy Department ([privacy@TheLotus.Online](mailto:privacy@thelotus.online)) with any questions or concerns regarding our policy.</p>

<h5>Effective Date: July 6, 2020</h5>
    </div>
</div>




                </div><!--form-group-->
                    
                </form><!--form-horizontal--> 
            </div><!--modal-body-->

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div><!--modal-footer-->
        </div><!--modal-content-->
    </div><!--modal-dialog-->
</div><!--modal login-->';
    
    return $privacy;
}

function showTnCs($tlf_id) {
    $TnCs = '<!-- Modal -->
            <div class="modal fade" id="termsOptIn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Privacy Policy and Terms & Conditions</h4>
                        </div>

                        <!-- Modal Body -->
                        <div class="modal-body">
                            <form class="form-horizontal" data-toggle="validator" id="registerForm" role="form">


                            <div class="form-group">
                                <label  class="sr-only" for="referrer_name"><?php echo $referrer_name; ?></label>
                                <div class="col-sm-12" inputGroupContainer>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    </div><!--input-group-->
                                    <p>Hello Eden Family!</p>
                                    <p>Please review and agree to our Privacy Policy and our Terms and Conditions before entering the software.</p>
                                    <p>Thank you!</p>
                                </div><!--inputGroupContainer-->
                            </div><!--form-group-->

                                <div class="form-group">
                                    <div class="col-sm-12" inputGroupContainer>
                                        <div class="input-group">
                                            <input type="hidden" class="form-control" 
                                            id="tlf_id" name="ref_id" value="' . $tlf_id . '" placeholder="Referrer Code" readonly/>
                                        </div><!--input-group-->
                                    </div><!--inputGroupContainer-->
                                </div><!--form-group-->
                                
                            <div class="form-inline">
                                <div class="form-check">
                                   <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" onchange="activateButton(this)"/>
                                  <label class="form-check-label" for="defaultCheck1">
                                    I agree to the <a href="#privacy" data-toggle="modal" data-target="#privacy">Privacy Policy</a> and <a href="#terms" data-toggle="modal" data-target="#terms" onclick="localStorage.setItem(\'readTerms\', \'1\')">Terms and Conditions</a>
                                  </label>
                                </div>
                            </div><!--form-group-->


                            </form> 
                        </div><!--modal-body-->

                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" id="checkLogin" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" id="termsSubmit" name="submit" class="btn btn-primary" disabled>OK</button>
                        </div><!--modal-footer-->
                    </div><!--modal-content-->
                </div><!--modal-dialog-->
            </div><!--modal register-->';
    return $TnCs;
}


function paymentForm($trial) {
    $form = '<!-- Modal -->
<div class="modal fade" id="payment-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><span class="input-group-addon"><i class="glyphicon glyphicon-credit-card"></i></span>Payment Method</h4>
            </div><!--modal-header-->
            
           <!-- Modal Body -->
            <div class="modal-body">
                <form class="form-horizontal" data-toggle="validator" id="loginForm3" role="form">
                  
                <div id="logo"><img src="./images/tlflogo_lg.png"></div>    
                <h2 id="payment-desc">Monthly subscription for The Lotus Online platform: <span style="color:blue;">$19.95</span></h2>'
                    . $_SESSION['trial'] .
                '<div class="form-group">
                    <label  class="sr-only" for="cardInfo">Card Info</label>
                    <div class="col-sm-12" inputGroupContainer>
                        <div class="input-group">
                            <label for="card-element">
                              Credit or debit card
                            </label>
                            <div id="card-element">
                              <!-- A Stripe Element will be inserted here. -->
                            </div>
                        </div><!--input-group-->
                    </div><!--inputGroupContainer-->
                </div><!--form-group-->

                    <div class="form-group">
                        <label  class="sr-only" for="name">Full Name</label>
                        <div class="col-sm-12" inputGroupContainer>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input type="text" class="form-control name" 
                                id="name" name="name" placeholder="Full Name"/>
                            </div><!--input-group-->
                        </div><!--inputGroupContainer-->
                    </div><!--form-group-->

                    <div class="form-group">
                        <label  class="sr-only" for="address">Address</label>
                        <div class="col-sm-12" inputGroupContainer>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <input type="text" class="form-control address" 
                                id="address" name="address" placeholder="Address"/>
                            </div><!--input-group-->
                        </div><!--inputGroupContainer-->
                    </div><!--form-group-->

                    <div class="form-group">
                        <label  class="sr-only" for="city">City</label>
                        <div class="col-sm-12" inputGroupContainer>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <input type="text" class="form-control city" 
                                id="city" name="city" placeholder="City"/>
                            </div><!--input-group-->
                        </div><!--inputGroupContainer-->
                    </div><!--form-group-->

                    <div class="form-group">
                        <label  class="sr-only" for="zip">Postal Code</label>
                        <div class="col-sm-12" inputGroupContainer>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                <input type="text" class="form-control zip" 
                                id="zip" name="zip" placeholder="Postal Code"/>
                            </div><!--input-group-->
                        </div><!--inputGroupContainer-->
                    </div><!--form-group-->

                    <div class="form-group">
                        <label  class="sr-only" for="country">Country</label>
                        <div class="col-sm-12" inputGroupContainer>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>
                                <input type="text" class="form-control country" 
                                id="country" name="country" placeholder="Country"/>
                            </div><!--input-group-->
                        </div><!--inputGroupContainer-->
                    </div><!--form-group-->

                    <div class="form-group">
                        <label  class="sr-only" for="email">Email</label>
                        <div class="col-sm-12" inputGroupContainer>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <input type="email" class="form-control email" 
                                id="email" name="email" placeholder="Email"/>
                            </div><!--input-group-->
                        </div><!--inputGroupContainer-->
                    </div><!--form-group-->

                        <div class="form-group">
                            <div class="col-sm-12" inputGroupContainer>
                                <div class="input-group">
                                    <input type="hidden" class="form-control priceCode" 
                                    id="priceCode" name="priceCode" value="" placeholder="Price Code" readonly/>
                                </div><!--input-group-->
                            </div><!--inputGroupContainer-->
                        </div><!--form-group-->
                    
                </form><!--form-horizontal--> 
            </div><!--modal-body-->
            
            <div class="d-flex justify-content-center">
              <div id="loader" class="spinner-border loader" role="status">
                <span class="sr-only">Loading...</span>
              </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="submit" name="submit" class="btn btn-primary paymentSub">Submit Payment</button>
            </div><!--modal-footer-->
        </div><!--modal-content-->
    </div><!--modal-dialog-->
</div><!--modal login-->';
    
    return $form;
}

function showLogin() {
    $login = '<!-- Modal -->
<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">The Eden Project Login</h4>
            </div><!--modal-header-->
            
           <!-- Modal Body -->
            <div class="modal-body">
                <form class="form-horizontal" data-toggle="validator" id="loginForm4" role="form">
                    
                <div class="form-group">
                    <label  class="sr-only" for="email">Email</label>
                    <div class="col-sm-12" inputGroupContainer>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                            <input type="email" class="form-control" 
                            id="loginEmail" name="loginEmail" placeholder="Email"/>
                        </div><!--input-group-->
                    </div><!--inputGroupContainer-->
                </div><!--form-group-->

                <div class="form-group">
                    <label class="sr-only" for="password" >MyPassword</label>
                    <div class="col-sm-12" inputGroupContainer>
                        <div class="input-group" id="visibility">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input type="password" class="form-control"
                            id="loginPassword" name="loginPassword" data-minlength="6" placeholder="Password"/><div class="input-group-addon">
                            <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                            </div>
                        </div><!--input-group-->
                    </div><!--inputGroupContainer-->
                  </div><!--form-group-->
                    
                <h4>First Time? Go to www.breakingchainscoop.com to register.</h4>
                    
                </form><!--form-horizontal--> 
            </div><!--modal-body-->

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" id="loginSubmit" name="submit" class="btn btn-primary">Login</button>
            </div><!--modal-footer-->
        </div><!--modal-content-->
    </div><!--modal-dialog-->
</div><!--modal login-->';
    
    return $login;
}

function showForgotPassword() {
    $forgotPassword = '<!-- Modal -->
<div class="modal fade" id="forgotPassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Reset Password</h4>
            </div><!--modal-header-->
            
           <!-- Modal Body -->
            <div class="modal-body">
                <form class="form-horizontal" data-toggle="validator" id="resetPassword" role="form">
                    
                <div class="form-group">
                    <label  class="sr-only" for="email">Email</label>
                    <div class="col-sm-12" inputGroupContainer>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                            <input type="email" class="form-control" 
                            id="resetEmail" name="resetEmail" placeholder="Email"/>
                        </div><!--input-group-->
                        <p class="desc">Enter your email address.</p>
                        <p class="desc">New temp password will be \'password\' plus last four of your phone number on file.</p>
                    </div><!--inputGroupContainer-->
                </div><!--form-group-->
                    
                </form><!--form-horizontal--> 
            </div><!--modal-body-->

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" id="resetSubmit" name="submit" class="btn btn-primary">Reset Now</button>
            </div><!--modal-footer-->
        </div><!--modal-content-->
    </div><!--modal-dialog-->
</div><!--modal login-->';
    
    return $forgotPassword;
}

function showFindInviter() {
    $findInviter = '<!-- Modal -->
<div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Registration</h4>
            </div><!--modal-header-->
            
           <!-- Modal Body -->
            <div class="modal-body">
                <form class="form-horizontal" data-toggle="validator" id="loginForm5" role="form">
                    
                <div class="form-group">
                    <label  class="sr-only" for="email">Email</label>
                    <div class="col-sm-12" inputGroupContainer>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                            <input type="email" class="form-control" 
                            id="refEmail" name="refEmail" placeholder="Email"/>
                        </div><!--input-group-->
                        <p class="desc">Enter the email address of the person who invited you here.</p>
                    </div><!--inputGroupContainer-->
                </div><!--form-group-->
                    
                </form><!--form-horizontal--> 
            </div><!--modal-body-->

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" id="refSubmit" name="submit" class="btn btn-primary">Find Inviter</button>
            </div><!--modal-footer-->
        </div><!--modal-content-->
    </div><!--modal-dialog-->
</div><!--modal login-->';
    
    return $findInviter;
}


?>
 <div id="gotoTop" class="icon-angle-up"></div>
      <!-- cards modal -->
      <!-- Modal -->
      <div class="pl-0 modal fade" id="myModal" role="dialog">
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="modal-header modal-head">
                  <p class="modal-title">Add Message</p>
               </div>
               <div class="modal-body">
                  <div class="card-body">
                                  <div class="table-responsive">
                     <h4 class="modal-title text-center">MY ROOTS</h4>
                    <table class="table table-striped">
                        <thead>
                          <tr>
                           <th scope="col">Pos</th>
                           <th scope="col">Name</th>
                           <th scope="col">Phone</th>
                           <th scope="col">Email</th>
                         </tr>
                     </thead>
                     <tbody><tr>
                      <td>Tree</td>
                      <td>Suz Summerville</td>
                      <td>(818) 385-7472</td>
                      <td>suzsummerville@gmail.coma</td>
                    </tr><tr>
                      <td>Plant</td>
                      <td>Brian Edwards</td>
                      <td>(951) 317-2045</td>
                      <td>brian@brianedwardsrealty.coma</td>
                    </tr><tr>
                      <td>Seedling</td>
                      <td>Carolyn Sweeny</td>
                      <td>(818) 359-6786</td>
                      <td>sweeny.carolyn@gmail.com</td>
                    </tr></tbody>

                   </table>
                  <h4 id="flowers-title" class="text-center">MY BRANCHES</h4><table class="table table-striped">
                              <thead>
                                  <tr>
                                    <th scope="col">Pos</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Email</th>
                                  </tr>
                              </thead>
                              <tbody><tr>
                      <td>Earth 1</td>
                      <td>Felila Toleafoa</td>
                      <td>(801) 509-8038</td>
                      <td>felila_toleafoa@yahoo.com</td>
                    </tr><tr>
                      <td>Air 1</td>
                      <td>Audrey Peihopa</td>
                      <td>(213) 793-5362</td>
                      <td>audreypeihopa@comcast.net</td>
                    </tr><tr>
                      <td>Air 2</td>
                      <td>Monte Misa</td>
                      <td>(254) 319-6265</td>
                      <td>montemisa@gmail.com</td>
                    </tr><tr>
                      <td>Air 3</td>
                      <td>Deedee Kelly</td>
                      <td>(410) 963-6188</td>
                      <td>Dd_kelly@hotmail.com</td>
                    </tr><tr>
                      <td>Air 4</td>
                      <td>Anthony Toleafoa</td>
                      <td>(925) 967-3516</td>
                      <td>atoleafoa93@gmail.com</td>
                    </tr><tr>
                      <td>Fire 1</td>
                      <td>Mori Suesue</td>
                      <td>(510) 305-1279</td>
                      <td>morisuesue@gmail.com</td>
                    </tr><tr>
                      <td>Fire 2</td>
                      <td>Jeff Misa</td>
                      <td>(552) 413-2551</td>
                      <td>jeffrey.s.misa@gmail.com</td>
                    </tr><tr>
                      <td>Fire 3</td>
                      <td>James Misa</td>
                      <td>(510) 760-2500</td>
                      <td>james.misa.sr@gmail.com</td>
                    </tr></tbody>
                    </table>
                   </div>
                                
                   </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn profile-btn1" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
                       
                     