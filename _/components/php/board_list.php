<?php 
    $tlf_id = $_SESSION['tlf_id'];
    $query = "SELECT * ";
    $query .= "FROM users ";
    $query .= "WHERE tlf_id = '{$tlf_id}'";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    $myBoards = "";
    $i = 1;
    while($found_flower = mysqli_fetch_array($resultSet)) {
        $lotus_id = $found_flower['lotus_id'];
        $air_id = $found_flower['air_id'];
        $earth_id = $found_flower['earth_id'];
        $water_id = $found_flower['water_id'];
        
        $fires_water = getFireCount($connection, $water_id);
        $fires_earth = getFireCount($connection, $earth_id);
        $fires_air = getFireCount($connection, $air_id);
        $fires_lotus = getFireCount($connection, $lotus_id);
        $total = $fires_water + $fires_earth + $fires_air + $fires_lotus;
        if($fires_water < 8){
            $status_fire = "";
            $status_air = "";
            $status_earth = "";
            $color_air = "secondary";
            $color_earth = "secondary";
            $color_water = "secondary";
            $access_air = "disabled";
            $access_earth = "disabled";
            $access_water = "disabled";
        } else {
            $status_fire = "COMPLETE";
            if($fires_earth < 8) {
                $status_air = "";
                $status_earth = "";
                $color_air = "warning";
                $color_earth = "secondary";
                $color_water = "secondary";
                $access_air = "";
                $access_earth = "disabled";
                $access_water = "disabled";
            } else {
                $status_air = "COMPLETE";
                if($fires_air < 8) {
                   $status_earth = "";
                    $color_air = "warning";
                    $color_earth = "success";
                    $color_water = "secondary";
                    $access_air = "";
                    $access_earth = "";
                    $access_water = "disabled"; 
                } else {
                    $status_earth = "COMPLETE";
                    $color_air = "warning";
                    $color_earth = "success";
                    $color_water = "primary";
                    $access_air = "";
                    $access_earth = "";
                    $access_water = ""; 
                }
                
            }
        }
        
        $myBoards = $myBoards .  '<div class="accordion">';
        $myBoards = $myBoards .  '<button type="button" class="btn btn-dark btn-lg btn-block collapsed" data-toggle="collapse" data-target="#collapse' . $i . '" aria-expanded="true" aria-controls="collapse' . $i . '" style="margin-bottom:5px;"><span class="full-name">BOARD ID #' . $water_id . '</span><span class="counts">(' . $total . ') ' . '</span></button>';
        
        $myBoards = $myBoards .  '<div id="collapse' . $i . '" class="collapse" aria-labelledby="heading' . $i . '" data-parent=".accordion">';
        $myBoards = $myBoards .  '<button class="btn btn-lg btn-danger btn-block" onclick="board_dets(\'' . $lotus_id . '\', \'' . $water_id . '\');"><span class="full-name">FIRE BOARD ID #' . $water_id . ' ' . $status_fire . '</span><span class="counts">(' . $fires_water . ') ' . '</span></button>';
        $myBoards = $myBoards .  '<button class="btn btn-lg btn-' . $color_air . ' btn-block" onclick="board_dets(\'' . $lotus_id . '\', \'' . $earth_id . '\');" ' . $access_air . '><span class="full-name">AIR BOARD ID #' . $earth_id . ' ' . $status_air . '</span><span class="counts">(' . $fires_earth . ') ' . '</span></button>';
        $myBoards = $myBoards .  '<button class="btn btn-lg btn-' . $color_earth . ' btn-block" onclick="board_dets(\'' . $lotus_id . '\', \'' . $air_id . '\');" ' . $access_earth . '><span class="full-name">EARTH BOARD ID #' . $air_id . ' ' . $status_earth . '</span><span class="counts">(' . $fires_air . ') ' . '</span></button>';
        $myBoards = $myBoards .  '<button class="btn btn-lg btn-' . $color_water . ' btn-block" onclick="board_dets(\'' . $lotus_id . '\', \'' . $lotus_id . '\');" ' . $access_water . '><span class="full-name">WATER BOARD ID #' . $lotus_id . '</span><span class="counts">(' . $fires_lotus . ') ' . '</span></button>';
        
        $myBoards = $myBoards . '</div></div>';
        
        $i++;
    }
    echo $myBoards;
    
?>
