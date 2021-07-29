<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
// updateSowDate.php - called by the myflowers.php screen
// to allow user to change sow date
//
// (c) 2020, TLF
// Written by James Misa 

$tlf_id = $_SESSION['tlf_id'];
$admin = $_SESSION['admin'];
if($admin == 1) {
    $permission = "";
} else {
    $permission = " AND referrer = " . $tlf_id;
}

        $query = "SELECT *";
        $query .= "FROM users ";
        $query .= "WHERE flower = 0" . $permission;
        $resultSet = mysqli_query($connection, $query);
        confirm_query($resultSet, $connection);

        $msg = array();
        $i=0;
        while($found_seed = mysqli_fetch_array($resultSet)) {
            $name = $found_seed['first_name'] . " " . $found_seed['last_name'];
            $id = $found_seed['id'];
            
            $msg[$i] = array();
            $msg[$i]['id'] = $id;
            $msg[$i]['name'] = $name;
            $i++;
        }
    
    echo json_encode($msg); 

?>