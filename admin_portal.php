<?php require_once("_/components/php/includes/session.php"); ?>
<?php require_once("_/components/php/includes/connection.php"); ?>
<?php require_once("_/components/php/includes/functions.php"); ?>
<?php global $admin_front,$admin_backend;

$admin_front='assets/one-page/images/Lotus Reboot (Board Resized).jpg';
$admin_backend='assets/one-page/images/flip-bg.jpg';
?>
<?php 
// myflowers.php - called by the TLF website - header.php
// to display user info and log out button
//
// (c) 2020, TLF
// Written by James Misa
?>


      
    <?php include "_/components/php/new_header.php"; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>       
    <section id="content">
        <div class="content-wrap py-0">
            <div id="section-about" class="center">
                <div class="section">
                    <div class="container clearfix">
                        <div class="mx-auto center">
                            <h2 class="font-weight-light ls1">Admin</h2>
                        </div>

                        <div class="row">
                            <div class="col-lg-3">
                                <a href="javascript:void(0)" class="button button-circle button-3d button-border btn-block" data-toggle="modal" data-toggle="modal" data-target="#replaceFlower"><i class="icon-tags"></i>&nbsp;Replace Tree</a>
                            </div>
                            <div class="col-lg-3">
                                <a href="javascript:void(0)" class="button button-circle button-3d button-border btn-block" data-toggle="modal" data-target="#addTree"><i class="icon-tags"></i>&nbsp;Add Scholarship Tree</a>
                            </div>
                            <div class="col-lg-3">
                                <a href="javascript:void(0)" class="button button-circle button-3d button-border btn-block" data-toggle="modal" data-target="#addTree"><i class="icon-tags"></i>&nbsp;Add Garden Tree</a>
                            </div> 
                            <div class="col-lg-3">
                                <a href="javascript:void(0)" class="button button-circle button-3d button-border btn-block" data-toggle="modal" data-target="#editInfo"><i class="icon-tags"></i>&nbsp;EDIT INFO</a>
                            </div>
                             
                        </div> 

                        
          
          <?php 
            $query = "SELECT * ";
            $query .= " FROM users ";
            $query .= " WHERE flower = 1 ";
            $query .= " ORDER BY gen ASC";
            $resultSet = mysqli_query($connection, $query);
            confirm_query($resultSet, $connection);  
          
            $total_flowers = mysqli_num_rows($resultSet);

            $flower_list = '<h2><i class=""></i> Tree List (' . $total_flowers . ')</h2>';
            $flower_list = $flower_list . '<input type="text" class="form-control" style="margin-bottom:20px;" id="myInput" onkeyup="myFunction()" placeholder="Search for tree.." title="Type in a name">';


            $flower_list = $flower_list . '<div class="row" id="myUL">';
          
            while($found_user = mysqli_fetch_array($resultSet)) {
                $id = $found_user['id'];
                $name = $found_user['first_name'] . " " . $found_user['last_name'];
                $lotus_id = $found_user['lotus_id'];
                $tlf_id = $found_user['tlf_id'];
                $pre_date = $found_user['fireDate'];
                if($pre_date) {$fireDate = date("m/d/Y", $pre_date);}
                $air_id = $found_user['air_id'];
                $earth_id = $found_user['earth_id'];
                $water_id = $found_user['water_id'];
                $gen = $found_user['gen'];
                
                $flower_list = $flower_list . '                                 
                    <div class="col-lg-4 mb-4 navneet">
                    
                        <div class="flip-card top-to-bottom">
                        <div class="flip-card-front dark" data-height-xl="200" style="background-image: url(\''.$admin_front.'\');">
                        <div class="flip-card-inner">
                           <div class="card bg-transparent border-0">
                              <div class="card-body">
                                 <h3 class="card-title mb-0">' . $id . ' ' . $name . '</h3>
                                 <span class="font-italic">-- Gen: ' . $gen . ' <br /> ID :' . $lotus_id . '</span>
                                 <p class="font-italic">( \'' . $tlf_id . '\')</p>
                                
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="flip-card-back" data-height-xl="200" style="background-image: url(\''.$admin_backend.'\');">
                        <div class="flip-card-inner">
                           <p class="mb-2 text-white message">'.$message.'</p>
                           <a type="button" href="#" onclick="flower_dets_admin(\'' . $lotus_id . '\', \'' . $tlf_id . '\');" target="blank" class="btn btn-outline-light mt-2">View Tree</a>
                        </div>
                     </div>
                    </div>
                    
                </div>';                    
            
            }
          
            $flower_list = $flower_list . '</div>';
          ?>
            <div id="myFlower"> 
                <?php echo $flower_list; ?>
            </div>
           
          <?php 
                $tlf_id = $_SESSION['tlf_id'];
                $query = sprintf("SELECT * FROM users WHERE referrer='%s' && flower=0 ORDER BY fireDate ASC", 
                        mysqli_real_escape_string($connection, $tlf_id));
                        $result = mysqli_query($connection, $query);
                        confirm_query($result, $connection);

                $options = '<option>Yourself</option>';
                if(mysqli_num_rows($result) > 0) {
                    $_SESSION['seeds'] = array();
                    $i = 0;
                    while($found_seed = mysqli_fetch_array($result)) {
                        $name = $found_seed['first_name'] . " " . $found_seed['last_name'];
                        $seed_tlf_id = $found_seed['tlf_id'];
                        $options = $options . '<option>' . $name . '</option>';
                        $_SESSION['seeds'][$i] = array();
                        $_SESSION['seeds'][$i]['name'] = $name;
                        $_SESSION['seeds'][$i]['tlf_id'] = $seed_tlf_id;
                        $i++;
                    }
                }
          
                $optionsSeeds = '';
                $query2 = sprintf("SELECT * FROM users WHERE flower=0 ORDER BY first_name ASC", 
                mysqli_real_escape_string($connection, $tlf_id));
                $result2 = mysqli_query($connection, $query2);
                confirm_query($result2, $connection);
          
                if(mysqli_num_rows($result2) > 0) {
                    $_SESSION['seedsAdmin'] = array();
                    $i = 0;
                    while($found_seed = mysqli_fetch_array($result2)) {
                        $name = $found_seed['first_name'] . " " . $found_seed['last_name'];
                        $seed_tlf_id = $found_seed['tlf_id'];
                        $optionsSeeds = $optionsSeeds . '<option>' . $name . '</option>';
                        $_SESSION['seedsAdmin'][$i] = array();
                        $_SESSION['seedsAdmin'][$i]['name'] = $name;
                        $_SESSION['seedsAdmin'][$i]['tlf_id'] = $seed_tlf_id;
                        $i++;
                    }
                }
          
                $optionsFlowersReplace = '';
                $query4 = sprintf("SELECT * FROM users WHERE flower=1 ORDER BY id ASC", 
                mysqli_real_escape_string($connection, $tlf_id));
                $result4 = mysqli_query($connection, $query4);
                confirm_query($result4, $connection);
          
                if(mysqli_num_rows($result4) > 0) {
                    $_SESSION['flowersAdminReplace'] = array();
                    $i = 0;
                    while($found_flower = mysqli_fetch_array($result4)) {
                        $name = $found_flower['first_name'] . " " . $found_flower['last_name'];
                        $flower_lotus_id = $found_flower['lotus_id'];
                        $flower_id = $found_flower['id'];
                        $board_brand = $found_flower['board_brand'];
                        $optionsFlowersReplace = $optionsFlowersReplace . '<option>' . $flower_id . ' ' . $name . '</option>';
                        $_SESSION['flowersAdminReplace'][$i] = array();
                        $_SESSION['flowersAdminReplace'][$i]['name'] = $flower_id . ' ' . $name;
                        $_SESSION['flowersAdminReplace'][$i]['lotus_id'] = $flower_lotus_id;
                        $_SESSION['flowersAdminReplace'][$i]['id'] = $flower_id;
                        $_SESSION['flowersAdminReplace'][$i]['board_brand'] = $board_brand;
                        $i++;
                    }
                }
          
                $optionsFlowers = '<option>Yourself</option>';
                $query3 = sprintf("SELECT * FROM users WHERE flower=1 ORDER BY first_name ASC", 
                mysqli_real_escape_string($connection, $tlf_id));
                $result3 = mysqli_query($connection, $query3);
                confirm_query($result, $connection);
          
                if(mysqli_num_rows($result3) > 0) {
                    $_SESSION['flowersAdmin'] = array();
                    $i = 0;
                    while($found_flower = mysqli_fetch_array($result3)) {
                        $name = $found_flower['first_name'] . " " . $found_flower['last_name'];
                        $flower_tlf_id = $found_flower['tlf_id'];
                        $optionsFlowers = $optionsFlowers . '<option>' . $name . '</option>';
                        $_SESSION['flowersAdmin'][$i] = array();
                        $_SESSION['flowersAdmin'][$i]['name'] = $name;
                        $_SESSION['flowersAdmin'][$i]['tlf_id'] = $flower_tlf_id;
                        $i++;
                    }
                }
          
          
   
              ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </section>

         <?php 

    include "_/components/php/modal_addTree.php";
    include "_/components/php/modal_selectSeed.php";
    include "_/components/php/modal_selectTree.php"; 
    //include "_/components/php/modal_editInfo.php";
    //include "_/components/php/modal_updateInfo.php";

    ?>
    
          

     

     <script type="text/javascript">

        $(document).ready(function(){
    $(".flip-card").mouseover(function(){
      console.log("run mousehover event");
      var $container=$(this).find(".flip-card-inner").find("p.message");
     
         $.ajax({
                type: "POST",
                url: "flip_messages.php",
                data: {action:'get_message',category:'admin'},
                dataType:'json',
                success: function(data) {
                    console.log(data.content); 
                    //$("#data-table").html(data.content);
                   
                     //$(this).find(".flip-card-inner").find("p.message").html('Hello');
                    
                   $container.html(data.content);
                     
                                  
                },
                error: function(e) {
                    console.log(e);
                }
            })
         

      
    });
  });

        function getSeeds() { 
    jQuery.ajax({
         type: "POST",
         url: "_/components/php/getSeedsList.php",
         success: function(msg){
             var select = document.getElementById("addSeed"); 
             var obj = JSON.parse(msg);
             for(var i = 0; i < obj.length; i++) {
                var optVal = obj[i]['id'];
                var optText = obj[i]['name'];
                var el = document.createElement("option");
                el.textContent = optText;
                el.value = optVal;
                select.appendChild(el);
             }
             if(localStorage.getItem("board_brand") == "107") {
                 var note = "Enter Sow Date (MUST BE A SATURDAY!)";
             } else {
                 var note = "Enter Sow Date (MUST BE A SUNDAY!)";
             }
             var desc = document.getElementById("seedDesc");
             desc.innerHTML = note;
             $("#addFromSeeds").modal('show');
         },
         error: function(data){
         alert('error' + data);
         }
    });
} 

        
    </script>

<!-- Modal -->
            <div class="modal fade" id="changePassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Change to Default Password</h4>
                        </div>

                        <!-- Modal Body -->
                        <div class="modal-body">
                            <form class="form-horizontal" data-toggle="validator" id="registerForm" role="form">

                              <div class="form-group">
                                <label class="sr-only" for="email" >Enter Email Address</label>
                                <div class="col-sm-12" inputGroupContainer>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                        <input type="email" class="form-control"
                                        id="email" name="email" data-minlength="6" placeholder="Enter User's Email Address"/>
                                    </div><!--input-group-->
                                    <p class="desc">New temp password will be 'password' plus last four of user's phone number.</p>
                                </div><!--inputGroupContainer-->
                              </div><!--form-group-->
                            </form>
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" id="defPasswordSubmit" name="submit" class="btn btn-primary">Update</button>
                        </div><!--modal-footer-->
                                
                    </div><!--modal-content-->
                </div><!--modal-dialog-->
            </div><!--modal register-->
          
          <!-- Modal -->
            <div class="modal fade" id="removeFlower" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel5">Remove Tree</h4>
                        </div><!--modal-header-->

                       <!-- Modal Body -->
                        <div class="modal-body">
                            <form class="form-horizontal" data-toggle="validator" id="delFlowerForm" role="form">

                            <div class="form-group">
                            <label  class="sr-only" for="convert"></label>
                            <div class="col-sm-12" inputGroupContainer>
                                <div class="input-group">
                                <button type="button" class="btn btn-primary btn-block" data-dismiss="modal"  id="convertToSeed">Convert To Seed</button>  
                                </div><!--input-group-->
                            </div><!--inputGroupContainer-->
                          </div><!--form-group-->
                                
                            <div class="form-group">
                            <label  class="sr-only" for="delete"></label>
                            <div class="col-sm-12" inputGroupContainer>
                                <div class="input-group">
                                <button type="button" class="btn btn-primary btn-block" data-dismiss="modal" id="deleteFlower">Delete Tree</button>  
                                </div><!--input-group-->
                            </div><!--inputGroupContainer-->
                          </div><!--form-group-->

                            </form><!--form-horizontal--> 
                        </div><!--modal-body-->

                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </div><!--modal-footer-->
                    </div><!--modal-content-->
                </div><!--modal-dialog-->
            </div><!--modal login-->
          
          <!-- Modal -->
        <div class="modal fade" id="addFlowerAdmin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Seed or Tree?</h4>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form class="form-horizontal" data-toggle="validator" id="registerForm" role="form">
                            
                          <div class="form-group">
                            <label  class="sr-only" for="addFromSeeds"></label>
                            <div class="col-sm-12" inputGroupContainer>
                                <div class="input-group">
                                <button type="button" class="btn btn-primary btn-block" data-dismiss="modal" data-toggle="modal" data-target="#addFromSeedsAdmin">Add From Seeds</button>  
                                </div><!--input-group-->
                            </div><!--inputGroupContainer-->
                          </div><!--form-group-->
                            
                          <div class="form-group">
                            <label  class="sr-only" for="addFromFlower"></label>
                            <div class="col-sm-12" inputGroupContainer>
                                <div class="input-group">
                                <button type="button" class="btn btn-primary btn-block" data-dismiss="modal" data-toggle="modal" data-target="#addFromFlowerAdmin">Add From Trees</button>  
                                </div><!--input-group-->
                            </div><!--inputGroupContainer-->
                          </div><!--form-group-->
                            
                        </form> 
                    </div><!--modal-body-->

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                    </div><!--modal-footer-->
                </div><!--modal-content-->
            </div><!--modal-dialog-->
        </div><!--modal register-->
          
          <!-- Modal -->
            <div class="modal fade" id="addFromSeedsAdmin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel2">Add Tree Admin</h4>
                        </div><!--modal-header-->

                       <!-- Modal Body -->
                        <div class="modal-body">
                            <form class="form-horizontal" data-toggle="validator" id="addFlowerForm" role="form">

                            <div class="form-group">
                                <label for="addSeed">Select Seed to Add</label>
                                <select class="form-control" id="addSeed">
                                   <?php echo $optionsSeeds; ?> 
                                </select>
                              </div>

                              <div class="form-group">
                                <label  class="sr-only" for="fireDate2">Enter Fire Date</label>
                                <div class="col-sm-12" inputGroupContainer>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                        <input type="date" class="form-control" 
                                        id="fireDate2" name="fireDate2"  placeholder="Fire Date"/>
                                    </div><!--input-group-->
                                    <p class="desc">Enter Fire Date (MUST BE A SUNDAY!)</p>
                                </div><!--inputGroupContainer-->
                            </div><!--form-group-->

                              <div class="form-group">
                                <div class="col-sm-12" inputGroupContainer>
                                    <div class="input-group">
                                        <input type="hidden" class="form-control" 
                                        id="lotus_id2" name="lotus_id2" value="<?php echo $_SESSION['focus_flower_id'];  ?>" placeholder="Lotus ID" readonly/>
                                    </div><!--input-group-->
                                </div><!--inputGroupContainer-->
                            </div><!--form-group-->

                            </form><!--form-horizontal--> 
                        </div><!--modal-body-->

                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" id="addSeedAdminSubmit" name="submit" class="btn btn-primary">Create Tree</button>
                        </div><!--modal-footer-->
                    </div><!--modal-content-->
                </div><!--modal-dialog-->
            </div><!--modal login-->
          
          
          <!-- Modal -->
            <div class="modal fade" id="addFromFlowerAdmin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel3">Add Tree Admin</h4>
                        </div><!--modal-header-->

                       <!-- Modal Body -->
                        <div class="modal-body">
                            <form class="form-horizontal" data-toggle="validator" id="addFlowerForm2" role="form">

                            <div class="form-group">
                                <label for="addFlower2">Select Tree to Add</label>
                                <select class="form-control" id="addFlower2" name="addFlower2">
                                   <?php echo $optionsFlowers; ?> 
                                </select>
                              </div>

                              <div class="form-group">
                                <label  class="sr-only" for="fireDate">Enter Sow Date</label>
                                <div class="col-sm-12" inputGroupContainer>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                        <input type="date" class="form-control" 
                                        id="fireDate" name="fireDate"  placeholder="Fire Date"/>
                                    </div><!--input-group-->
                                    <p class="desc">Enter Sow Date (MUST BE A SUNDAY!)</p>
                                </div><!--inputGroupContainer-->
                            </div><!--form-group-->

                              <div class="form-group">
                                <div class="col-sm-12" inputGroupContainer>
                                    <div class="input-group">
                                        <input type="hidden" class="form-control" 
                                        id="lotus_id" name="lotus_id" value="<?php echo $_SESSION['focus_flower_id'];  ?>" placeholder="Lotus ID" readonly/>
                                    </div><!--input-group-->
                                </div><!--inputGroupContainer-->
                            </div><!--form-group-->
                                
                            
                            </form><!--form-horizontal--> 
                        </div><!--modal-body-->
                                
                            <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" id="addFlowerAdminSubmit" name="submit" class="btn btn-primary">Create Tree</button>
                        </div><!--modal-footer-->
                    </div><!--modal-content-->
                </div><!--modal-dialog-->
            </div><!--modal login-->
          
  <!-- Modal -->
    <div class="modal fade" id="replaceFlower" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel4">Replace Tree</h4>
                </div><!--modal-header-->

               <!-- Modal Body -->
                <div class="modal-body">
                    <form class="form-horizontal" data-toggle="validator" id="replaceFlowerForm" role="form">

                    <div class="form-group">
                        <label for="replacedFlower">Select Tree to Replace</label>
                        <select class="form-control profile-btn" id="replacedFlower" name="replacedFlower">
                           <?php echo $optionsFlowersReplace; ?> 
                        </select>
                      </div>

                    <div class="form-group">
                        <label for="addedFlower">Select Tree to Add</label>
                        <select class="form-control profile-btn" id="addedFlower" name="addedFlower">
                           <?php echo $optionsFlowers; ?> 
                        </select>
                      </div>

                      <div class="form-group">
                        <div class="col-sm-12" inputGroupContainer>
                            <div class="input-group">
                                <input type="hidden" class="form-control " 
                                id="lotus_id" name="lotus_id" value="<?php echo $_SESSION['focus_flower_id'];  ?>" placeholder="Lotus ID" readonly/>
                            </div><!--input-group-->
                        </div><!--inputGroupContainer-->
                    </div><!--form-group-->


                    </form><!--form-horizontal--> 
                </div><!--modal-body-->

                    <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default profile-btn" data-dismiss="modal">Cancel</button>
                    <button type="submit" id="replaceFlowerSubmit" name="submit" class="btn btn-primary profile-btn">Replace</button>
                </div><!--modal-footer-->
            </div><!--modal-content-->
        </div><!--modal-dialog-->
    </div><!--modal login-->


     <!-- Modal -->
    <div class="modal fade" id="editInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel4">Edit Info</h4>
                </div><!--modal-header-->

               <!-- Modal Body -->
                <div class="modal-body">
                    <form class="form-horizontal" data-toggle="validator" id="replaceBoardform" role="form">

                    <div class="form-group">
                        <label for="editBoard">Select Person to Edit</label>
                        <select class="form-control" id="editBoard" name="editBoard">
                           <?php echo $_SESSION['optionsBoards']; ?> 
                        </select>
                      </div>

                    </form><!--form-horizontal--> 
                </div><!--modal-body-->

                    <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" id="editBoardSubmit" name="submit" class="btn btn-primary">Edit</button>
                </div><!--modal-footer-->
            </div><!--modal-content-->
        </div><!--modal-dialog-->
    </div><!--modal login-->

<!-- Modal -->
<div class="modal fade" id="updateInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel7">Update Info</h4>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form class="form-horizontal" data-toggle="validator" id="updateInfoForm" role="form">
                    
                <div class="form-group">
                    <label for="addReferrer">Select Inviter</label>
                    <select class="form-control referrer_name" name="referrer_name">
                       <?php echo $_SESSION['optionsBoards']; ?> 
                    </select>
                  </div>

                  <div class="form-group">
                    <label  class="sr-only" for="first_name">First Name</label>
                    <div class="col-sm-12" inputGroupContainer>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" class="form-control first_name" 
                            name="first_name" placeholder="First Name"/>
                        </div><!--input-group-->
                    </div><!--inputGroupContainer-->
                  </div><!--form-group-->

                    <div class="form-group">
                        <label  class="sr-only" for="last_name">Last Name</label>
                        <div class="col-sm-12" inputGroupContainer>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input type="text" class="form-control last_name" 
                                name="last_name" placeholder="Last Name"/>
                            </div><!--input-group-->
                        </div><!--inputGroupContainer-->
                    </div><!--form-group-->

                    <div class="form-group">
                        <label  class="sr-only" for="email">Email</label>
                        <div class="col-sm-12" inputGroupContainer>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <input type="email" class="form-control email" 
                                name="email" placeholder="Email"/>
                            </div><!--input-group-->
                        </div><!--inputGroupContainer-->
                    </div><!--form-group-->

                  <div class="form-group">
                    <label class="sr-only" for="phone" >Phone</label>
                    <div class="col-sm-12" inputGroupContainer>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                            <input type="tel" class="form-control phone"
                            name="phone" data-minlength="6" placeholder="Phone"/>
                        </div><!--input-group-->
                    </div><!--inputGroupContainer-->
                  </div><!--form-group-->

                    <div class="form-group">
                        <div class="col-sm-12" inputGroupContainer>
                            <div class="input-group">
                                <input type="hidden" class="form-control tlf_id" 
                                name="tlf_id" value="" placeholder="TLF ID" readonly/>
                            </div><!--input-group-->
                        </div><!--inputGroupContainer-->
                    </div><!--form-group-->

                </form> 
            </div><!--modal-body-->

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" id="updateSubmit" name="submit" class="btn btn-primary">Update</button>
            </div><!--modal-footer-->
        </div><!--modal-content-->
    </div><!--modal-dialog-->
</div><!--modal register-->
<script>
    function flower_dets_admin(lotus_id, tlf_id) {
    var dataString = 'lotus_id=' + lotus_id + '&tlf_id=' + tlf_id;
    jQuery.ajax({
         type: "POST",
         url: "_/components/php/flower_detail_admin.php",
         data: dataString,
         success: function(data){
            document.getElementById('myFlower').innerHTML = data;
         },
         error: function(){
         alert("failure");  
         }
        });
}

// function myFunction() {
//      var searchName = $("#myInput").val();
//      $(".hem").val(searchName);
//      var dataString = 'searchName=' + searchName;
//          jQuery.ajax({
//              type: "POST",
//              url: "filter.php",
//              data: dataString,
//              success: function(searchData){               
//               $('#myFlower').css('display','none');
//               $("#filterId").html(searchData);
//               $(".hem").val(searchName);
//             },
//              error: function(data){
//              alert(data);
//              }
//             });
//       }

function myFunction() {
    var input, filter, ul, li, div, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL");
    li = ul.getElementsByClassName("navneet");   
    for (i = 0; i < li.length; i++) {
        div = li[i].getElementsByTagName("div")[0];
        txtValue = div.textContent || div.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
           
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
            
            
        }
    }
}

$('#editBoardSubmit').click(function(){
    var name = $("#editBoard").val();
    var dataString = 'name=' + name;
         jQuery.ajax({
             type: "POST",
             url: "_/components/php/getBoardMemberInfo.php",
             data: dataString,
             success: function(msg){
               
                 var obj = JSON.parse(msg);
                 alert(obj[0]);
                 if(obj[0] == "Success") {
                    $("#editInfo").modal('hide');
                    $("#updateInfo").modal('show');                    
                    //$('#updateInfo').css('display','block');
                     $(".modal-body .referrer_name").val(obj[1]);
                     $(".modal-body .first_name").val(obj[2]);
                     $(".modal-body .last_name").val(obj[3]);
                     $(".modal-body .email").val(obj[4]);
                     $(".modal-body .phone").val(obj[5]);
                     $(".modal-body .tlf_id").val(obj[6]);
                     //$('#updateInfo').css("display",'block');
                     
                    
                 } else {
                     alert('Something went wrong');
                      $msg[0] = "Success";
                      $msg[5] = $phone;
                      $msg[6] = $tlf_id;
                      $msg[7] = $promoCode;
                      $msg[8] = $board_ref_id;
                 }
             },
             error: function(data){
             alert(data);
             } 
            });
});

$("#updateSubmit").click(function () {
        var e = $(".referrer_name").val(),
            a = $(".first_name").val(),
            t = $(".last_name").val(),
            r = $(".email").val(),
            o = $(".phone").val(),
            l = $(".promoCode").val(),
            n = $(".tlf_id").val(),
            i = "inviter=" + e + "&first_name=" + a + "&last_name=" + t + "&email=" + r + "&phone=" + o + "&promoCode=" + l + "&tlf_id=" + n;
        jQuery.ajax({
            type: "POST",
            url: "_/components/php/updateBoardMemberInfo.php",
            data: i,
            success: function (e) {
                console.log(e), alert(e), $("#updateInfo").modal("hide"), location.reload();
            },
            error: function (e) {
                alert(e);
            },
        });
    })

</script>

<?php include "_/components/php/new_footer.php"; ?>