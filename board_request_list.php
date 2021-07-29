<?php require_once("_/components/php/includes/session.php"); ?>
<?php require_once("_/components/php/includes/connection.php"); ?>
<?php require_once("_/components/php/includes/functions.php"); ?>
<?php 
// support.php - from nav bar
// in order to show contact info for flowers and roots
//
// (c) 2020, TLF
// Written by James Misa

?>
<!DOCTYPE html>
<html lang="en">
  <head>
   
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>TLF --Seeds</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Krub:ital,wght@1,600&display=swap" rel="stylesheet">
    <link href="_/css/bootstrap.css" rel="stylesheet">
    <link href="_/css/mystyles.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
    <script src="https://kit.fontawesome.com/7b30bafaf6.js" crossorigin="anonymous"></script>
  </head>
  <body id="home" onload="checkLoginState();">
      
<section class="container" ng-app="">
  <?php include "_/components/php/header.php"; ?>
    <h2> Board Request List</h2>

<?php
    
    $query = "SELECT DISTINCT users.tlf_id, board_request.creationDateTime, users.first_name, users.last_name, users.referrer_ten8, users.phone, board_request.board_selected, board_request.placement_method, board_request.board_id, board_request.placed ";
    $query .= "FROM users, board_request ";
    $query .= "WHERE board_request.tlf_id = users.tlf_id  ";
    $query .= "ORDER BY creationDateTime ASC";
    $resultSet = mysqli_query($connection, $query);
    confirm_query($resultSet, $connection);
    
    $fire_list = '<table class="table table-striped" style="font-family:sans-serif;">
                        <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Date</th>
                              <th scope="col">Name</th>
                              <th scope="col">Phone</th>
                              <th scope="col">Board</th>
                              <th scope="col">Method</th>
                              <th scope="col">Board ID</th>
                              <th scope="col">Inviter</th>
                              <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>';
    
    $number = 1;
    while($found_request = mysqli_fetch_array($resultSet)) {
        $dateTime = $found_request['creationDateTime'];
        $date = strtotime($dateTime);
        $date2 = $date - 60 * 60 * 7;
        $time = date("M d, Y",$date2);
        $name = $found_request['first_name'] . " " . $found_request['last_name'];   
        $boardLevel = $found_request['board_selected'];
        $placementMethod = $found_request['placement_method'];
        $boardID = $found_request['board_id'];
        $inviter = $found_request['referrer_ten8'];
        $phone = $found_request['phone'];
        $placed = $found_request['placed'];
        if($placed == 0) {
            $status = "Pending";
        } else {
            $status = "Placed";
        }
        if($inviter){$inviterName = getInviterName($connection, $inviter);}else{$inviterName = "None Listed";} 
    
        $fire_list = $fire_list . '<tr>
                          <td>' . $number . '</td>
                          <td>' . $time . '</td>
                          <td>' . $name . '</td>
                          <td>' . $phone . '</td>
                          <td>' . $boardLevel . '</td>
                          <td>' . $placementMethod . '</td>
                          <td>' . $boardID . '</td>
                          <td>' . $inviterName . '</td>
                          <td>' . $status . '</td>
                        </tr>';
        $number++;
    }
    $fire_list = $fire_list . '</tbody></table>';
    echo $fire_list;
    
?>
      
<?php include "_/components/php/footer.php"; ?>
      </section><!--container-->
     
  </body>
</html>