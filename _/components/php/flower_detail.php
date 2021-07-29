<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php 

if(isset($_REQUEST['lotus_id'])) {$lotus_id = $_REQUEST['lotus_id'];} else {$lotus_id = "null";}
if(isset($_REQUEST['tlf_id'])) {$focus_tlf_id = $_REQUEST['tlf_id'];} else {$focus_tlf_id = "null";}
if(isset($_SESSION['gen'])) {$user_gen = $_SESSION['gen'];}
$tlf_id = $_SESSION['tlf_id'];
$_SESSION['focus_flower_id'] = $lotus_id;

    $sowDate = getSowDate($connection, $lotus_id);
    $water_name = getWaterName($connection, $lotus_id);
    $water_method = getWaterMethod($connection, $lotus_id);
    $open_petals = getOpenPetals($connection, $lotus_id);
    $next_seeds = getNextSeedsAll($connection, $lotus_id, $focus_tlf_id);
    if($open_petals - $next_seeds > 0){$needed_seeds = $open_petals-$next_seeds;}else{$needed_seeds = '0';}
    $sunday = date("m/d/Y", strtotime("next Sunday"));
    $focus_name = getFocusName($connection, $lotus_id);

    $query = sprintf("SELECT * FROM users WHERE lotus_id='%s'", 
    mysqli_real_escape_string($connection, $lotus_id));

    $result = mysqli_query($connection, $query);

   
    while($found_flower = mysqli_fetch_array($result)) {
        $display_name = $found_flower['display_name'];
        $flower = $found_flower['flower'];
        $tlf_id = $found_flower['tlf_id'];
        if($flower == 1){$color = 'btn-success';}else{$color = 'btn-secondary';}
    }

    $flower_det = '<div class="col d-flex justify-content-center">
                    <div class="card .mx-auto" style="width: 38rem;">
                      <div class="card-header bg-dark text-white">
                        Seed Date: ' . $sowDate . 
                      '<span class="counts"><button class="btn btn-primary btn-sm"data-toggle="modal" data-target="#editDate">Edit Date</button></span></div>
                      <ul class="list-group list-group-flush">
                        <li class="list-group-item">Tree Name: ' . $water_name . '</li>
                        <li class="list-group-item">Tree Gift Method: ' . $water_method . '</li>
                        <li class="list-group-item">Display Name: ' . $display_name . '<span class="counts"><button class="btn btn-primary btn-sm"data-toggle="modal" data-target="#editName" data-val="' . $focus_name . '" >Edit Name</button></span></li>
                        <li class="list-group-item">Open positions for ' . $sunday . '<span class="badge badge-pill badge-danger">' . $open_petals . '</span></li>
                        <li class="list-group-item">Existing Seeds for ' . $sunday . '<span class="badge badge-pill badge-danger">' . $next_seeds . '</span></li>
                        <li class="list-group-item">Needed Seeds for ' . $sunday . '<span class="badge badge-pill badge-danger">' . $needed_seeds . '</span></li>
                        <a href="#" class="btn btn-primary" onclick="window.location.reload();">Back to my trees</a>
                      </ul>
                      </div>
                    </div>';

    $flower_det = $flower_det . "<div class=\"flower_det\">";

    $inviteesCount = getInviteeCount($connection, $tlf_id);
    $water_pc = getPetalCount($connection, $lotus_id);
    $water_ec = getEcoCount($connection, $lotus_id);
    $flower_det = $flower_det . '<button class="btn btn-lg ' . $color . ' btn-block"><img src="images/Tree of Life.png" style="width:3vw; height:3vw;"></i>  ' . $display_name . ' <span class="badge badge-light"> ' . $inviteesCount . '</span><span class="counts">(' . $water_pc . ')  (' . $water_ec . ') ' . '</span></button>';

    $funct2 = 'onclick="alert(\'New trees can only be added to the Earth position. Move to the correct tree before adding.\');"';
    
    $gen_depth = 20;
    
    //get the two earths
    $query2 = sprintf("SELECT * FROM users WHERE air_id='%s'", 
    mysqli_real_escape_string($connection, $lotus_id));

    $result2 = mysqli_query($connection, $query2);
    if(mysqli_num_rows($result2) > 0) {//there's at least one earth
        if(mysqli_num_rows($result2) > 1) {//there are two earths
            $i = 1;
            while($found_earth = mysqli_fetch_array($result2)) {
                $earth_name = $found_earth['display_name'];
                $earth_gen = $found_earth['gen'];
                $earth_lotus_id = $found_earth['lotus_id'];
                $earth_tlf_id = $found_earth['tlf_id'];
                $earth_flower = $found_earth['flower'];
                if($earth_flower == 1){$color = 'btn-warning';}else{$color = 'btn-secondary';}
                $diff = $earth_gen - $user_gen;
                if($diff > $gen_depth) {
                    $funct = 'onclick="alert(\'You are only allowed to view trees within your ecosystem\');"';
                } else {
                    $funct = 'onclick="flower_dets(\'' . $earth_lotus_id . '\', \'' . $earth_tlf_id . '\');"';
                }
                $inviteesCount = getInviteeCount($connection, $earth_tlf_id);
                $earth_pc = getPetalCount($connection, $earth_lotus_id);
                $earth_ec = getEcoCount($connection, $earth_lotus_id);
                $flower_det = $flower_det . '<button class="btn btn-lg ' . $color . ' btn-block" ' . $funct . '><img src="images/Plant.png" style="width:3vw; height:3vw;"></i> ' . $earth_name . ' <span class="badge badge-light"> ' . $inviteesCount . '</span><span class="counts">(' . $earth_pc . ')  (' . $earth_ec . ') ' . '</span></button>';
                $i++;
                
                //get the two airs
                $query3 = sprintf("SELECT * FROM users WHERE air_id='%s'", 
                mysqli_real_escape_string($connection, $earth_lotus_id));

                $result3 = mysqli_query($connection, $query3);
                if(mysqli_num_rows($result3) > 0) {//there's at least one air
                    if(mysqli_num_rows($result3) > 1) {//there are two airs
                        $e = 1;
                        while($found_air = mysqli_fetch_array($result3)) {
                            $air_name = $found_air['display_name'];
                            $air_gen = $found_air['gen'];
                            $air_lotus_id = $found_air['lotus_id'];
                            $air_tlf_id = $found_air['tlf_id'];
                            $air_flower = $found_air['flower'];
                            if($air_flower == 1){$color = 'btn-dark';}else{$color = 'btn-secondary';}
                            $diff = $air_gen - $earth_gen;
                            if($diff > $gen_depth) {
                                $funct = 'onclick="alert(\'You are only allowed to view trees within your ecosystem\');"';
                            } else {
                                $funct = 'onclick="flower_dets(\'' . $air_lotus_id . '\', \'' . $air_tlf_id . '\');"';
                            }
                            $inviteesCount = getInviteeCount($connection, $air_tlf_id);
                            $air_pc = getPetalCount($connection, $air_lotus_id);
                            $air_ec = getEcoCount($connection, $air_lotus_id);
                            $flower_det = $flower_det . '<button class="btn btn-lg ' . $color . ' btn-block" ' . $funct . '><img src="images/Seedling.png" style="width:3vw; height:3vw;"></i>  ' . $air_name . ' <span class="badge badge-light"> ' . $inviteesCount . '</span><span class="counts">(' . $air_pc . ')  (' . $air_ec . ') ' . '</span></button>';
                            $e++;
                            
                            //get the two fires
                            $query4 = sprintf("SELECT * FROM users WHERE air_id='%s'", 
                            mysqli_real_escape_string($connection, $air_lotus_id));

                            $result4 = mysqli_query($connection, $query4);
                            if(mysqli_num_rows($result4) > 0) {//there's at least one fire
                                if(mysqli_num_rows($result4) > 1) {//there are two fires
                                    $a = 1;
                                    while($found_fire = mysqli_fetch_array($result4)) {
                                        $fire_name = $found_fire['display_name'];
                                        $fire_gen = $found_fire['gen'];
                                        $fire_lotus_id = $found_fire['lotus_id'];
                                        $fire_tlf_id = $found_fire['tlf_id'];
                                        $fire_flower = $found_fire['flower'];
                                        if($fire_flower == 1){$color = 'btn-danger';}else{$color = 'btn-secondary';}
                                        $diff = $fire_gen - $user_gen;
                                        $inviteesCount = getInviteeCount($connection, $fire_tlf_id);
                                        $fire_pc = getPetalCount($connection, $fire_lotus_id);
                                        $fire_ec = getEcoCount($connection, $fire_lotus_id);
                                        if($diff > $gen_depth) {
                                            $funct = 'onclick="alert(\'You are only allowed to view trees within your ecosystem\');"';
                                        } else {
                                            $funct = 'onclick="flower_dets(\'' . $fire_lotus_id . '\', \'' . $fire_tlf_id . '\');"';
                                        }
                                        $flower_det = $flower_det . '<button class="btn btn-lg ' . $color . ' btn-block" ' . $funct . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> ' . $fire_name . ' <span class="badge badge-light"> ' . $inviteesCount . '</span><span class="counts">(' . $fire_pc . ')  (' . $fire_ec . ') ' . '</span></button>';
                                        $a++;
                                    }
                                } else {//there's only one fire - or earth for this air
                                    while($found_fire = mysqli_fetch_array($result4)) {
                                        $fire_name = $found_fire['display_name'];
                                        $fire_gen = $found_fire['gen'];
                                        $fire_lotus_id = $found_fire['lotus_id'];
                                        $fire_tlf_id = $found_fire['tlf_id'];
                                        $fire_flower = $found_fire['flower'];
                                        if($fire_flower == 1){$color = 'btn-danger';}else{$color = 'btn-secondary';}
                                        $diff = $fire_gen - $user_gen;
                                        $inviteesCount = getInviteeCount($connection, $fire_tlf_id);
                                        $fire_pc = getPetalCount($connection, $fire_lotus_id);
                                        $fire_ec = getEcoCount($connection, $fire_lotus_id);
                                        if($diff > $gen_depth) {
                                            $funct = 'onclick="alert(\'You are only allowed to view trees within your ecosystem\');"';
                                        } else {
                                            $funct = 'onclick="flower_dets(\'' . $fire_lotus_id . '\', \'' . $fire_tlf_id . '\');"';
                                        }
                                        $flower_det = $flower_det . '<button class="btn btn-lg ' . $color . ' btn-block" ' . $funct . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> ' . $fire_name . ' <span class="badge badge-light"> ' . $inviteesCount . '</span><span class="counts">(' . $fire_pc . ')  (' . $fire_ec . ') ' . '</span></button>';
                                        $e++;
                                    }
                                    $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
                                }
                            } else {//there are no fires - or earth's for this air
                                $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seed.png" style="width:3vw; height:3vw;"> Vacant<span class="counts">(0)  (0)</span></button>';
                                $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seed.png" style="width:3vw; height:3vw;"> Vacant<span class="counts">(0)  (0)</span></button>';
                            }
                        }
                    } else {//there's only one air - or earth for this earth
                        while($found_air = mysqli_fetch_array($result3)) {
                            $air_name = $found_air['display_name'];
                            $air_gen = $found_air['gen'];
                            $air_lotus_id = $found_air['lotus_id'];
                            $air_tlf_id = $found_air['tlf_id'];
                            $air_flower = $found_air['flower'];
                            if($air_flower == 1){$color = 'btn-dark';}else{$color = 'btn-secondary';}
                            $diff = $air_gen - $earth_gen;
                            if($diff > $gen_depth) {
                                $funct = 'onclick="alert(\'You are only allowed to view trees within your ecosystem\');"';
                            } else {
                                $funct = 'onclick="flower_dets(\'' . $air_lotus_id . '\', \'' . $air_tlf_id . '\');"';
                            }
                            $inviteesCount = getInviteeCount($connection, $air_tlf_id);
                            $air_pc = getPetalCount($connection, $air_lotus_id);
                            $air_ec = getEcoCount($connection, $air_lotus_id);
                            $flower_det = $flower_det . '<button class="btn btn-lg ' . $color . ' btn-block" ' . $funct . '><img src="images/Seedling.png" style="width:3vw; height:3vw;"></i>  ' . $air_name . ' <span class="badge badge-light"> ' . $inviteesCount . '</span><span class="counts">(' . $air_pc . ')  (' . $air_ec . ') ' . '</span></button>';
                            
                            //get the two fires
                            $query4 = sprintf("SELECT * FROM users WHERE air_id='%s'", 
                            mysqli_real_escape_string($connection, $air_lotus_id));

                            $result4 = mysqli_query($connection, $query4);
                            if(mysqli_num_rows($result4) > 0) {//there's at least one fire
                                if(mysqli_num_rows($result4) > 1) {//there are two fires
                                    $a = 1;
                                    while($found_fire = mysqli_fetch_array($result4)) {
                                        $fire_name = $found_fire['display_name'];
                                        $fire_gen = $found_fire['gen'];
                                        $fire_lotus_id = $found_fire['lotus_id'];
                                        $fire_tlf_id = $found_fire['tlf_id'];
                                        $fire_flower = $found_fire['flower'];
                                        if($fire_flower == 1){$color = 'btn-danger';}else{$color = 'btn-secondary';}
                                        $diff = $fire_gen - $user_gen;
                                        $inviteesCount = getInviteeCount($connection, $fire_tlf_id);
                                        $fire_pc = getPetalCount($connection, $fire_lotus_id);
                                        $fire_ec = getEcoCount($connection, $fire_lotus_id);
                                        if($diff > $gen_depth) {
                                            $funct = 'onclick="alert(\'You are only allowed to view trees within your ecosystem\');"';
                                        } else {
                                            $funct = 'onclick="flower_dets(\'' . $fire_lotus_id . '\', \'' . $fire_tlf_id . '\');"';
                                        }
                                        $flower_det = $flower_det . '<button class="btn btn-lg ' . $color . ' btn-block" ' . $funct . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> ' . $fire_name . ' <span class="badge badge-light"> ' . $inviteesCount . '</span><span class="counts">(' . $fire_pc . ')  (' . $fire_ec . ') ' . '</span></button>';
                                        $a++;
                                    }
                                } else {//there's only one fire - or earth for this air
                                    while($found_fire = mysqli_fetch_array($result4)) {
                                        $fire_name = $found_fire['display_name'];
                                        $fire_gen = $found_fire['gen'];
                                        $fire_lotus_id = $found_fire['lotus_id'];
                                        $fire_tlf_id = $found_fire['tlf_id'];
                                        $fire_flower = $found_fire['flower'];
                                        if($fire_flower == 1){$color = 'btn-danger';}else{$color = 'btn-secondary';}
                                        $diff = $fire_gen - $user_gen;
                                        $inviteesCount = getInviteeCount($connection, $fire_tlf_id);
                                        $fire_pc = getPetalCount($connection, $fire_lotus_id);
                                        $fire_ec = getEcoCount($connection, $fire_lotus_id);
                                        if($diff > $gen_depth) {
                                            $funct = 'onclick="alert(\'You are only allowed to view trees within your ecosystem\');"';
                                        } else {
                                            $funct = 'onclick="flower_dets(\'' . $fire_lotus_id . '\', \'' . $fire_tlf_id . '\');"';
                                        }
                                        $flower_det = $flower_det . '<button class="btn btn-lg ' . $color . ' btn-block" ' . $funct . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> ' . $fire_name . ' <span class="badge badge-light"> ' . $inviteesCount . '</span><span class="counts">(' . $fire_pc . ')  (' . $fire_ec . ') ' . '</span></button>';
                                    }
                                    $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
                                }
                            } else {//there are no fires - or earth's for this air
                                $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
                                $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
                            }
                        }
                        $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seedling.png" style="width:3vw; height:3vw;"></i>  Vacant<span class="counts">(0)  (0)</span></button>';
                        $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
                        $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
                    }
                } else {//there are no airs - or earth's for this earth
                    $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seedling.png" style="width:3vw; height:3vw;"></i>  Vacant<span class="counts">(0)  (0)</span></button>';
                    $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
                    $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
                    $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seedling.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
                    $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
                    $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
                }
            }
        } else {//there's only one earth
            while($found_earth = mysqli_fetch_array($result2)) {
                $earth_name = $found_earth['display_name'];
                $earth_gen = $found_earth['gen'];
                $earth_lotus_id = $found_earth['lotus_id'];
                $earth_tlf_id = $found_earth['tlf_id'];
                $earth_flower = $found_earth['flower'];
                if($earth_flower == 1){$color = 'btn-warning';}else{$color = 'btn-secondary';}
                $diff = $earth_gen - $user_gen;
                if($diff > $gen_depth) {
                    $funct = 'onclick="alert(\'You are only allowed to view trees within your ecosystem\');"';
                } else {
                    $funct = 'onclick="flower_dets(\'' . $earth_lotus_id . '\', \'' . $earth_tlf_id . '\');"';
                }
                $inviteesCount = getInviteeCount($connection, $earth_tlf_id);
                $earth_pc = getPetalCount($connection, $earth_lotus_id);
                $earth_ec = getEcoCount($connection, $earth_lotus_id);
                $flower_det = $flower_det . '<button class="btn btn-lg ' . $color . ' btn-block" ' . $funct . '><img src="images/Plant.png" style="width:3vw; height:3vw;"></i> ' . $earth_name . ' <span class="badge badge-light"> ' . $inviteesCount . '</span><span class="counts">(' . $earth_pc . ')  (' . $earth_ec . ') ' . '</span></button>';
                
                //get the two airs
                $query3 = sprintf("SELECT * FROM users WHERE air_id='%s'", 
                mysqli_real_escape_string($connection, $earth_lotus_id));

                $result3 = mysqli_query($connection, $query3);
                if(mysqli_num_rows($result3) > 0) {//there's at least one air
                    if(mysqli_num_rows($result3) > 1) {//there are two airs
                        $e = 1;
                        while($found_air = mysqli_fetch_array($result3)) {
                            $air_name = $found_air['display_name'];
                            $air_gen = $found_air['gen'];
                            $air_lotus_id = $found_air['lotus_id'];
                            $air_tlf_id = $found_air['tlf_id'];
                            $air_flower = $found_air['flower'];
                            if($air_flower == 1){$color = 'btn-dark';}else{$color = 'btn-secondary';}
                            $diff = $air_gen - $earth_gen;
                            if($diff > $gen_depth) {
                                $funct = 'onclick="alert(\'You are only allowed to view trees within your ecosystem\');"';
                            } else {
                                $funct = 'onclick="flower_dets(\'' . $air_lotus_id . '\', \'' . $air_tlf_id . '\');"';
                            }
                            $inviteesCount = getInviteeCount($connection, $air_tlf_id);
                            $air_pc = getPetalCount($connection, $air_lotus_id);
                            $air_ec = getEcoCount($connection, $air_lotus_id);
                            $flower_det = $flower_det . '<button class="btn btn-lg ' . $color . ' btn-block" ' . $funct . '><img src="images/Seedling.png" style="width:3vw; height:3vw;"></i> ' . $air_name . ' <span class="badge badge-light"> ' . $inviteesCount . '</span><span class="counts">(' . $air_pc . ')  (' . $air_ec . ') ' . '</span></button>';
                            $e++;
                            
                            //get the two fires
                            $query4 = sprintf("SELECT * FROM users WHERE air_id='%s'", 
                            mysqli_real_escape_string($connection, $air_lotus_id));

                            $result4 = mysqli_query($connection, $query4);
                            if(mysqli_num_rows($result4) > 0) {//there's at least one fire
                                if(mysqli_num_rows($result4) > 1) {//there are two fires
                                    $a = 1;
                                    while($found_fire = mysqli_fetch_array($result4)) {
                                        $fire_name = $found_fire['display_name'];
                                        $fire_gen = $found_fire['gen'];
                                        $fire_lotus_id = $found_fire['lotus_id'];
                                        $fire_tlf_id = $found_fire['tlf_id'];
                                        $fire_flower = $found_fire['flower'];
                                        if($fire_flower == 1){$color = 'btn-danger';}else{$color = 'btn-secondary';}
                                        $diff = $fire_gen - $user_gen;
                                        $inviteesCount = getInviteeCount($connection, $fire_tlf_id);
                                        $fire_pc = getPetalCount($connection, $fire_lotus_id);
                                        $fire_ec = getEcoCount($connection, $fire_lotus_id);
                                        if($diff > $gen_depth) {
                                            $funct = 'onclick="alert(\'You are only allowed to view trees within your ecosystem\');"';
                                        } else {
                                            $funct = 'onclick="flower_dets(\'' . $fire_lotus_id . '\', \'' . $fire_tlf_id . '\');"';
                                        }
                                        $flower_det = $flower_det . '<button class="btn btn-lg ' . $color . ' btn-block" ' . $funct . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> ' . $fire_name . ' <span class="badge badge-light"> ' . $inviteesCount . '</span><span class="counts">(' . $fire_pc . ')  (' . $fire_ec . ') ' . '</span></button>';
                                        $a++;
                                    }
                                } else {//there's only one fire - or earth for this air
                                    while($found_fire = mysqli_fetch_array($result4)) {
                                        $fire_name = $found_fire['display_name'];
                                        $fire_gen = $found_fire['gen'];
                                        $fire_lotus_id = $found_fire['lotus_id'];
                                        $fire_tlf_id = $found_fire['tlf_id'];
                                        $fire_flower = $found_fire['flower'];
                                        if($fire_flower == 1){$color = 'btn-danger';}else{$color = 'btn-secondary';}
                                        $diff = $fire_gen - $user_gen;
                                        $inviteesCount = getInviteeCount($connection, $fire_tlf_id);
                                        $fire_pc = getPetalCount($connection, $fire_lotus_id);
                                        $fire_ec = getEcoCount($connection, $fire_lotus_id);
                                        if($diff > $gen_depth) {
                                            $funct = 'onclick="alert(\'You are only allowed to view trees within your ecosystem\');"';
                                        } else {
                                            $funct = 'onclick="flower_dets(\'' . $fire_lotus_id . '\', \'' . $fire_tlf_id . '\');"';
                                        }
                                        $flower_det = $flower_det . '<button class="btn btn-lg ' . $color . ' btn-block" ' . $funct . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> ' . $fire_name . ' <span class="badge badge-light"> ' . $inviteesCount . '</span><span class="counts">(' . $fire_pc . ')  (' . $fire_ec . ') ' . '</span></button>';
                                        $e++;
                                    }
                                    $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
                                }
                            } else {//there are no fires - or earth's for this air
                                $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
                                $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
                            }
                        }
                    } else {//there's only one air - or earth for this earth
                        while($found_air = mysqli_fetch_array($result3)) {
                            $air_name = $found_air['display_name'];
                            $air_gen = $found_air['gen'];
                            $air_lotus_id = $found_air['lotus_id'];
                            $air_tlf_id = $found_air['tlf_id'];
                            $air_flower = $found_air['flower'];
                            if($air_flower == 1){$color = 'btn-dark';}else{$color = 'btn-secondary';}
                            $diff = $air_gen - $earth_gen;
                            if($diff > $gen_depth) {
                                $funct = 'onclick="alert(\'You are only allowed to view trees within your ecosystem\');"';
                            } else {
                                $funct = 'onclick="flower_dets(\'' . $air_lotus_id . '\', \'' . $air_tlf_id . '\');"';
                            }
                            $inviteesCount = getInviteeCount($connection, $air_tlf_id);
                            $air_pc = getPetalCount($connection, $air_lotus_id);
                            $air_ec = getEcoCount($connection, $air_lotus_id);
                            $flower_det = $flower_det . '<button class="btn btn-lg ' . $color . ' btn-block" ' . $funct . '><img src="images/Seedling.png" style="width:3vw; height:3vw;"></i> ' . $air_name . ' <span class="badge badge-light"> ' . $inviteesCount . '</span><span class="counts">(' . $air_pc . ')  (' . $air_ec . ') ' . '</span></button>';
                            
                            //get the two fires
                            $query4 = sprintf("SELECT * FROM users WHERE air_id='%s'", 
                            mysqli_real_escape_string($connection, $air_lotus_id));

                            $result4 = mysqli_query($connection, $query4);
                            if(mysqli_num_rows($result4) > 0) {//there's at least one fire
                                if(mysqli_num_rows($result4) > 1) {//there are two fires
                                    $a = 1;
                                    while($found_fire = mysqli_fetch_array($result4)) {
                                        $fire_name = $found_fire['display_name'];
                                        $fire_gen = $found_fire['gen'];
                                        $fire_lotus_id = $found_fire['lotus_id'];
                                        $fire_tlf_id = $found_fire['tlf_id'];
                                        $fire_flower = $found_fire['flower'];
                                        if($fire_flower == 1){$color = 'btn-danger';}else{$color = 'btn-secondary';}
                                        $diff = $fire_gen - $user_gen;
                                        $inviteesCount = getInviteeCount($connection, $fire_tlf_id);
                                        $fire_pc = getPetalCount($connection, $fire_lotus_id);
                                        $fire_ec = getEcoCount($connection, $fire_lotus_id);
                                        if($diff > $gen_depth) {
                                            $funct = 'onclick="alert(\'You are only allowed to view trees within your ecosystem\');"';
                                        } else {
                                            $funct = 'onclick="flower_dets(\'' . $fire_lotus_id . '\', \'' . $fire_tlf_id . '\');"';
                                        }
                                        $flower_det = $flower_det . '<button class="btn btn-lg ' . $color . ' btn-block" ' . $funct . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> ' . $fire_name . ' <span class="badge badge-light"> ' . $inviteesCount . '</span><span class="counts">(' . $fire_pc . ')  (' . $fire_ec . ') ' . '</span></button>';
                                        $a++;
                                    }
                                } else {//there's only one fire - or earth for this air
                                    while($found_fire = mysqli_fetch_array($result4)) {
                                        $fire_name = $found_fire['display_name'];
                                        $fire_gen = $found_fire['gen'];
                                        $fire_lotus_id = $found_fire['lotus_id'];
                                        $fire_tlf_id = $found_fire['tlf_id'];
                                        $fire_flower = $found_fire['flower'];
                                        if($fire_flower == 1){$color = 'btn-danger';}else{$color = 'btn-secondary';}
                                        $diff = $fire_gen - $user_gen;
                                        $inviteesCount = getInviteeCount($connection, $fire_tlf_id);
                                        $fire_pc = getPetalCount($connection, $fire_lotus_id);
                                        $fire_ec = getEcoCount($connection, $fire_lotus_id);
                                        if($diff > $gen_depth) {
                                            $funct = 'onclick="alert(\'You are only allowed to view trees within your ecosystem\');"';
                                        } else {
                                            $funct = 'onclick="flower_dets(\'' . $fire_lotus_id . '\', \'' . $fire_tlf_id . '\');"';
                                        }
                                        $flower_det = $flower_det . '<button class="btn btn-lg ' . $color . ' btn-block" ' . $funct . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> ' . $fire_name . ' <span class="badge badge-light"> ' . $inviteesCount . '</span<span class="counts">(' . $fire_pc . ')  (' . $fire_ec . ') ' . '</span></button>';
                                    }
                                    $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
                                }
                            } else {//there are no fires - or earth's for this air
                                $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
                                $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
                            }
                        }
                        $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seedling.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
                        $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
                        $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
                    }
                } else {//there are no airs - or earth's for this earth
                    $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seedling.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
                    $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
                    $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
                    $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seedling.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
                    $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
                    $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
                }
            }
            if($_SESSION['admin'] == 1) {
                $data_target = 'data-target="#addFlowerAdmin"';
            } else {
                $data_target = 'data-target="#addFlower"';
            }
            $flower_det = $flower_det . '<button class="btn btn-lg btn-success btn-block" data-toggle="modal" ' . $data_target . '><img src="images/Plant.png" style="width:3vw; height:3vw;"></i>  +Add<span class="counts">(0)  (0)</span></button>';
            $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seedling.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
            $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
            $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
            $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seedling.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
            $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
            $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
        }   
    } else {//there are no earths
        if($_SESSION['admin'] == 1) {
            $flower_det = $flower_det . '<button class="btn btn-danger btn-block" data-toggle="modal" data-target="#removeFlower">EDIT</button>';
            $data_target = 'data-target="#addFlowerAdmin"';
        } else {
            $data_target = 'data-target="#addFlower"';
        }
        $flower_det = $flower_det . '<button class="btn btn-lg btn-success btn-block" data-toggle="modal" ' . $data_target . '><img src="images/Plant.png" style="width:3vw; height:3vw;"></i> +Add<span class="counts">(0)  (0)</span></button>';
        $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seedling.png" style="width:3vw; height:3vw;"></i>  Vacant<span class="counts">(0)  (0)</span></button>';
        $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
        $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
        $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seedling.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
        $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
        $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
        $flower_det = $flower_det . '<button class="btn btn-lg btn-success btn-block" data-toggle="modal" ' . $data_target . '><img src="images/Plant.png" style="width:3vw; height:3vw;"></i> +Add<span class="counts">(0)  (0)</span></button>';
        $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seedling.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
        $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
        $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
        $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seedling.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
        $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
        $flower_det = $flower_det . '<button class="btn btn-lg btn-secondary btn-block" ' . $funct2 . '><img src="images/Seed.png" style="width:3vw; height:3vw;"></i> Vacant<span class="counts">(0)  (0)</span></button>';
        $flower_det = $flower_det . "</div>";
    } 
                
echo $flower_det;
?>
     

