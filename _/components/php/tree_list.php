<?php 

$back_img='assets/one-page/images/flip-bg.jpg';
$front_img='assets/one-page/images/gatee.png'; 

    $tlf_id = $_SESSION['tlf_id'];
    $query = "SELECT * ";
    $query .= "FROM users ";
    $query .= "WHERE tlf_id = '{$tlf_id}' AND flower = 1 ";
    $query .= "ORDER BY gift_amt ASC";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    // $myGardenTrees = '<div class="container-fluid">
    //       <div class="row h-100">
    //       <div class="col-sm-6 col-lg-4 col-xl-3 d-flex justify-content-center">
    //         <div class="newTree card" style="font-family:sans-serif; font-size:20px;">
    //           <div class="card-header text-center tree-header border-light" style="color:#fff;">
    //             The Trees
    //           </div>
    //           <img src="./images/rsz_tree_of_life.png" class="img-fluid card-img-top" alt="image of tree">
    //           <div class="card-body text-center">
                
    //           </div>
    //           <div class="card-footer bg-transparent border-light text-center"><a href="#" class="goldBtn btn" data-toggle="modal" data-target="#startBoard">Add New Tree</a></div>
    //         </div>
    //       </div>';
    $myGardenTrees = '<div class="row grid-container" data-layout="masonry" style="overflow: visible">';
    $tree_num = 1;
    while($found_tree = mysqli_fetch_array($resultSet)) {
        $id = $found_tree['id'];
        $lotus_id = $found_tree['lotus_id'];
        $gen = $found_tree['gen'];
        $display_name = $found_tree['display_name'];
        $gift_amt = $found_tree['gift_amt'];
        $board_brand = $found_tree['board_brand'];
        if($board_brand == "garden") {
            $title = "Garden";
            $img = "assets/one-page/images/garden.png";
        } else if ($board_brand == "gate") {
            $title = "Gate";
            $img = "assets/one-page/images/gatee.png";
        }
        $petal_count = getPetalCount($connection, $lotus_id);
        $eco_count = getEcoCount($connection, $lotus_id);
        $pre_date = $found_tree['sowDate'];
        if($pre_date){$sowDate = date("m/d/Y", $pre_date);}
        $myGardenTrees = $myGardenTrees . '<div class="col-lg-4 mb-4" >

                  <div class="flip-card top-to-bottom">

                    <div class="flip-card-front dark " data-height-xl="200" style=" background-image: url(\''.$img.'\')" >

                      <div class="flip-card-inner">

                        <div class="card bg-transparent border-0">

                          <div class="card-body">

                            <h3 class="card-title mb-0"> ' . $title . ' </h3>

                            <span class="font-italic">' . $display_name . '<br /> ID : ' . $id . ' </span>
                            <p class="font-italic">(' . $total . ')</p>

                          </div>

                        </div>

                      </div>

                    </div>

                    <div class="flip-card-back " data-height-xl="200" style=" background-image: url(\''.$back_img.'\')">

                      <div class="flip-card-inner">
                          <p class="mb-2 text-white message">'.$message.'</p>
                        <button type="button" class="btn btn-outline-light mt-2 boardBtn" onclick="treeView(\'' . $id . '\', \'this_user\')" >View Details</button>

                      </div>

                    </div>

                  </div>

                </div>';

             $myBoardsx .= '<div class="col-sm-6 col-lg-4 col-xl-3 d-flex justify-content-center">
            <div class="' . $boardClass . ' card" style="font-family:sans-serif; font-size:20px;">
              <div class="card-header text-center tree-header border-light">
                ' . $title . '
              </div>
              <i class="card-icon fas fa-chess-' . $boardClass . '"></i>
              <div class="card-body text-center">
                <h3 class="card-title">' . $display_name . '</h3>
                <h4 class="card-title">ID: ' . $id . '</h4>
             
                <h4 class="card-title">(' . $total . ')</h4>
              </div>
              <div class="card-footer bg-transparent border-light text-center"><a href="#" class="boardBtn btn" onclick="treeView(\'' . $id . '\', \'this_user\')">View Board</a></div>

            </div>
          </div>';
        $tree_num++;
    }

    $myGardenTrees = $myGardenTrees . '</div>';

    
    //This query is to pull user's invitees
    $query = sprintf("SELECT * FROM users WHERE referrer='%s' && flower = 1", 
        mysqli_real_escape_string($connection, $tlf_id));

        $result = mysqli_query($connection, $query);
        $invitees = mysqli_num_rows($result);

        // echo '<div class="text-center" style="margin-bottom:5px; font-family:sans-serif;"><button type="button" class="btn btn-lg btn-dark btn-block" onclick="location.href = \'invitees.php\';" data-toggle="tooltip" data-placement="top" title="List of Invitees on Trees">
        //   My Invitees  <span class="invBadge badge badge-light">' . $invitees . '</span>
        // </button></div>';

    echo $myGardenTrees;
    
?>


