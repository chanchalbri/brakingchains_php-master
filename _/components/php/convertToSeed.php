<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
// convertToSeed.php - called by the myFlowers.php form
// to convert a flower back to a seed
//
// (c) 2020, TLF
// Written by James Misa

$lotus_id = $_SESSION['focus_flower_id'];

    $query = "SELECT * ";
    $query .= "FROM users ";
    $query .= "WHERE lotus_id = '{$lotus_id}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);

    
    while($found_flower = mysqli_fetch_array($resultSet)) {
        $flower_tlf_id = $found_flower['tlf_id'];
        }

    $query2 = "SELECT * ";
    $query2 .= "FROM users ";
    $query2 .= "WHERE tlf_id = '{$flower_tlf_id}'";
    $resultSet2 = mysqli_query($connection, $query2);
    confirm_query($resultSet2, $connection);

    if(mysqli_num_rows($resultSet2) > 1) {
            echo "This person has multiple flowers. No need to convert to seed. Just delete.";
        } else {
            $query = "UPDATE users 
                      SET lotus_id = NULL,
                          air_id = NULL,
                          earth_id = NULL,
                          water_id = NULL,
                          gen = NULL,
                          flower = 0
                      WHERE tlf_id='{$flower_tlf_id}'";
            $resultSet = mysqli_query($connection, $query);
            confirm_query($resultSet, $connection);

            if(mysqli_affected_rows($connection) == 1) {
                echo "Flower converted to seed!";
            } else {
                echo "Cannot convert flower " . $flower_tlf_id;
            }
        } 

?>