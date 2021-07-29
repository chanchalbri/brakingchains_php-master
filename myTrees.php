<?php require_once("_/components/php/includes/session.php"); ?>
<?php require_once("_/components/php/includes/connection.php"); ?>
<?php require_once("_/components/php/includes/functions.php"); ?>
<?php 
// myflowers.php - called by the TLF website - header.php
// to display user info and log out button
//
// (c) 2020, TLF
// Written by James Misa
?>

            <?php include "_/components/php/new_header.php"; ?>
               <!--  <h2><img src="images/Tree%20of%20Life.png" style="width:3vw; height:3vw;"> MY TREES</h2> -->
               <section id="content">

            <div class="content-wrap py-0">


                <div id="section-about" class="center">

                <div class="section">

                        <div class="container clearfix">

                            <div class="mx-auto center">

                                <h2 class="font-weight-light ls1">My Trees</h2>

                            </div>

            <div id="myFlower">
              <?php include "_/components/php/tree_list.php"; ?>
            </div>


            </div>

                    </div>

                </div>

            </div>

        </section><!-- #content end -->
          
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
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" id="editUserSubmit" name="submit" class="btn btn-primary">Update</button>
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
                                <label  class="sr-only" for="fireDate2">Enter Seed Date</label>
                                <div class="col-sm-12" inputGroupContainer>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                        <input type="date" class="form-control" 
                                        id="fireDate2" name="fireDate2"  placeholder="Seed Date"/>
                                    </div><!--input-group-->
                                    <p class="desc">Enter Seed Date - MUST be a Sunday</p>
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
            <div class="modal fade" id="editDate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title" id="editDateModalLabel">Edit Sow Date</h4>
                        </div><!--modal-header-->

                       <!-- Modal Body -->
                        <div class="modal-body">
                            <form class="form-horizontal" data-toggle="validator" id="editDateForm" role="form">

                              <div class="form-group">
                                <label  class="sr-only" for="sowDate">Enter Sow Date</label>
                                <div class="col-sm-12" inputGroupContainer>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                        <input type="date" class="form-control" 
                                        id="sowDate" name="sowDate"  placeholder="Seed Date"/>
                                    </div><!--input-group-->
                                    <p class="desc">Enter Sow Date - MUST be a Sunday</p>
                                </div><!--inputGroupContainer-->
                            </div><!--form-group-->

                              <div class="form-group">
                                <div class="col-sm-12" inputGroupContainer>
                                    <div class="input-group">
                                        <input type="hidden" class="form-control" 
                                        id="this_lotus_id" name="this_lotus_id" value="<?php echo $_SESSION['focus_flower_id'];  ?>" placeholder="Lotus ID" readonly/>
                                    </div><!--input-group-->
                                </div><!--inputGroupContainer-->
                            </div><!--form-group-->

                            </form><!--form-horizontal--> 
                        </div><!--modal-body-->

                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" id="editDateSubmit" name="submit" class="btn btn-primary">Update Sow Date</button>
                        </div><!--modal-footer-->
                    </div><!--modal-content-->
                </div><!--modal-dialog-->
            </div><!--modal login-->
                    
          <!-- Modal -->
            <div class="modal fade" id="editName" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title" id="editNameModalLabel">Edit Display Name</h4>
                        </div><!--modal-header-->

                       <!-- Modal Body -->
                        <div class="modal-body">
                            <form class="form-horizontal" data-toggle="validator" id="editNameForm" role="form">

                              <div class="form-group">
                                <div class="col-sm-12" inputGroupContainer>
                                    <div class="input-group">
                                        <input type="text" class="form-control" 
                                        id="display_name" name="display_name" value="<?php echo $_SESSION['focus_name'];  ?>" placeholder="Display Name"/>
                                    </div><!--input-group-->
                                </div><!--inputGroupContainer-->
                            </div><!--form-group-->

                              <div class="form-group">
                                <div class="col-sm-12" inputGroupContainer>
                                    <div class="input-group">
                                        <input type="hidden" class="form-control" 
                                        id="lotus_id_name" name="lotus_id_name" value="<?php echo $_SESSION['focus_flower_id'];  ?>" placeholder="Lotus ID" readonly/>
                                    </div><!--input-group-->
                                </div><!--inputGroupContainer-->
                            </div><!--form-group-->

                            </form><!--form-horizontal--> 
                        </div><!--modal-body-->

                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" id="editNameSubmit" name="submit" class="btn btn-primary">Update Display Name</button>
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
                                <label for="addFlower2">Select Seed to Add</label>
                                <select class="form-control" id="addFlower2" name="addFlower2">
                                   <?php echo $optionsFlowers; ?> 
                                </select>
                              </div>

                              <div class="form-group">
                                <label  class="sr-only" for="fireDate">Enter Seed Date</label>
                                <div class="col-sm-12" inputGroupContainer>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                        <input type="date" class="form-control" 
                                        id="fireDate" name="fireDate"  placeholder="Seed Date"/>
                                    </div><!--input-group-->
                                    <p class="desc">Enter Seed Date - MUST be a Sunday</p>
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
            <div class="modal fade" id="addFlower" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel4">Add Tree</h4>
                        </div><!--modal-header-->

                       <!-- Modal Body -->
                        <div class="modal-body">
                            <form class="form-horizontal" data-toggle="validator" id="addFlowerForm3" role="form">

                            <div class="form-group">
                                <label for="addSeed2">Select Seed to Add</label>
                                <select class="form-control" id="addSeed2" name="addSeed2">'
                                   <?php echo $options ?> 
                                '</select>
                              </div>

                              <div class="form-group">
                                <label  class="sr-only" for="fireDate3">Enter Seed Date</label>
                                <div class="col-sm-12" inputGroupContainer>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                        <input type="date" class="form-control" 
                                        id="fireDate3" name="fireDate3"  placeholder="Seed Date"/>
                                    </div><!--input-group-->
                                    <p class="desc">Enter Seed Date - MUST be a Sunday</p>
                                </div><!--inputGroupContainer-->
                            </div><!--form-group-->

                              <div class="form-group">
                                <div class="col-sm-12" inputGroupContainer>
                                    <div class="input-group">
                                        <input type="hidden" class="form-control" 
                                        id="lotus_id3" name="lotus_id3" value="<?php echo $_SESSION['focus_flower_id'];  ?>" placeholder="Lotus ID" readonly/>
                                    </div><!--input-group-->
                                </div><!--inputGroupContainer-->
                            </div><!--form-group-->

                            </form><!--form-horizontal--> 
                        </div><!--modal-body-->

                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" id="addSeedSubmit" name="submit" class="btn btn-primary">Create Flower</button>
                        </div><!--modal-footer-->
                    </div><!--modal-content-->
                </div><!--modal-dialog-->
            </div><!--modal login-->
          
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
          
<?php include "_/components/php/modal_startBoard.php"; ?>
<?php include "_/components/php/new_footer.php"; ?>
 <script type="text/javascript">
  $(document).ready(function(){
    // alert('fdf'); 
    $(".flip-card").mouseover(function(){
      console.log("run mousehover event");
      var $container=$(this).find(".flip-card-inner").find("p.message");
     
         $.ajax({
                type: "POST",
                url: "flip_messages.php",
                data: {action:'get_message',category:'tree'},
                dataType:'json',
                success: function(data) {
                    
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
</script>  

     