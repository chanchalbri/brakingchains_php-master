<?php 
    $query = "SELECT * ";
    $query .= "FROM users ";
    $query .= "WHERE flower = 1 ";
    $query .= "ORDER BY fireDate ASC";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    $myFlowers = '<div class="myFlowers" id="myFlower">';
    $preFlowers = '<div class="myFlowers" id="preFlower">';
    $preFlowers = $preFlowers . '<h2 id="pre-flowers-title">PREMATURE FLOWERS</h2>';
    $flower_num = 1;
    $pre_flower_num = 1;
    $petal_num = 0;
    while($found_flower = mysqli_fetch_array($resultSet)) {
        $lotus_id = $found_flower['lotus_id'];
        $name = $found_flower['first_name'] . " " . $found_flower['last_name'];
        $gen = $found_flower['gen'];
        $open_petals = getOpenPetals($connection, $lotus_id);
        $expected_petals = $open_petals - 2;
        if($expected_petals >14) {$these_exp_petals = 14;} else {$these_exp_petals = $expected_petals;}
        $petal_count = getPetalCount($connection, $lotus_id);
        $eco_count = getEcoCount($connection, $lotus_id);
        $pre_date = $found_flower['fireDate'];
        $fireDate = date("m/d/Y", $pre_date);
        $today = strtotime("today");
        if($today > $pre_date) {
            if($petal_count < 14) {
                if($petal_count < $these_exp_petals) {
                    $neg_petals = $these_exp_petals - $petal_count;
                    $petal_num = $petal_num + $neg_petals;
                    $myFlowers = $myFlowers .  '<button class="btn btn-lg btn-primary btn-block" onclick="flower_dets(\'' . $lotus_id . '\', \'' . $tlf_id . '\');"><span class="full-name">#' . $flower_num . ' ' . $name . ' - Fire Date: ' . $fireDate . '</span><span class="counts">Neg: (' . $neg_petals . ') ' . '</span></button>';
                    $flower_num++;
                }
            }
        } else {
            $preFlowers = $preFlowers .  '<button class="btn btn-lg btn-primary btn-block" onclick="flower_dets(\'' . $lotus_id . '\', \'' . $tlf_id . '\');"><span class="full-name">#' . $pre_flower_num . ' ' . $name . ' - Fire Date: ' . $fireDate . '</span></button>';
            $pre_flower_num++;
        }
        
        
        
    }
    $myFlowers = $myFlowers . "</div>"; 

    $summary = '<div class="col d-flex justify-content-center">
                    <div class="card .mx-auto" style="width: 38rem;">
                      <div class="card-header bg-dark text-white">
                        Flowers Needing Attention</div>
                      <ul class="list-group list-group-flush">
                        <li class="list-group-item">Total Delinquent Flowers: ' . $flower_num . '</li>
                        <li class="list-group-item">Total Delinquent Petals: ' . $petal_num . '</li>
                        <a href="#" class="btn btn-primary" onclick="window.location.reload();">Back to flower list</a>
                      </ul>
                      </div>
                    </div>';
    echo $summary;
    echo $myFlowers;
    echo $preFlowers;
    
?>
