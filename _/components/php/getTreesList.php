<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
// getTreesList.php - called by the orgView.php screen
// to allow user to add new Tree from trees
//
// (c) 2020, TLF
// Written by James Misa 

$tlf_id = $_SESSION['tlf_id'];

        $query = "SELECT DISTINCT tlf_id, first_name, last_name, flower ";
        $query .= "FROM users ";
        $query .= "WHERE flower = 1 ";
        $query .= "ORDER BY first_name ASC, last_name ASC";
        $resultSet = mysqli_query($connection, $query);
        confirm_query($resultSet, $connection);

        $msg = array();
        $msg[0] = array();
        $msg[0]['tlf_id'] = $tlf_id;
        $msg[0]['name'] = 'Yourself';
        $i=1;
        while($found_tree = mysqli_fetch_array($resultSet)) {
            $name = $found_tree['first_name'] . " " . $found_tree['last_name'];
            $tlf_id = $found_tree['tlf_id'];
            
            $msg[$i] = array();
            $msg[$i]['tlf_id'] = $tlf_id;
            $msg[$i]['name'] = $name;
            $i++;
        }
    
    echo json_encode($msg); 

?>