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
$user = $_REQUEST['user'];
$_SESSION['focus_id'] = $id;
//get data for water
$query = "SELECT * ";
$query .= "FROM users ";
$query .= "WHERE id = '{$id}' LIMIT 1";
$resultSet = mysqli_query($connection, $query);
confirm_query($resultSet, $connection);
$data = array();
$found_tree = mysqli_fetch_array($resultSet);
$name = $found_tree['display_name'];
if($user == "this_user") {$_SESSION['display_name'] = $name;}
$treeId = $found_tree['id'];
$profile = 'images/'.$found_tree['profile'];
$lotus_id = $found_tree['lotus_id'];
$inivter_id = $found_tree['referrer'];
$board_brand = $found_tree['board_brand'];
if($board_brand == "gate"){$water_board = "107";} else {$water_board = "777";}
$inviter = getInviterTLF($connection, $inviter_id);
$petal = getPetalCount($connection, $lotus_id);
$eco = getEcoCount($connection, $lotus_id);
$water_tree_id = $treeId;
$data[0]['id'] = 1;
$data[0]['name'] = $name;
$data[0]['treeId'] = $treeId;
$data[0]['inviter'] = '(' . $inviter . ')';
$data[0]['petal'] = '(' . $petal . ')';
$data[0]['eco'] = '(' . $eco . ')';
$data[0]['img'] = $profile;
//get data for earths
$query = "SELECT * ";
$query .= "FROM users ";
$query .= "WHERE air_id = '{$lotus_id}' LIMIT 2";
$resultSet = mysqli_query($connection, $query);
confirm_query($resultSet, $connection);
if(mysqli_num_rows($resultSet) > 0) {//there's at least one earth
    $i = 2;
    $a = 4;
    $f = 8;
    $d = 1;
    $e = 0;
    while($found_earth = mysqli_fetch_array($resultSet)) {//$i for 2 and 3
        $name = $found_earth['display_name'];
        $treeId = $found_earth['id'];
        $profile = 'images/'.$found_tree['profile'];
        $earth_lotus_id = $found_earth['lotus_id'];
        $inviter_id = $found_earth['referrer'];
        $board_brand = $found_earth['board_brand'];
        if($board_brand == "gate"){$earth_board = "107";} else {$earth_board = "777";}
        $inviter = getInviterTLF($connection, $inviter_id);
        $petal = getPetalCount($connection, $earth_lotus_id);
        $eco = getEcoCount($connection, $earth_lotus_id);
        $earth_tree_id = $treeId;
        $data[$d]['id'] = $i;
        $data[$d]['pid'] = 1;
        $data[$d]['name'] = $name;
        $data[$d]['treeId'] = $treeId;
        $data[$d]['inviter'] = $inviter;
        $data[$d]['petal'] = '(' . $petal . ')';
        $data[$d]['eco'] = '(' . $eco . ')';
        $data[$d]['img'] = $profile;
        $data[$d]['tree'] = '<a class="viewDetails" style="margin:0 !important;cursor:pointer" data-toggle="modal" data-target="#editUser1" onclick ="treeView('.$treeId.');">View Details</a>';
        $d++;
        $query2 = "SELECT * ";
        $query2 .= "FROM users ";
        $query2 .= "WHERE air_id = '{$earth_lotus_id}' LIMIT 2";
        $resultSet2 = mysqli_query($connection, $query2);
        confirm_query($resultSet2, $connection);
        if(mysqli_num_rows($resultSet2) > 0) {//there is at least one air for this earth
            $x = 0;
            while($found_airs = mysqli_fetch_array($resultSet2)) {//$a for 4, 5, 6, and 7
                $name = $found_airs['display_name'];
                $treeId = $found_airs['id'];
                $profile = 'images/'.$found_tree['profile'];
                $air_lotus_id = $found_airs['lotus_id'];
                $inviter_id = $found_airs['referrer'];
                $board_brand = $found_airs['board_brand'];
                if($board_brand == "gate"){$air_board = "107";} else {$air_board = "777";}
                $inviter = getInviterTLF($connection, $inviter_id);
                $petal = getPetalCount($connection, $air_lotus_id);
                $eco = getEcoCount($connection, $air_lotus_id);
                $air_tree_id = $treeId;
                $data[$d]['id'] = $a;
                $data[$d]['pid'] = $i;
                $data[$d]['name'] = $name;
                $data[$d]['treeId'] = $treeId;
                $data[$d]['inviter'] = $inviter;
                $data[$d]['petal'] = '(' . $petal . ')';
                $data[$d]['eco'] = '(' . $eco . ')';
                $data[$d]['img'] = $profile;
                $data[$d]['tree'] = '<a style="margin:0 !important;cursor:pointer" class="viewDetails" data-toggle="modal" data-target="#editUser1" onclick ="treeView('.$treeId.');">View Details</a>';
                $d++;
                $query3 = "SELECT * ";
                $query3 .= "FROM users ";
                $query3 .= "WHERE air_id = '{$air_lotus_id}' LIMIT 2";
                $resultSet3 = mysqli_query($connection, $query3);
                confirm_query($resultSet3, $connection);
                if(mysqli_num_rows($resultSet3) > 0) {//there's at least one fire
                    while($found_fires = mysqli_fetch_array($resultSet3)) {
                        $name = $found_fires['display_name'];
                        $treeId = $found_fires['id'];
                         $profile = 'images/'.$found_tree['profile'];
                        $fire_lotus_id = $found_fires['lotus_id'];
                        $inviter_id = $found_fires['referrer'];
                        $inviter = getInviterTLF($connection, $inviter_id);
                        $petal = getPetalCount($connection, $fire_lotus_id);
                        $eco = getEcoCount($connection, $fire_lotus_id);
                        $data[$d]['id'] = $f;
                        $data[$d]['pid'] = $a;
                        $data[$d]['name'] = $name;
                        $data[$d]['treeId'] = $treeId;
                        $data[$d]['inviter'] = $inviter;
                        $data[$d]['petal'] = '(' . $petal . ')';
                        $data[$d]['eco'] = '(' . $eco . ')';
                        $data[$d]['img'] = $profile;
                        $data[$d]['tree'] = '<button style="margin:0 !important" data-toggle="modal" data-target="#editUser1" onclick ="treeView({val});">View Details</button>';
                        $d++;
                        $f++;
                        if(mysqli_num_rows($resultSet3) == 1) {
                            $data[$d]['id'] = $f;
                            $data[$d]['pid'] = $a;
                            $data[$d]['name'] = "Vacant";
                            $data[$d]['tags'] = "vacant";
                            $data[$d]['tree'] = '<button style="margin:0 !important" data-toggle="modal" data-target="#addTree" onclick="storeParent(' . $air_tree_id . ', ' . $air_board . ');">Add Tree</button>';
                            $d++;
                            $f++;
                        }
                        $x++;
                    }
                    $a++;
                } else {
                    $data[$d]['id'] = $f;
                    $data[$d]['pid'] = $a;
                    $data[$d]['name'] = "Vacant";
                    $data[$d]['tree'] = '<button  style="margin:0 !important" data-toggle="modal" data-target="#addTree" onclick="storeParent(' . $air_tree_id . ', ' . $air_board . ');">Add Tree</button>';
                    $d++;
                    $x++;
                    $f++;
                    $f++;
                    $a++;
                }
                if(mysqli_num_rows($resultSet2) == 1) {//there's only one air for this earth
                    $f++;
                    $data[$d]['id'] = $a;
                    $data[$d]['pid'] = $i;
                    $data[$d]['name'] = "Vacant";
                    $data[$d]['tree'] = '<button style="margin:0 !important" data-toggle="modal" data-target="#addTree" onclick="storeParent(' . $earth_tree_id . ', ' . $earth_board . ');">Add Tree</button>';
                    $d++;
                    $a++;
                    $f++;
                }
                $e++;
            }
        } else {//there are no airs for this earth...add tree with earth id
            $data[$d]['id'] = $a;
            $data[$d]['pid'] = $i;
            $data[$d]['name'] = "Vacant";
            $data[$d]['tree'] = '<button style="margin:0 !important" data-toggle="modal" data-target="#addTree" onclick="storeParent(' . $earth_tree_id . ', ' . $earth_board . ');">Add Tree</button>';
            $d++;
            $a++;
            $a++;
        }
        $i++;
        if(mysqli_num_rows($resultSet) == 1) {//there's only one earth...add tree with water id
            $data[$d]['id'] = $i;
            $data[$d]['pid'] = 1;
            $data[$d]['name'] = "Vacant";
            $data[$d]['tree'] = '<button style="margin:0 !important" data-toggle="modal" data-target="#addTree" onclick="storeParent(' . $water_tree_id . ', ' . $water_board . ');">Add Tree</button>';
            $d++;
        }
    }
} else {//there are no earths...add tree with water id
    $data[1]['id'] = 2;
    $data[1]['pid'] = 1;
    $data[1]['name'] = "Vacant";
    $data[1]['tree'] = '<button style="margin:0 !important" data-toggle="modal" data-target="#addTree" onclick="storeParent(' . $water_tree_id . ', ' . $water_board . ');">Add Tree</button>';
}
echo json_encode($data);
    
?>