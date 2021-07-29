<?php 
    $tlf_id = $_SESSION['tlf_id'];
    $query = "SELECT * ";
    $query .= "FROM users ";
    $query .= "WHERE tlf_id = '{$tlf_id}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    $myFlowers = '';
    $flower_num = 1;
    while($found_flower = mysqli_fetch_array($resultSet)) {
        $id = $found_flower['id'];
        $lotus_id = $found_flower['lotus_id'];
        $gen = $found_flower['gen'];
        $display_name = $found_flower['display_name'];
        $petal_count = getPetalCount($connection, $lotus_id);
        $eco_count = getEcoCount($connection, $lotus_id);
        $pre_date = $found_flower['sowDate'];
        $fireDate = date("m/d/Y", $pre_date);
        $myFlowers = $myFlowers .  '<button class="btn btn-lg btn-primary btn-block" onclick="flower_dets(\'' . $lotus_id . '\', \'' . $tlf_id . '\');"><span class="full-name">ID #' . $id . ' ( ' . $display_name . ') Sow Date: ' . $fireDate . '</span><span class="counts">(' . $petal_count . ')  (' . $eco_count . ') ' . '</span></button>';
        $flower_num++;
    }
    echo $myFlowers;
    
?>
