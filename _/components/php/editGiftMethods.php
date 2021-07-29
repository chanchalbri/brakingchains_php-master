<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
// editUser.php - called by the user.php form
// to edit personal information
//
// (c) 2020, TLF
// Written by James Misa 

// START FORM PROCESSING

    $addedMethod = $_REQUEST['addedMethod'];
    $count = $_REQUEST['count'];

    for($i=0; $i<$count; $i++) {
        if($addedMethod == 1) {
            $newOne = $count-1;
            if($i == $newOne) {
                $method = $_REQUEST['method' . $i];
                $username = $_REQUEST['username' . $i];
                $tlf_id = $_REQUEST['tlf_id'];
                $query = "INSERT INTO gift_methods (
                            tlf_id, 
                            gift_method,
                            method_username
                            ) VALUES (
                            '{$tlf_id}', 
                            '{$method}',
                            '{$username}'
                        )";
                
                $result = mysqli_query($connection, $query);
                confirm_query($result, $connection);
            } else {
                $method = $_REQUEST['method' . $i];
                $username = $_REQUEST['username' . $i];
                $id = $_REQUEST['id' . $i];
                $query = "UPDATE gift_methods 
                          SET gift_method = '{$method}',
                              method_username = '{$username}'
                          WHERE id='{$id}'";
                $resultSet = mysqli_query($connection, $query);
                confirm_query($resultSet, $connection);
            }
        } else {
            $method = $_REQUEST['method' . $i];
            $username = $_REQUEST['username' . $i];
            $id = $_REQUEST['id' . $i]; 
            $query = "UPDATE gift_methods 
                      SET gift_method = '{$method}',
                          method_username = '{$username}'
                      WHERE id='{$id}'";
            $resultSet = mysqli_query($connection, $query);
            confirm_query($resultSet, $connection);
        }
        
    }

    if(mysqli_affected_rows($connection) > 0) {
        echo "Gift methods updated";
    } 
	
?>