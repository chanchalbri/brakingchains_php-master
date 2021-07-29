<?php require_once("_/components/php/includes/session.php"); ?>
<?php require_once("_/components/php/includes/connection.php"); ?>
<?php require_once("_/components/php/includes/functions.php"); ?>
<?php 
// orgView.php - from tree-list.php -> myTrees.php
// in order to genealogy view of tree
//
// (c) 2020, Eden Project
// Written by James Misa

?>
<!DOCTYPE html>
<html lang="en">
  <head>
   
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Tree</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Krub:ital,wght@1,600&display=swap" rel="stylesheet">
    <link href="_/css/bootstrap.css" rel="stylesheet">
    <link href="_/css/mystyles.css" rel="stylesheet">
 
     <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>  
      <script src="OrgChartJS/orgchart.js"></script>  
  
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>  -->
    <!-- <script src="https://kit.fontawesome.com/7b30bafaf6.js" crossorigin="anonymous"></script>   -->
       
  </head>
  <body id="home">
      
<section class="container" ng-app="">
  <?php include "_/components/php/header.php"; ?>
    <?php
    $query = sprintf("SELECT * FROM users WHERE id='%s'", 
    mysqli_real_escape_string($connection, $_SESSION['focus_id']));

    $result = mysqli_query($connection, $query);

   
    while($found_flower = mysqli_fetch_array($result)) {
        $sowDate = $found_flower['sowDate'];
        $flower = $found_flower['flower'];
        $tlf_id = $found_flower['tlf_id'];
        $lotus_id = $found_flower['lotus_id'];
        if($flower == 1){$color = 'btn-success';}else{$color = 'btn-secondary';}
    }
    $sowDate = getSowDate($connection, $lotus_id);
    $water_name = getWaterName($connection, $lotus_id);
    $water_method = getWaterMethod($connection, $lotus_id);

    $flower_det = '<div class="col d-flex justify-content-center">
                    <div class="card .mx-auto" style="width: 38rem;">
                      <div class="card-header bg-dark text-white" style="text-align:left;">
                        Sow Date: ' . $sowDate . 
                      '<span class="counts"><button class="goldBtn btn btn-sm"data-toggle="modal" data-target="#editDate">Edit Date</button></span></div>
                      <ul class="list-group list-group-flush">
                        <li class="list-group-item">Tree Name: ' . $water_name . '</li>
                        <li class="list-group-item">Tree Gift Method: ' . $water_method . '</li>
                        <li class="list-group-item">Display Name: ' . $_SESSION['display_name'] . '<span class="counts"><button class="goldBtn btn btn-sm" data-toggle="modal" data-target="#editName" data-val="' . $_SESSION['display_name'] . '">Edit Name</button></span></li>
                        <a href="#" class="goldBtn btn" onclick="window.location.href = \'myTrees.php\';">Back to my trees</a>
                      </ul>
                      </div>
                    </div>';
    echo $flower_det;
    
    include "_/components/php/modal_editDate.php";
    include "_/components/php/modal_editName.php";
    include "_/components/php/modal_addTree.php";
    include "_/components/php/modal_selectSeed.php";
    include "_/components/php/modal_selectTree.php";
    ?>
    <div style="width:100%; height:700px;" id="orgchart">
    </div>
    
 <button type="button" class="btn profile-btn mt-3" data-toggle="modal" data-target="#myModal-details">View Details</button>     
<?php include "_/components/php/footer.php"; ?>
      </section><!--container--> 
       
      <script>
     OrgChart.templates.belinda = Object.assign({}, OrgChart.templates.ana);
        OrgChart.templates.belinda.size = [200, 200];
        OrgChart.templates.belinda.node = '<rect x="0" y="0" height="150" width="300" fill="#9101b1" stroke-width="1" stroke="#aeaeae" rx="5" ry="5"></rect>';  

        OrgChart.templates.belinda.ripple = {
        
        color: "#0890D3",
        
    };   

    OrgChart.templates.belinda.field_0 =
    // for value {val} 
    '<text class="field_0" style="font-size: 20px;" fill="#ffffff" x="150" y="70" text-anchor="middle" align="center">{val}</text>';
    OrgChart.templates.belinda.field_1 = 
        '<text class="field_1" style="font-size: 14px;" fill="#fff000" x="150" y="95" text-anchor="middle">{val}</text>';
    OrgChart.templates.belinda.field_2 = 
        '<text class="field_2" style="font-size: 20px;" fill="#ffffff" x="150" y="125" text-anchor="middle">{val}</text>';
    OrgChart.templates.belinda.field_3 = 
        '<text class="field_3" style="font-size: 20px;" fill="#ffffff" x="150" y="125" text-anchor="middle">{val}</text>';
    OrgChart.templates.belinda.field_5 = 
        '<text class="field_5" style="font-size: 14px;" fill="#ffffff" x="150" y="45" text-anchor="middle">{val}</text>';
     OrgChart.templates.belinda.html = 
        '<foreignobject class="node" x="58" y="136" width="200" height="100">{val}</foreignobject>';
     OrgChart.templates.belinda.link = '<path stroke-linejoin="round" stroke="#fff000" stroke-width="1px" fill="none" d="{rounded}" />';        



    var chart = new OrgChart(document.getElementById("orgchart"), 
     {
        template: "belinda",
        enableSearch: false,
        lazyLoading: true,
        scaleInitial: 0.7,
        zoom: false,
        nodeBinding: {
            field_0: "name",
            field_1: "inviter",
            field_2: "petal",
            field_3: "eco",
            field_5: "treeId",            
            html: "tree"
        },
        nodeMouseClick: OrgChart.action.none,
        nodes: JSON.parse(localStorage.getItem("viewData"))
        
    });
     function dump(obj) {
         var out = '';
         for (var i in obj) {
         out += i + ": " + obj[i] + "\n";
         }
        alert(out);
        };
     //dump(chart['nodes'][9]['tags']);
</script>  
  </body>
</html>
 