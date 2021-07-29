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

  <?php include "_/components/php/new_header.php"; ?>
  <section id="content">

      <div class="content-wrap py-0">


        <div id="section-about" class="center">

                <div class="section">

            <div class="container clearfix">

             <div class="mx-auto center">

                <h2 class="font-weight-light ls1">Trees</h2>

              </div>

                              <br>
              <div class="row grid-container" data-layout="masonry" style="overflow: visible">                
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
                        Sow Date: ' . $sowDate . '<span class="counts"><button class="goldBtn btn btn-sm"data-toggle="modal" data-target="#editDate">Edit Date</button></span></div>
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
    <div style="width:100%; height:700px;" id="orgchart"/>
    
   </div> 
</div>
</div>
</div>
</div>
</section><!-- #content end -->   
<?php include "_/components/php/new_footer.php"; ?>
     
 <script>
    OrgChart.templates.belinda.field_0 = 
    '<text class="field_0" style="font-size: 20px;" fill="#ffffff" x="90" y="70" text-anchor="middle">{val}</text>';
    OrgChart.templates.belinda.field_1 = 
        '<text class="field_1" style="font-size: 14px;" fill="#ffffff" x="90" y="95" text-anchor="middle">{val}</text>';
    OrgChart.templates.belinda.field_2 = 
        '<text class="field_2" style="font-size: 20px;" fill="#ffffff" x="70" y="125" text-anchor="middle">{val}</text>';
    OrgChart.templates.belinda.field_3 = 
        '<text class="field_3" style="font-size: 20px;" fill="#ffffff" x="110" y="125" text-anchor="middle">{val}</text>';
    OrgChart.templates.belinda.field_5 = 
        '<text class="field_5" style="font-size: 14px;" fill="#ffffff" x="90" y="45" text-anchor="middle">{val}</text>';
     OrgChart.templates.belinda.html = 
        '<foreignobject class="node" x="58" y="136" width="200" height="100">{val}</foreignobject>';
     OrgChart.templates.belinda.link = '<path stroke-linejoin="round" stroke="#aeaeae" stroke-width="1px" fill="none" d="{rounded}" />';
    var chart = new OrgChart(document.getElementById("orgchart"), 
     {
        template: "belinda",
        enableSearch: false,
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