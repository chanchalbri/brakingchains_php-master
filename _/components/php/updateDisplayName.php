<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
// updateDisplayName.php - called by the myflowers.php screen
// to allow user to change sow date
//
// (c) 2020, TLF
// Written by James Misa 

$display_name = trim($_REQUEST['display_name']);
$focus_id = trim($_REQUEST['focus_id']);

        $query = "UPDATE users 
                  SET display_name = '{$display_name}'
                  WHERE id='{$focus_id}'";
        $resultSet = mysqli_query($connection, $query);
        confirm_query($resultSet, $connection);

        if(mysqli_affected_rows($connection)) {
            $_SESSION['display_name'] = $display_name;
            echo "Display Name Updated!";
        } else {
            echo "Something went wrong";
        }


?>