<?php require_once("_/components/php/includes/session.php"); ?>
<?php require_once("_/components/php/includes/connection.php"); ?>
<?php require_once("_/components/php/includes/functions.php"); ?>
<?php 
// user.php - called by the TLF website - header.php
// to display user info and log out button
//
// (c) 2020, TLF
// Written by James Misa

//$userImage = $_SESSION['userData']['picture']['url'];
$userImage = $_SESSION['profile'];
?>

              <?php include "_/components/php/new_header.php"; ?>
            <?php 
              if(!$_SESSION['optionsBoards']) {
                    $_SESSION['optionsBoards'] = '';
                    $query = sprintf("SELECT DISTINCT first_name,last_name,tlf_id FROM users ORDER BY first_name ASC", 
                    mysqli_real_escape_string($connection, $tlf_id));
                    $result = mysqli_query($connection, $query);
                    confirm_query($result, $connection);

                    if(mysqli_num_rows($result) > 0) {
                        $_SESSION['boardWater'] = array();
                        $i = 0;
                        while($found_flower = mysqli_fetch_array($result)) {
                            $name = $found_flower['first_name'] . " " . $found_flower['last_name'];
                            $flower_tlf_id = $found_flower['tlf_id'];
                            $_SESSION['optionsBoards'] = $_SESSION['optionsBoards'] . '<option>' . $name . '</option>';
                            $_SESSION['boardWater'][$i] = array();
                            $_SESSION['boardWater'][$i]['name'] = $name;
                            $_SESSION['boardWater'][$i]['tlf_id'] = $flower_tlf_id;
                            $i++;
                        }
                    }
                }
          
                if(!$_SESSION['giftMethods']) {
                }
                    $_SESSION['giftMethods'] = array();
                    $query = "SELECT *";
                    $query .= "FROM gift_methods ";
                    $query .= "WHERE tlf_id = '{$_SESSION['tlf_id']}'";
                    $resultSet = mysqli_query($connection, $query);
                    confirm_query($resultSet, $connection);
                    
                    $i=0;
                    while($found_method = mysqli_fetch_array($resultSet)) {
                        $_SESSION['giftMethods'][$i]['method'] = $found_method['gift_method'];
                        $_SESSION['giftMethods'][$i]['username']= $found_method['method_username'];
                        $_SESSION['giftMethods'][$i]['id']= $found_method['id'];
                        $i++;
                    }
              ?>
            <section id="content">

            <div class="content-wrap py-0">
                <div id="section-about" class="center">

                <div class="section m-0">

                        <div class="container clearfix">

                            <div class="mx-auto center">
                                <h2 class="font-weight-light ls1"> MY PROFILE</h2>
                            </div>
                            

            <div class="container emp-profile">
            
                <div class="row">
                    <div class="col-md-3">
                        <div class="profile-img">
                            <img src="<?php if($userImage) { echo "images/".$userImage;} else { echo "images/contact.jpeg";} ?>" alt=""/>
                            <div class="file btn btn-lg btn-primary">
                                Change Photo
                                <form method="post" enctype="multipart/form-data" action="upload.php">
                                <input id="sortpicture" required="required" type="file" name="profile" />
                                 <input type="hidden" class="form-control" id="tlf_id" name="tlf_id" value="<?php echo $_SESSION['tlf_id'];?>" readonly/>
                                <button type="submit" id="upload">Upload</button>
                              </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                       
                        <div class="profile-head">
                                   <!--  <h5>
                                        Kshiti Ghelani
                                    </h5> -->
                                    <!-- <h6>
                                        Web Developer and Designer
                                    </h6>
                                    <p class="proile-rating">RANKINGS : <span>8/10</span></p> -->
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Profile</a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Timeline</a>
                                </li> -->
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4">

                         <button type="button" class="btn profile-btn  " data-toggle="modal" data-target="#editUser">Edit Profile</button>
                         <a class="btn profile-btn href="#" data-toggle="modal" data-target="#editMethods">Edit Gift Method</a>
                     <a href="logout.php" id="logoutButton" class="btn profile-btn ">Logout</a>
                    </div>
                </div>
                 <form method="post">
                <div class="row">
                    <div class="col-md-3">
                        
                    </div>
                   
                     <div class="col-md-9 text-left">
                        <div class="tab-content profile-tab" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>User Name</label>
                                            </div>
                                            <div class="col-md-9">
                                                <p><?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>Email</label>
                                            </div>
                                            <div class="col-md-9">
                                                <p><?php echo $_SESSION['email']; ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>Phone</label>
                                            </div>
                                            <div class="col-md-9">
                                                <p><?php echo $_SESSION['phone']; ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>My Interests/Hobbies</label>
                                            </div>
                                            <div class="col-md-9">
                                                <p><?php echo $_SESSION['hobbies']; ?></p>
                                            </div>
                                        </div> 

                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>My Favorite Book</label>
                                            </div>
                                            <div class="col-md-9">
                                                <p><?php echo $_SESSION['book']; ?></p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>My Website</label>
                                            </div>
                                            <div class="col-md-9">
                                                <p><a 
                                                href='<?php echo $_SESSION["website"]; ?>"' target='_blank'><?php echo $_SESSION['website']; ?></a></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>GIFT METHOD</label>

                                            </div>
                                            <div class="col-md-7">
                                                <p><?php
                        if(isset($_SESSION['giftMethods'])){$num = count($_SESSION['giftMethods']);}else{$num = 0;}
                        if($num < 1){
                            echo '<div class="card bg-light">
                                  <div class="card-header bg-purple font-white">GIFT METHOD</div>
                                  <div class="card-body"></div>
                                </div>';
                        } else {
                            $method = "";
                            $editMethod = "";
                            for($i=0; $i<$num; $i++){
                                $method = $method . $_SESSION['giftMethods'][$i]['method'] . " - " . $_SESSION['giftMethods'][$i]['username'] . "<br>";
                                $editMethod = $editMethod . '<input type="checkbox" name="method" value="">' . $method;
                            }
                            echo '<div class="card bg-light">
                                  <div class="card-header bg-purple font-white">GIFT METHOD</div>
                                  <div class="card-body" style="font-family:sans-serif;">' . $method . '</div>
                                </div>';
                        }
                        
                        ?></p>
                                            </div>
                                        </div>

                                              
                            </div>
                            
                            
                        
                          </div>
                           </div>
                           </div>
                         </form> 
                          </div>
                        </div>
                    <!-- /form card change password -->

                         </div>
                
                         </div>
                        
                          </div>
                           
           
        </section><!-- #content end -->
          
      <!-- Modal -->
        <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Edit User Info</h4>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form class="form-horizontal" data-toggle="validator" id="registerForm" role="form">

                          <div class="form-group">
                            <label  class="sr-only" for="first_name"></label>
                            <div class="col-sm-12" inputGroupContainer>
                                <div class="input-group">
                                <button type="button" class="btn btn-dark btn-block" data-dismiss="modal" data-toggle="modal" data-target="#editMethods">EDIT/ADD GIFT METHODS</button>  
                                </div><!--input-group-->
                            </div><!--inputGroupContainer-->
                          </div><!--form-group-->
                            
                          <div class="form-group">
                            <label  class="sr-only" for="first_name"></label>
                            <div class="col-sm-12" inputGroupContainer>
                                <div class="input-group">
                                <button type="button" class="btn btn-dark btn-block" data-dismiss="modal" data-toggle="modal" data-target="#editUser">EDIT PERSONAL INFO</button>  
                                </div><!--input-group-->
                            </div><!--inputGroupContainer-->
                          </div><!--form-group-->
                            
                          <div class="form-group">
                            <label  class="sr-only" for="change password"></label>
                            <div class="col-sm-12" inputGroupContainer>
                                <div class="input-group">
                                <button type="button" class="btn btn-dark btn-block" data-dismiss="modal" data-toggle="modal" data-target="#changePassword">CHANGE PASSWORD</button>  
                                </div><!--input-group-->
                            </div><!--inputGroupContainer-->
                          </div><!--form-group-->
                           <div class="form-group">
                            <label  class="sr-only" for="first_name"></label>
                            <div class="col-sm-12" inputGroupContainer>
                                <div class="input-group">
                                <button type="button" class="btn btn-dark btn-block" data-dismiss="modal" data-toggle="modal" data-target="#editUser">EDIT PERSONAL INFO</button>  
                                </div><!--input-group-->
                            </div><!--inputGroupContainer-->
                          </div><!--form-group-->

                            
                        </form> 
                    </div><!--modal-body-->

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" id="editUserSubmit" name="submit" class="btn btn-dark">Update</button>
                    </div><!--modal-footer-->
                </div><!--modal-content-->
            </div><!--modal-dialog-->
        </div><!--modal register-->
          
        <!-- Modal -->
            <div class="modal fade" id="changePassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel2">Change Password</h4>
                        </div>

                        <!-- Modal Body -->
                        <div class="modal-body">
                            <form class="form-horizontal" data-toggle="validator" id="registerForm2" role="form">
                                
                                <div class="form-group">
                                    <label  class="sr-only" for="email"><?php echo $email; ?></label>
                                    <div class="col-sm-12" inputGroupContainer>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                            <input type="text" class="form-control" 
                                            id="email" name="email" value="<?php echo $_SESSION['email']; ?>"/>
                                        </div><!--input-group-->
                                    </div><!--inputGroupContainer-->
                                </div><!--form-group-->

                              <div class="form-group">
                                <label class="sr-only" for="password" >Enter Current Password</label>
                                <div class="col-sm-12" inputGroupContainer>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input type="password" class="form-control"
                                        id="currPassword" name="currPassword" data-minlength="6" placeholder="Enter Current Password"/>
                                    </div><!--input-group-->
                                </div><!--inputGroupContainer-->
                              </div><!--form-group-->
                                
                              <div class="form-group">
                                <label class="sr-only" for="password" >Enter New Password</label>
                                <div class="col-sm-12" inputGroupContainer>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input type="password" class="form-control"
                                        id="password" name="password" data-minlength="6" placeholder="Enter New Password"/>
                                    </div><!--input-group-->
                                </div><!--inputGroupContainer-->
                              </div><!--form-group-->
                                
                                <div class="form-group">
                                <label class="sr-only" for="confirmPassword" >Confirm Password</label>
                                <div class="col-sm-12" inputGroupContainer>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input type="password" class="form-control"
                                        id="confirmPassword" name="confirmPassword" data-minlength="6" placeholder="Confirm Password"/>
                                    </div><!--input-group-->
                                </div><!--inputGroupContainer-->
                              </div><!--form-group-->

                            </form> 
                        </div><!--modal-body-->

                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" id="chPassSubmit" name="submit" class="btn btn-dark">Update</button>
                        </div><!--modal-footer-->
                    </div><!--modal-content-->
                </div><!--modal-dialog-->
            </div><!--modal register-->
          
          <?php 
      echo
        '<!-- Modal -->
        <div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel3">Edit User Info</h4>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form class="form-horizontal" data-toggle="validator" id="registerForm3" role="form">

                          <div class="form-group">
                            <label  class="sr-only" for="first_name"></label>
                            <div class="col-sm-12" inputGroupContainer>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input type="text" class="form-control" 
                                    id="first_name" name="first_name" value="' .  $_SESSION["first_name"] . '" placeholder="First Name"/>
                                </div><!--input-group-->
                            </div><!--inputGroupContainer-->
                          </div><!--form-group-->

                            <div class="form-group">
                                <label  class="sr-only" for="last_name">Last Name</label>
                                <div class="col-sm-12" inputGroupContainer>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input type="text" class="form-control" 
                                        id="last_name" name="last_name" value="' .  $_SESSION['last_name'] . '" placeholder="Last Name"/>
                                    </div><!--input-group-->
                                </div><!--inputGroupContainer-->
                            </div><!--form-group-->

                            <div class="form-group">
                                <label  class="sr-only" for="email">Email</label>
                                <div class="col-sm-12" inputGroupContainer>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                        <input type="email" class="form-control" 
                                        id="email2" name="email2" value="' . $_SESSION['email'] . '" placeholder="Email"/>
                                    </div><!--input-group-->
                                </div><!--inputGroupContainer-->
                            </div><!--form-group-->

                          <div class="form-group">
                            <label class="sr-only" for="phone" >Phone</label>
                            <div class="col-sm-12" inputGroupContainer>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
                                    <input type="text" class="form-control"
                                    id="phone" name="phone" data-minlength="6" value="' . $_SESSION['phone'] . '" placeholder="Phone"/>
                                </div><!--input-group-->
                            </div><!--inputGroupContainer-->
                          </div><!--form-group-->
                     
                          <div class="form-group">
                            <label class="sr-only" for="phone" >Phone</label>
                            <div class="col-sm-12" inputGroupContainer>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
                                    <input type="text" class="form-control"
                                    id="hobbies" name="hobbies"  value="' . $_SESSION['hobbies'] . '" placeholder="My Interest/Hobbies (Singing,Dancing)"/>
                                </div><!--input-group-->
                            </div><!--inputGroupContainer-->
                          </div><!--form-group-->

                          <div class="form-group">
                            <label class="sr-only" for="phone" >Phone</label>
                            <div class="col-sm-12" inputGroupContainer>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
                                    <input type="text" class="form-control"
                                    id="book" name="book"  value="' . $_SESSION['book'] . '" placeholder="My Favorite Book"/>
                                </div><!--input-group-->
                            </div><!--inputGroupContainer-->
                          </div><!--form-group-->

                          <div class="form-group">
                            <label class="sr-only" for="phone" >Phone</label>
                            <div class="col-sm-12" inputGroupContainer>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
                                    <input type="text" class="form-control"
                                    id="website" name="website"  value="' . $_SESSION['website'] . '" placeholder="My Website"/>
                                </div><!--input-group-->
                            </div><!--inputGroupContainer-->
                          </div><!--form-group-->

                        <div class="form-group">
                            <label for="addReferrer">Select Inviter</label>
                            <select class="form-control referrer_name" name="referrer_name"><option>' . $_SESSION['referrer_name'] . '</option>'
                               . $_SESSION['optionsBoards'] .
                            '</select>
                          </div>
                          
                        <div class="form-group">
                            <div class="col-sm-12" inputGroupContainer>
                                <div class="input-group">
                                    <input type="hidden" class="form-control" 
                                    id="tlf_id" name="tlf_id" value="' . $_SESSION['tlf_id'] . '" placeholder="Referrer Code" readonly/>
                                </div><!--input-group-->
                            </div><!--inputGroupContainer-->
                        </div><!--form-group-->

                        </form> 
                    </div><!--modal-body-->

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" id="editSubmit" name="submit" class="btn btn-dark">Update</button>
                    </div><!--modal-footer-->
                </div><!--modal-content-->
            </div><!--modal-dialog-->
        </div><!--modal register-->';
      ?>
          
        <?php 
          $numMethods = count($_SESSION['giftMethods']);
          $gifts = '<!-- Modal -->
                <div class="modal fade" id="editMethods" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel3">Edit/Add Gift Methods</h4>
                            </div><!--modal-header-->
                            
                            <!-- Modal Body -->
                            <div class="modal-body">
                            <form class="form-horizontal" data-toggle="validator" id="loginForm" role="form">';
          
                        for($i=0; $i<$numMethods; $i++) {
                            $username = $_SESSION['giftMethods'][$i]['username'];
                            $method = $_SESSION['giftMethods'][$i]['method'];
                            $id = $_SESSION['giftMethods'][$i]['id'];
                            $method_num = $i+1;
                            $gifts = $gifts . '<div class="form-group">
                                <label for="giftMethods">Gift Method ' . $method_num . '</label>
                                <div class="col-sm-12" inputGroupContainer>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-credit-panel"></i></span>
                                        <input list="methods" class="form-control" name="method" id="method' . $i . '" value="' . $method . '">
                                          <datalist id="methods">
                                            <option value="Paypal">
                                            <option value="Zelle">
                                            <option value="Venmo">
                                            <option value="CashApp">
                                          </datalist>
                                    </div><!--input-group-->
                                </div><!--inputGroupContainer-->
                            </div><!--form-group-->

                            <div class="form-group">
                                <label class="sr-only" for="username" >Username</label>
                                <div class="col-sm-12" inputGroupContainer>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input type="text" class="form-control"
                                        id="giftUsername' . $i . '" name="giftUsername" data-minlength="6" placeholder="Username" value="' . $username . '"/>
                                    </div><!--input-group-->
                                </div><!--inputGroupContainer-->
                              </div><!--form-group-->
                          
                        <div class="form-group">
                            <div class="col-sm-12" inputGroupContainer>
                                <div class="input-group">
                                    <input type="hidden" class="form-control" 
                                    id="id' . $i . '" name="id" value="' . $id . '" placeholder="Referrer Code" readonly/>
                                </div><!--input-group-->
                            </div><!--inputGroupContainer-->
                        </div><!--form-group-->';
                        }
                                
                                
                              $gifts = $gifts .  '<div class="form-group">
                                <label for="giftMethods">Add Gift Method</label>
                                <div class="col-sm-12" inputGroupContainer>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-credit-panel"></i></span>
                                        <input list="methods" class="form-control" name="method" id="method' . $numMethods . '">
                                          <datalist id="methods">
                                            <option value="Paypal">
                                            <option value="Zelle">
                                            <option value="Venmo">
                                            <option value="CashApp">
                                          </datalist>
                                    </div><!--input-group-->
                                </div><!--inputGroupContainer-->
                            </div><!--form-group-->

                            <div class="form-group">
                                <label class="sr-only" for="username" >Username</label>
                                <div class="col-sm-12" inputGroupContainer>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input type="text" class="form-control"
                                        id="giftUsername' . $numMethods. '" name="giftUsername" data-minlength="6" placeholder="Username"/>
                                    </div><!--input-group-->
                                </div><!--inputGroupContainer-->
                              </div><!--form-group-->
                          
                            <div class="form-group">
                                <div class="col-sm-12" inputGroupContainer>
                                    <div class="input-group">
                                        <input type="hidden" class="form-control" 
                                        id="tlf_id' . $numMethods . '" name="tlf_id" value="' . $_SESSION['tlf_id'] . '" placeholder="Referrer Code" readonly/>
                                    </div><!--input-group-->
                                </div><!--inputGroupContainer-->
                            </div><!--form-group-->
                              
                              </form><!--form-horizontal--> 
                            </div><!--modal-body-->

                            <!-- Modal Footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <button type="submit" name="submit" class="btn btn-dark" onclick="editGiftMethod(' . $numMethods . ');">Update</button>
                            </div><!--modal-footer-->
                        </div><!--modal-content-->
                    </div><!--modal-dialog-->
                </div><!--modal login-->';
          echo $gifts;
          
          /* this is for my edit methods
          
                <div class="form-check form-check-inline">
                  <label class="form-check-label" for="defaultCheck1">'
                     . $editMethod .  
                  '</label>
                  </div>
          */
          ?>
          <?php include "_/components/php/new_footer.php"; ?>
      
<script>
function copyStringToClipboard (str) {
   // Create new element
   var el = document.createElement('textarea');
   // Set value (string to be copied)
   el.value = str;
   // Set non-editable to avoid focus and move outside of view
   el.setAttribute('readonly', '');
   el.style = {position: 'absolute', left: '-9999px'};
   document.body.appendChild(el);
   // Select text inside element
   el.select();
   // Copy text to clipboard
   document.execCommand('copy');
    alert('Link Copied!');
   // Remove temporary element
   document.body.removeChild(el);
}


$('#upload113').on('click', function() {
    var file_data = $('#sortpicture').prop('files')[0];   
    var tlf_id = $('#tlf_id').val();   
    var form_data = new FormData();                  
    form_data.append('profile', file_data);
    form_data.append('tlf_id', tlf_id);
                             
    $.ajax({
        url: 'upload.php', // point to server-side PHP script 
        dataType: 'text',  // what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,                         
        type: 'post',
        success: function(php_script_response){
            alert(php_script_response); // display response from the PHP script, if any
        }
     });
});

$('#editMethodsSubmit').click(function(){
    var method = $("#method").val();
    var username = $("#giftUsername").val();
    var dataString = 'method=' + method + '&username=' + username;
         jQuery.ajax({
             type: "POST",
             url: "_/components/php/editMethods.php",
             data: dataString,
             success: function(){
                    $("#editUser").modal('hide');
                     window.location.href = "user.php"; 
             },
             error: function(data){
             alert('error' + data);
             }
        });
});

function editGiftMethod(numMethods) {
    var new_count = numMethods + 1;
    var new_method = document.querySelector('#method'+numMethods).value;
    if(new_method == "") {
        var count = numMethods;
        var addedMethod = 0;
    }else{
        var count = new_count;
        var addedMethod = 1;
    }
    var dataString = 'addedMethod=' + addedMethod + '&count=' + count;
    for(i=0; i<count; i++) {
        if(addedMethod == 1) {
            if(i == numMethods) {
                var method = document.querySelector('#method'+i).value;
                var username = document.querySelector('#giftUsername'+i).value;
                var tlf_id = document.querySelector('#tlf_id'+i).value;

                dataString = dataString + '&method' + i + '=' + method + '&username' + i + '=' + username + '&tlf_id=' + tlf_id; 
            } else {
                var method = document.querySelector('#method'+i).value;
                var username = document.querySelector('#giftUsername'+i).value;
                var id = document.querySelector('#id'+i).value;

                dataString = dataString + '&method' + i + '=' + method + '&username' + i + '=' + username + '&id'+ i + '=' + id; 
            }
            
        } else {
            var method = document.querySelector('#method'+i).value;
            var username = document.querySelector('#giftUsername'+i).value;
            var id = document.querySelector('#id'+i).value;

            dataString = dataString + '&method' + i + '=' + method + '&username' + i + '=' + username + '&id'+ i + '=' + id; 
        }
    } 
    
     jQuery.ajax({
         type: "POST",
         url: "_/components/php/editGiftMethods.php",
         data: dataString,
         success: function(msg){
                alert(msg);
                $("#editMethods").modal('hide');
                 window.location.href = "user.php"; 
         },
         error: function(data){
         alert('error' + data);
         }
    });
}




</script>