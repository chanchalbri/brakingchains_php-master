<?php require_once("_/components/php/includes/session.php"); ?>
<?php require_once("_/components/php/includes/connection.php"); ?>
<?php require_once("_/components/php/includes/functions.php"); ?>
<?php global $admin_front,$admin_backend;

$admin_front='assets/one-page/images/Lotus Reboot (Board Resized).jpg';
$admin_backend='assets/one-page/images/flip-bg.jpg';
?>
<?php 
        
            $id = "";
            $where = "";
            if(isset($_POST['id'])) {
            $id = $_POST['id'];
            $query = "SELECT * FROM users where id = ".$id;

            }

            
            $resultSet = mysqli_query($connection, $query);
            confirm_query($resultSet, $connection);
            $total_flowers = mysqli_num_rows($resultSet);
            
            
          
            while($found_user = mysqli_fetch_array($resultSet)) {
               // print_r($found_user);
               // exit();
                 echo json_encode($found_user);
                 exit();
                // $id = $found_user['id'];
                // $name = $found_user['first_name'] . " " . $found_user['last_name'];
                // $lotus_id = $found_user['lotus_id'];
                // $tlf_id = $found_user['tlf_id'];
                // $pre_date = $found_user['fireDate'];
                // if($pre_date) {$fireDate = date("m/d/Y", $pre_date);}
                // $air_id = $found_user['air_id'];
                // $earth_id = $found_user['earth_id'];
                // $water_id = $found_user['water_id'];
                // $gen = $found_user['gen'];
                
        //         $flower_list = $flower_list . '<div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        //     <div class="modal-dialog">
        //         <div class="modal-content">

        //             <!-- Modal Header -->
        //             <div class="modal-header">
        //                 <h4 class="modal-title" id="myModalLabel3">User Details</h4>
        //             </div>

        //             <!-- Modal Body -->
        //             <div class="modal-body">
        //                 <form class="form-horizontal" data-toggle="validator" id="registerForm3" role="form">

        //                   <div class="form-group">
        //                     <label   for="first_name">First Name</label>
        //                     <div  inputGroupContainer>
        //                         <div class="input-group">
        //                             <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
        //                             <input type="text" class="form-control" 
        //                             id="first_name" readonly="readonly" value="' .  $found_user["first_name"] . '" />
        //                         </div><!--input-group-->
        //                     </div><!--inputGroupContainer-->
        //                   </div><!--form-group-->

        //                     <div class="form-group">
        //                         <label   for="last_name">Last Name</label>
        //                         <div inputGroupContainer>
        //                             <div class="input-group">
        //                                 <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
        //                                 <input type="text" class="form-control" readonly="readonly" 
        //                                 id="last_name"  value="' .  $found_user['last_name'] . '" />
        //                             </div><!--input-group-->
        //                         </div><!--inputGroupContainer-->
        //                     </div><!--form-group-->

        //                     <div class="form-group">
        //                         <label   for="email">Email</label>
        //                         <div  inputGroupContainer>
        //                             <div class="input-group">
        //                                 <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
        //                                 <input type="email" class="form-control" readonly="readonly"
        //                                 id="email2"  value="' . $found_user['email'] . '" />
        //                             </div><!--input-group-->
        //                         </div><!--inputGroupContainer-->
        //                     </div><!--form-group-->

        //                   <div class="form-group">
        //                     <label  for="phone" >Phone</label>
        //                     <div inputGroupContainer>
        //                         <div class="input-group">
        //                             <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
        //                             <input type="text" class="form-control" readonly="readonly"
        //                             id="phone"  data-minlength="6" value="' . $found_user['phone'] . '" />
        //                         </div><!--input-group-->
        //                     </div><!--inputGroupContainer-->
        //                   </div><!--form-group-->
                     
        //                   <div class="form-group">
        //                     <label  for="phone" >My Interests/Hobbies (Singing, dancing)</label>
        //                     <div inputGroupContainer>
        //                         <div class="input-group">
        //                             <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
        //                             <input type="text" class="form-control" readonly="readonly"
        //                             id="hobbies"  value="' . $found_user['hobbies'] . '" />
        //                         </div><!--input-group-->
        //                     </div><!--inputGroupContainer-->
        //                   </div><!--form-group-->

        //                   <div class="form-group">
        //                     <label  for="phone" >My Favorite Books</label>
        //                     <div inputGroupContainer>
        //                         <div class="input-group">
        //                             <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
        //                             <input type="text" class="form-control" readonly="readonly"
        //                                value="' . $found_user['book'] . '" />
        //                         </div><!--input-group-->
        //                     </div><!--inputGroupContainer-->
        //                   </div><!--form-group-->

        //                   <div class="form-group">
        //                     <label  for="phone" >My Website</label>
        //                     <div inputGroupContainer>
        //                         <div class="input-group">
        //                             <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
        //                             <input type="text" class="form-control" readonly="readonly"
        //                                value="' . $found_user['website'] . '" />
        //                         </div><!--input-group-->
        //                     </div><!--inputGroupContainer-->
        //                   </div><!--form-group-->
        //                   <div class="form-group">
        //                     <label  for="phone" >Inviter</label>
        //                     <div inputGroupContainer>
        //                         <div class="input-group">
        //                             <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
        //                             <input type="text" class="form-control" readonly="readonly"
        //                            value="' . $found_user['referrer_name'] . '" />
        //                         </div><!--input-group-->
        //                     </div><!--inputGroupContainer-->
        //                   </div><!--form-group-->

                        
                          
        //                 <div class="form-group">
        //                     <div inputGroupContainer>
        //                         <div class="input-group">
        //                             <input type="hidden" class="form-control"  readonly="readonly"
        //                             id="tlf_id" name="tlf_id" value="' . $found_user['tlf_id'] . '" placeholder="Referrer Code" readonly/>
        //                         </div><!--input-group-->
        //                     </div><!--inputGroupContainer-->
        //                 </div><!--form-group-->

        //                 </form> 
        //             </div><!--modal-body-->

        //             <!-- Modal Footer -->
        //             <div class="modal-footer">
        //                <button class="btn btn-default profile-btn" style="margin:0 auto!important; border="none" data-toggle="modal" data-target="#addTree" onclick="storeParent(' . $air_tree_id . ', ' . $air_board . ');">Add Tree</button>
        //                <button type="button" class="btn btn-default profile-btn" data-dismiss="modal">Cancel</button>
        //             </div><!--modal-footer-->
        //         </div><!--modal-content-->
        //     </div><!--modal-dialog-->
        // </div><!--modal register-->';
            }
          
            // $flower_list = $flower_list;
            // echo  $flower_list;
           
            

          ?>