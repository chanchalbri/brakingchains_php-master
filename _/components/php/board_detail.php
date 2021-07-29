<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>

<?php 

$lotus_id = $_REQUEST['lotus_id'];
$water_id = $_REQUEST['water_id'];
$tlf_id = $_SESSION['tlf_id'];
$water_method = getWaterMethod2($connection, $water_id);

$query = "SELECT *";
$query .= "FROM users ";
$query .= "WHERE lotus_id = '{$water_id}'";
$resultSet = mysqli_query($connection, $query);
confirm_query($resultSet, $connection);

while($found_water = mysqli_fetch_array($resultSet)) {
    $water_name = $found_water['first_name'] . " " . $found_water['last_name'];
    $query2 = "SELECT *";
    $query2 .= "FROM users ";
    $query2 .= "WHERE air_id = '{$water_id}'";
    $resultSet2 = mysqli_query($connection, $query2);
    confirm_query($resultSet2, $connection);
    
    $e=1;
    while($found_earth = mysqli_fetch_array($resultSet2)) {
        ${"earth_$e"} = $found_earth['first_name'] . " " . $found_earth['last_name'];
        $earth_lotus_id = $found_earth['lotus_id'];
        $query3 = "SELECT *";
        $query3 .= "FROM users ";
        $query3 .= "WHERE air_id = '{$earth_lotus_id}'";
        $resultSet3 = mysqli_query($connection, $query3);
        confirm_query($resultSet3, $connection);
        
        $a=1;
        while($found_air = mysqli_fetch_array($resultSet3)) {
            ${"air_$a" . $e} = $found_air['first_name'] . " " . $found_air['last_name'];
            $air_lotus_id = $found_air['lotus_id'];
            $query4 = "SELECT *";
            $query4 .= "FROM users ";
            $query4 .= "WHERE air_id = '{$air_lotus_id}'";
            $resultSet4 = mysqli_query($connection, $query4);
            confirm_query($resultSet4, $connection);
            
            $f=1;
            while($found_fire = mysqli_fetch_array($resultSet4)) {
                ${"fire_$f" . $a . $e} = $found_fire['first_name'] . " " . $found_fire['last_name'];
                $f++;
            }
            
            $a++;
        }
        
        $e++;
    }
}

$referral_count = getRefCount($connection, $tlf_id, $water_id);
$borrowed_referrals =getBorrowedReferrals($connection, $tlf_id, $lotus_id);
$start_date = getBoardStart($connection, $water_id);

$board = '<div class="col d-flex justify-content-center">
                    <div class="card .mx-auto" style="width: 38rem;">
                      <div class="card-header bg-dark text-white">
                        BOARD ID #: ' . $water_id . 
                      '</div>
                      <ul class="list-group list-group-flush">
                        <li class="list-group-item">Board start date: <span id="infoTable">' . $start_date . '</span></li>
                        <li class="list-group-item">Water Name: <span id="infoTable">' . $water_name . '</span></li>
                        <li class="list-group-item">Water Gift Method: <span id="infoTable">' . $water_method . '</span></li>
                        <li class="list-group-item">My Referrals: <span class="badge badge-pill badge-danger">' . $referral_count . '</span></li>'
                         . $borrowed_referrals .
                        '<a href="#" class="btn btn-primary" onclick="window.location.reload();">Back to my boards</a>
                      </ul>
                      </div>
                    </div>';


$board = $board . '<div class="board container">
          <div class="row one">
            <div class="col fire">'
               . $fire_121 . 
            '</div>
            <div class="col">
            </div>
            <div class="col">
            </div>
            <div class="col">
            </div>
            <div class="col fire">'
              . $fire_111 . 
            '</div>
          </div>
          <div class="row two">
            <div class="col">
            </div>
            <div class="col air">'
               . $air_21 .
            '</div>
            <div class="col">
            </div>
            <div class="col air">'
              . $air_11 .
            '</div>
            <div class="col">
            </div>
          </div>
          <div class="row three">
            <div class="col fire">'
              . $fire_221 . 
            '</div>
            <div class="col">
            </div>
            <div class="col earth">'
              . $earth_1 .
            '</div>
            <div class="col">
            </div>
            <div class="col fire">'
              . $fire_211 . 
            '</div>
          </div>
          <div class="row four">
            <div class="col">
            </div>
            <div class="col">
            </div>
            <div class="col water">'
               . $water_name . 
            '</div>
            <div class="col">
            </div>
            <div class="col">
            </div>
          </div>
          <div class="row five">
            <div class="col fire">'
              . $fire_122 . 
            '</div>
            <div class="col">
            </div>
            <div class="col earth">'
              . $earth_2 .
            '</div>
            <div class="col">
            </div>
            <div class="col fire">'
              . $fire_212 . 
            '</div>
          </div>
          <div class="row six">
            <div class="col">
            </div>
            <div class="col air">'
              . $air_22 .
            '</div>
            <div class="col">
            </div>
            <div class="col air">'
              . $air_12 .
            '</div>
            <div class="col">
            </div>
          </div>
          <div class="row seven">
            <div class="col fire">'
              . $fire_222 . 
            '</div>
            <div class="col">
            </div>
            <div class="col">
            </div>
            <div class="col">
            </div>
            <div class="col fire">'
              . $fire_112 . 
            '</div>
          </div>
        </div>';

echo $board;
?>