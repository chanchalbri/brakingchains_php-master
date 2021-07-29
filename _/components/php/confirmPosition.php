<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
// confirmPosition.php - called by the boards.php screen
// to look up user's placement selection
//
// (c) 2020, TLF
// Written by James Misa 

$boardLevel = trim($_REQUEST['boardLevel']);
$placementMethod = trim($_REQUEST['placementMethod']);
$boardID = trim($_REQUEST['boardID']);
$tlf_id = $_SESSION['tlf_id'];
$inviter = $_SESSION['referrer_ten8'];
$promoCode = $_SESSION['promoCode'];

$query = "INSERT INTO board_request (
            tlf_id,
            board_selected,
            board_id,
            placement_method,
            inviter
            ) VALUES (
            '{$tlf_id}',
            '{$boardLevel}',
            '{$boardID}',
            '{$placementMethod}',
            '{$inviter}'
        )";

$resultSet = mysqli_query($connection, $query);
confirm_query($resultSet, $connection);

if (mysqli_affected_rows($connection) > 0) {//Success!
    echo "Thank you! You will be notified shortly";
    }
/*

if($placementMethod == "Specific Board") {
    $query = "SELECT *";
    $query .= "FROM users ";
    $query .= "WHERE id = '{$boardID}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    $found_board = mysqli_fetch_array($resultSet);
    $lotus_id = $found_board['lotus_id'];
    $fire_count = getFireCount($connection, $lotus_id);
    if($fire_count > 7) {
        echo "This board is already closed";
    } else {
        //find air with available position
        //do I need to allow for specific position on board?
    }
} elseif ($placementMethod == "Follow My Inviter") {
    $inviter = $_SESSION['referrer_ten8'];
}

*/

?>