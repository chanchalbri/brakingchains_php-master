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
  
<style type="text/css">
  .edit-wrapper {
    display: none !important;
}
</style>
    <?php
    $query = sprintf("SELECT * FROM users WHERE id='%s'",
    mysqli_real_escape_string($connection, $_SESSION['focus_id']));
    $result = mysqli_query($connection, $query);
    while($found_flower = mysqli_fetch_array($result)) {
        $id = $found_flower['id'];
        $referrer_name = $found_flower['referrer_name'];
        $sowDate = $found_flower['sowDate'];
        $flower = $found_flower['flower'];
        $tlf_id = $found_flower['tlf_id'];
        $lotus_id = $found_flower['lotus_id'];
        if($flower == 1){$color = 'btn-success';}else{$color = 'btn-secondary';}
    }
    $sowDate = getSowDate($connection, $lotus_id);
    $water_name = getWaterName($connection, $lotus_id);
    $water_method = getWaterMethod($connection, $lotus_id);
    $flower_det = '<div id="treeModel" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">BOARD ID #: '.$id.'</h4>
        <!-- <button type="button" class="close" data-dismiss="modal">&times;</button>
         -->
      </div>
      <div class="modal-body">
        <ul class="list-group list-group-flush">
                        <li class="list-group-item">Board start date:
                         <span id="infoTable" class="float-right">'. $sowDate .'</span>
                        </li>
                        <li class="list-group-item">Display Name:<span class="float-right"> ' . $_SESSION['display_name'] .'
                          <span class="counts">
                          </span></span>
                        </li>
                        <li class="list-group-item">Inviter:
                         <span id="infoTable" class="float-right">'.$referrer_name.'
                         </span>
                        </li>
                        <li class="list-group-item">Water Name:
                          <span id="infoTable" class="float-right">
                            <i class="fa fa-tint" style="color: #FF8080" aria-hidden="true"></i> ' . $water_name . '
                            <span class="badge"> 12</span>
                          </span>
                        </li>
                        <li class="list-group-item">Water Gift Method:
                          <span id="infoTable" class="float-right">' . $water_method . '</span>
                        </li>
                        <!-- <a href="cards.html" target="blank" class="btn profile-btn btn-sm mt-3">Back to my boards</a> -->
                      </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn profile-btn " data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>';
    echo $flower_det;
    include "_/components/php/modal_editDate.php";
    include "_/components/php/modal_editName.php";
    include "_/components/php/modal_addTree.php";
    include "_/components/php/modal_selectSeed.php";
    include "_/components/php/modal_selectTree.php";
    ?>
    <div class="col-md-12 text-center">
      <button type="button" class="btn profile-btn mt-3" data-toggle="modal" data-target="#treeModel">View Details</button>
       <div style="width:100%; height:700px;" id="orgchart"></div>
    </div>
   





    <!--new footer  -->
<?php include "_/components/php/new_footer.php"; ?>

<div class="modal fade" id="editUser1"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel3">User Details</h4>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form class="form-horizontal" data-toggle="validator" id="registerForm3" role="form">

                          <div class="form-group">
                            <label   for="first_name">First Name</label>
                            <div  inputGroupContainer>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input type="text" class="form-control" 
                                    id="first_name" readonly="readonly" value="" />
                                </div><!--input-group-->
                            </div><!--inputGroupContainer-->
                          </div><!--form-group-->

                            <div class="form-group">
                                <label   for="last_name">Last Name</label>
                                <div inputGroupContainer>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input type="text" class="form-control" readonly="readonly" 
                                        id="last_name"  value="" />
                                    </div><!--input-group-->
                                </div><!--inputGroupContainer-->
                            </div><!--form-group-->

                            <div class="form-group">
                                <label   for="email">Email</label>
                                <div  inputGroupContainer>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                        <input type="email" class="form-control" readonly="readonly"
                                        id="email2"  value="" />
                                    </div><!--input-group-->
                                </div><!--inputGroupContainer-->
                            </div><!--form-group-->

                          <div class="form-group">
                            <label  for="phone" >Phone</label>
                            <div inputGroupContainer>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
                                    <input type="text" class="form-control" readonly="readonly"
                                    id="phone"  data-minlength="6" value="" />
                                </div><!--input-group-->
                            </div><!--inputGroupContainer-->
                          </div><!--form-group-->
                     
                          <div class="form-group">
                            <label  for="phone" >My Interests/Hobbies (Singing, dancing)</label>
                            <div inputGroupContainer>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
                                    <input type="text" class="form-control" readonly="readonly"
                                    id="hobbies"  value="" />
                                </div><!--input-group-->
                            </div><!--inputGroupContainer-->
                          </div><!--form-group-->

                          <div class="form-group">
                            <label  for="phone" >My Favorite Books</label>
                            <div inputGroupContainer>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
                                    <input type="text" id="book" class="form-control" readonly="readonly"
                                       value="" />
                                </div><!--input-group-->
                            </div><!--inputGroupContainer-->
                          </div><!--form-group-->

                          <div class="form-group">
                            <label  for="phone" >My Website</label>
                            <div inputGroupContainer>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
                                    <a id="website" target="_blank"><span class="input-group-addon" id="webUrl"></span> </a>
                                   <!--  <input type="text" class="form-control" id="website" readonly="readonly"
                                       value="" /> -->
                                </div><!--input-group-->
                            </div><!--inputGroupContainer-->
                          </div><!--form-group-->
                          <div class="form-group">
                            <label  for="phone" >Inviter</label>
                            <div inputGroupContainer>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
                              <input type="text" id="inviter" class="form-control" readonly="readonly"
                                   value="" />
                                </div><!--input-group-->
                            </div><!--inputGroupContainer-->
                          </div><!--form-group-->
 

                        </form> 
                    </div><!--modal-body-->

                    <!-- Modal Footer -->
                  <div class="modal-footer" id="buttonDiv">
                   <!-- <button class="btn btn-default profile-btn" style="margin:0 auto!important; border : none" onclick="userTree('19041','this_user')">View Tree</button> -->
                    </div><!--modal-footer-->
                </div><!--modal-content-->
            </div><!--modal-dialog-->
        </div><!--modal register-->
 
 <script>
     
     // console.log(JSON.parse(localStorage.getItem("viewData")));
     
     OrgChart.templates.belinda = Object.assign({}, OrgChart.templates.ana);
        OrgChart.templates.belinda.size = [300, 300];
        // OrgChart.templates.olivia.node = '<rect x="0" y="0" height="120" width="250" fill="#fff" stroke-width="1" stroke="#aeaeae" rx="5" ry="5" data-toggle="modal" data-target="#editUser" "></rect>';
       // OrgChart.templates.olivia.field_6 =
       // '<div class="wrapper">{val}</div>';   
        OrgChart.templates.olivia.node = '<rect x="0" y="0" height="120"  width="250" fill="#fff" stroke-width="1" stroke="#aeaeae" id="" rx="5" ry="5"></rect>';
        OrgChart.templates.belinda.ripple = {
        color: "#0890D3",      
       };

    OrgChart.templates.belinda.img_0 =
        '<clipPath id="ulaImg" class="img_0">'
        + '<circle cx="100" cy="150" r="40"></circle>'
        + '</clipPath>'
        + '<image preserveAspectRatio="xMidYMid slice" clip-path="url(#ulaImg)"  xlink:href="{val}" x="60" y="100" width="80" height="80">'
        + '</image>';
    OrgChart.templates.olivia.field_0 =
    // for value {val}
    '<text width="145" style="font-size: 16px;" fill="#757575" x="100" y="18">{val}</text>';
    OrgChart.templates.olivia.field_1 =
        '<text width="145" style="font-size: 12px;" fill="#757575" x="100" y="38">{val}</text>';
    OrgChart.templates.olivia.field_2 =
        '<text class="field_2" style="font-size:13px;" fill="#00000" x="110" y="62" text-anchor="middle">{val}</text>' ;
    OrgChart.templates.olivia.field_3 =
        '<text class="field_3" style="font-size:13px;" fill="#00000" x="150" y="62" text-anchor="middle">{val}</text>';
    OrgChart.templates.olivia.field_5 =
        '<text class="field_5" style="font-size: 12px;" fill="#00000" x="200" y="62"  text-anchor="middle">{val}</text>';

    // OrgChart.templates.olivia.field_6 =
    //     '<div class="field_6" style="font-size: 14px;" fill="#00000" x="200" y="65" data-toggle="modal" data-target="#editUser" >{val}</text>';
     
     OrgChart.templates.olivia.html =
        '<foreignobject class="node" data-toggle="modal" data-target="#editUser" x="100" y="70" width="150" height="100">{val}</foreignobject>';
     OrgChart.templates.belinda.link = '<path stroke-linejoin="round" stroke="#00000" stroke-width="1px" fill="none" d="{rounded}" />';
    var chart = new OrgChart(document.getElementById("orgchart"),
     {
        template: "olivia",
        enableSearch: false,
        lazyLoading: true,
        scaleInitial: 1.0,
        zoom: false,
        nodeBinding: {
            img_0: "img",
            field_0: "name",
            field_1: "inviter",
            field_2: "petal",
            field_3: "eco",
            field_5: "treeId",
            field_6: "treeId",
            html   : "tree"
        },
        //nodeMouseClick: OrgChart.action.none,
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
     
    
   function treeView(id) {
    var dataString = 'id=' + id;
    jQuery.ajax({
         type: "POST",
         url: "filter.php",
         data: dataString,
         success: function(data1){
          var obj =  JSON.parse(data1);
          $('#first_name').val(obj.first_name);
          $('#last_name').val(obj.last_name);
          $('#email2').val(obj.email);
          $('#phone').val(obj.phone);
          $('#hobbies').val(obj.hobbies);
          $('#book').val(obj.book);
          $('#webUrl').text(obj.website);
          $('#website').attr('href',obj.website);
          $('#inviter').val(obj.referrer_name);
          $('#buttonDiv').html('<button class="btn btn-default profile-btn" style="margin:0 auto!important; border : none" onclick=userTree('+obj.id+',"this_user")>View Tree</button>');
         },
         error: function(data){
         alert('error' + data);
         }
    });
}
  
  function userTree(id, user) {
  // alert(id);
    var dataString = 'id=' + id + '&user=' + user;
    jQuery.ajax({
         type: "POST",
         url: "_/components/php/getViewData2.php",
         data: dataString,
         success: function(data){
             console.log(data);
                localStorage.setItem("viewData", data);  
                window.location.href = "orgView.php"; 
         },
         error: function(data){
         alert('error' + data);
         }
    });
} 

</script>

