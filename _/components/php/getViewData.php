<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
// getViewData.php - called by the tree_list.php 
// to retrieve data to populate tree view
//
// (c) 2020, TLF
// Written by James Misa 

$id = $_REQUEST['id'];
$_SESSION['focus_tree'] = $id;

//get data for water
$query = "SELECT * ";
$query .= "FROM users ";
$query .= "WHERE id = '{$id}' LIMIT 1";
$resultSet = mysqli_query($connection, $query);
confirm_query($resultSet, $connection);

$data = '[';

$found_tree = mysqli_fetch_array($resultSet);
$name = $found_tree['first_name'] . " " . $found_tree['last_name'];
$treeId = $found_tree['id'];
$profile = $found_tree['profile'];
$lotus_id = $found_tree['lotus_id'];
$inivter_id = $found_tree['referrer_ten8'];
$inviter = getInviterTLF($connection, $inviter_id);
$petal = getPetalCount($connection, $lotus_id);
$eco = getEcoCount($connection, $lotus_id);

$data = $data . '{ id: 1, name: "' . $name . '", treeId: "' . $treeId . '", inviter: "(' . $inviter . ')", petal: "(' . $petal . ')", eco: "(' . $eco . ')", img: "(' . $profile . ')"},';

//get data for earths
$query = "SELECT * ";
$query .= "FROM users ";
$query .= "WHERE air_id = '{$lotus_id}'";
$resultSet = mysqli_query($connection, $query);
confirm_query($resultSet, $connection);

$i = 2;
$a = 4;
$f = 8;
while($found_earths = mysqli_fetch_array($resultSet)) {
    $name = $found_earth['first_name'] . " " . $found_earth['last_name'];
    $treeId = $found_earth['id'];
    $profile = $found_tree['profile'];
    $earth_lotus_id = $found_earth['lotus_id'];
    $inivter_id = $found_earth['referrer_ten8'];
    $inviter = getInviterTLF($connection, $inviter_id);
    $petal = getPetalCount($connection, $lotus_id);
    $eco = getEcoCount($connection, $lotus_id);
    
    $data = $data . '{ id: ' . $i . ', pid: 1, name: "' . $name . '", treeId: "' . $treeId . '", inviter: "(' . $inviter . ')", petal: "(' . $petal . ')", eco: "(' . $eco . ')", img: "(' . $profile . ')"},';
    
    $query2 = "SELECT * ";
    $query2 .= "FROM users ";
    $query2 .= "WHERE air_id = '{$earth_lotus_id}'";
    $resultSet2 = mysqli_query($connection, $query2);
    confirm_query($resultSet2, $connection);
    
    while($found_airs = mysqli_fetch_array($resultSet2)) {
        $name = $found_airs['first_name'] . " " . $found_airs['last_name'];
        $treeId = $found_airs['id'];
        $profile = $found_tree['profile'];
        $air_lotus_id = $found_airs['lotus_id'];
        $inivter_id = $found_airs['referrer_ten8'];
        $inviter = getInviterTLF($connection, $inviter_id);
        $petal = getPetalCount($connection, $lotus_id);
        $eco = getEcoCount($connection, $lotus_id);
        
        $data = $data . '{ id: ' . $a . ', pid: ' . $i .', name: "' . $name . '", treeId: "' . $treeId . '", inviter: "(' . $inviter . ')", petal: "(' . $petal . ')", eco: "(' . $eco . ')", img: "(' . $profile . ')"},';
    
        $query3 = "SELECT * ";
        $query3 .= "FROM users ";
        $query3 .= "WHERE air_id = '{$earth_lotus_id}'";
        $resultSet3 = mysqli_query($connection, $query3);
        confirm_query($resultSet3, $connection);
        
        while($found_fires = mysqli_fetch_array($resultSet2)) {
            $name = $found_fires['first_name'] . " " . $found_fires['last_name'];
            $treeId = $found_fires['id'];
            $profile = $found_tree['profile'];
            $air_lotus_id = $found_fires['lotus_id'];
            $inivter_id = $found_fires['referrer_ten8'];
            $inviter = getInviterTLF($connection, $inviter_id);
            $petal = getPetalCount($connection, $lotus_id);
            $eco = getEcoCount($connection, $lotus_id);

            $data = $data . '{ id: ' . $f . ', pid: ' . $a .', name: "' . $name . '", treeId: "' . $treeId . '", inviter: "(' . $inviter . ')", petal: "(' . $petal . ')", eco: "(' . $eco . ')", img: "(' . $profile . ')"},';
            $f++;
        }
        $a++;
    }
    $i++;
}

$data = $data . ']';
    
echo $data;
	
?>