<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
// update_mstone.php - called by the seeds.php form
// to edit personal information
//
// (c) 2020, TLF
// Written by James Misa 

$next_milestone = $_REQUEST['next_mstone'];
$tlf_id = $_SESSION['tlf_id'];

if($next_milestone == "m_one") {
    $query = "UPDATE milestones
                  SET m_one = 1,
                      percentage = 20
                  WHERE tlf_id = '{$tlf_id}'";
                  
                  $result = mysqli_query($connection, $query);
                  confirm_query($result, $connection);
          $_SESSION['next_milestone'] = 'm_two';
          $_SESSION['percentage'] = '20';
} elseif ($next_milestone == "m_two") {
    $query = "UPDATE milestones
                  SET m_two = 1,
                      percentage = 40
                  WHERE tlf_id = '{$tlf_id}'";
                  
                  $result = mysqli_query($connection, $query);
                  confirm_query($result, $connection);
          $_SESSION['next_milestone'] = 'm_three';
          $_SESSION['percentage'] = '40';
} elseif ($next_milestone == "m_three") {
    $query = "UPDATE milestones
                  SET m_three = 1,
                      percentage = 60
                  WHERE tlf_id = '{$tlf_id}'";
                  
                  $result = mysqli_query($connection, $query);
                  confirm_query($result, $connection);
          $_SESSION['next_milestone'] = 'm_four';
          $_SESSION['percentage'] = '60';
} elseif ($next_milestone == "m_four") {
    $query = "UPDATE milestones
                  SET m_four = 1,
                      percentage = 80
                  WHERE tlf_id = '{$tlf_id}'";
                  
                  $result = mysqli_query($connection, $query);
                  confirm_query($result, $connection);
          $_SESSION['next_milestone'] = 'm_five';
          $_SESSION['percentage'] = '80';
} else {
    $query = "UPDATE milestones
                  SET m_five = 1,
                      percentage = 100
                  WHERE tlf_id = '{$tlf_id}'";
                  
                  $result = mysqli_query($connection, $query);
                  confirm_query($result, $connection);
          $_SESSION['next_milestone'] = 'complete';
          $_SESSION['percentage'] = '100';
}
        
	
?>