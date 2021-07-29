<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
// deleteFlower.php - called by the myFlowers.php form
// to delete a flower
//
// (c) 2020, TLF
// Written by James Misa

$lotus_id = $_SESSION['focus_flower_id'];

    $query = "DELETE ";
    $query .= "FROM users ";
    $query .= "WHERE lotus_id = '{$lotus_id}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);

    if(mysqli_affected_rows($connection) == 1) {
        echo "Flower deleted!";
    } else {
        echo "Cannot delete flower " . $flower_tlf_id;
    }

?>