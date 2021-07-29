<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
// updateSowDate.php - called by the myflowers.php screen
// to allow user to change sow date
//
// (c) 2020, TLF
// Written by James Misa 

$sowDate_pre = trim($_REQUEST['sowDate']);
$sowDate = strtotime($sowDate_pre);
$id = trim($_REQUEST['id']);

        $query = "UPDATE users 
                  SET sowDate = '{$sowDate}'
                  WHERE id='{$id}'";
        $resultSet = mysqli_query($connection, $query);
        confirm_query($resultSet, $connection);

        if(mysqli_affected_rows($connection)) {
            echo "Sow Date Updated!";
        } else {
            echo "Something went wrong";
        }


?>