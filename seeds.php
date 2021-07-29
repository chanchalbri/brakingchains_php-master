<?php require_once("_/components/php/includes/session.php"); ?>
<?php require_once("_/components/php/includes/connection.php"); ?>
<?php require_once("_/components/php/includes/functions.php"); ?>
<?php 
// index.php - landing page of the TLF website
// will show login button
//
// (c) 2020, TLF
// Written by James Misa

$referrer_name = $_SESSION['first_name'] . " " . $_SESSION['last_name'];
$tlf_id = $_SESSION['tlf_id'];
$target_fireDate = $_SESSION['fireDate'];
$_SESSION['navbar'] = 0;
?>

    <?php include "_/components/php/new_header.php"; ?>

     <section id="content">

            <div class="content-wrap py-0">
                <div id="section-about" class="center">

                <div class="section">

                        <div class="container clearfix">

                            <div class="mx-auto center">

                                <h2 class="font-weight-light ls1">My Seeds</h2>

                            </div>



                            <div class="grid-container" data-layout="masonry" style="overflow: visible">

    <?php if($_SESSION['flower'] == 1) {}

       

            $referrals = '<div class="col d-flex justify-content-center">
                    <div class="card .mx-auto" style="width: 38rem;">
                      <div class="card-header bg-dark text-white">
                        Co-Op Referral Commitment
                        </div>
                     <img src="images/grower.png" class="card-img-top" alt="...">
                      <ul class="list-group list-group-flush">
                        <li class="list-group-item">Water Name: ' . $water_name . '</li>
                        <li class="list-group-item">Water Gift Method: ' . $water_method . '</li>
                        <li class="list-group-item">Referrals Committed<span class="badge badge-pill badge-danger">2</span></li>
                        <li class="list-group-item">Referrals To Date<span class="badge badge-pill badge-danger">' . $next_seeds . '</span></li>
                        <li class="list-group-item">Needed Seeds for ' . $sunday . '<span class="badge badge-pill badge-danger">' . $needed_seeds . '</span></li>
                      </ul>
                      </div>
                    </div>';
                
                //echo $referrals;
           
                echo '<h2><img src="images/Seed.png" style="width:3.5vw; height:3.5vw;"> MY SEEDS</h2>';        
          //This query is to pull user's seeds	
            $query = sprintf("SELECT * FROM users WHERE referrer='%s' && flower=0 ORDER BY first_name ASC, last_name ASC", 
                mysqli_real_escape_string($connection, $tlf_id));

                $result = mysqli_query($connection, $query);

                if (mysqli_num_rows($result) > 0) {
                        
                        //User has seeds
                        $num = 1;
                        while($found_seeds = mysqli_fetch_array($result)){
                            $seed_name = $found_seeds['first_name'] . " " . $found_seeds['last_name'];
                            $fireDate = $found_seeds['fireDate'];
                            if($fireDate == ""){
                                $formatted_fireDate = "";
                            } else {
                                $formatted_fireDate = date("m/d/Y", $fireDate);
                            }
                            $seed_tlf_id = $found_seeds['tlf_id'];  
                                                                                         
                            $query2 = sprintf("SELECT * FROM milestones WHERE tlf_id='%s'", 
                            mysqli_real_escape_string($connection, $seed_tlf_id));

                            $result2 = mysqli_query($connection, $query2); 
                            while($found_milestone = mysqli_fetch_array($result2)) {
                                $percentage = $found_milestone['percentage'];
                            }
                            // echo '<button type="button" class="btn btn-default btn-lg btn-block" data-toggle="modal" data-target="#new-seed" style="font-family:sans-serif;" disabled><span class="full-name">#' . $num . ": " . $seed_name . "</span>  Exp. Fire Date: " . $formatted_fireDate . '<span class="counts">' . $percentage . '%</span></button>';

                            echo '<div class="col-lg-4 mb-4">

                                    <div class="flip-card top-to-bottom">

                                        <div class="flip-card-front dark" data-height-xl="200" >

                                            <div class="flip-card-inner">

                                                <div class="card bg-transparent border-0">

                                                    <div class="card-body">

                                                        <h3 class="card-title mb-0">' . $num . ': '. $seed_name . ' ' . $percentage . '%</h3>

                                                        <span class="">Exp. Fire Date: '. $formatted_fireDate . '</span>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="flip-card-back" data-height-xl="200" >

                                            <div class="flip-card-inner">

                                                <!-- <p class="mb-2 text-white">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Alias cum repellat velit.</p> -->

                                                <button type="button" data-toggle="modal" data-target="#new-seed" class="btn btn-outline-light mt-2">View Tree</button>

                                            </div>

                                        </div>

                                    </div>

                                </div>';



                            $num++;
                        }
                        //echo getEcoSeeds($connection, $tlf_id); 
                    } else {
                        echo '<h2>You do not currently have any seeds.</h2>
                            <h2>What is a Seed?</h2>
                            <h3>A seed meets all of the following criteria.</h3>
                            <div class="milestone_wrapper text-left col-lg-6 offset-lg-4">
                            <ul id="seed_milestones" style="font-family:sans-serif;">
                                <li>A seed has viewed the presentation.</li> 
                                <li>A seed has positively answered the 4 questions.</li> 
                                <li>A seed has committed to joining the co-op.</li> 
                                <li>A seed has chosen a targeted Sow Date.</li> 
                                <li>Ready to add your first seed?</li>      
                            </ul>
                        </div> ';
                    }
    
            //echo '<h2><i class="fas fa-seedling"></i> MY FAMILY SEEDS</h2>';
    
    echo showTerms();
    echo showTnCs($_SESSION['tlf_id']);
    echo showPrivacy();
            
          ?>

                            </div>  

                        </div>

                    </div>

                </div>

            </div>

        </section><!-- #content end -->
          
          <!-- Modal -->
            <div class="modal fade" id="new-seed" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Enter New Seed</h4>
                        </div>

                        <!-- Modal Body -->
                        <div class="modal-body">
                            <form class="form-horizontal" data-toggle="validator" id="registerForm" role="form">

                              <div class="form-group">
                                <label  class="sr-only" for="first_name">First Name</label>
                                <div class="col-sm-12" inputGroupContainer>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input type="text" class="form-control" 
                                        id="first_name" name="first_name" placeholder="First Name"/>
                                    </div><!--input-group-->
                                </div><!--inputGroupContainer-->
                              </div><!--form-group-->

                                <div class="form-group">
                                    <label  class="sr-only" for="last_name">Last Name</label>
                                    <div class="col-sm-12" inputGroupContainer>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                            <input type="text" class="form-control" 
                                            id="last_name" name="last_name" placeholder="Last Name"/>
                                        </div><!--input-group-->
                                    </div><!--inputGroupContainer-->
                                </div><!--form-group-->

                                <div class="form-group">
                                    <label  class="sr-only" for="email">Email</label>
                                    <div class="col-sm-12" inputGroupContainer>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                            <input type="email" class="form-control" 
                                            id="email" name="email" placeholder="Email"/>
                                        </div><!--input-group-->
                                    </div><!--inputGroupContainer-->
                                </div><!--form-group-->

                              <div class="form-group">
                                <label class="sr-only" for="phone" >Phone</label>
                                <div class="col-sm-12" inputGroupContainer>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input type="tel" class="form-control"
                                        id="phone" name="phone" data-minlength="6" placeholder="Phone"/>
                                    </div><!--input-group-->
                                </div><!--inputGroupContainer-->
                              </div><!--form-group-->

                            <div class="form-group">
                                <label  class="sr-only" for="referrer_name"><?php echo $referrer_name; ?></label>
                                <div class="col-sm-12" inputGroupContainer>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input type="text" class="form-control" 
                                        id="referrer_name" name="referrer_name" value="<?php echo $referrer_name; ?>" disabled/>
                                    </div><!--input-group-->
                                    <p class="desc">Referrer</p>
                                </div><!--inputGroupContainer-->
                            </div><!--form-group-->

                                <div class="form-group">
                                    <label  class="sr-only" for="fireDate">Targeted Fire Date</label>
                                    <div class="col-sm-12" inputGroupContainer>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                            <input type="date" class="form-control" 
                                            id="fireDate" name="fireDate"  placeholder="Fire Date"/>
                                        </div><!--input-group-->
                                        <p class="desc">Enter Targeted Fire Date - must be a Sunday</p>
                                    </div><!--inputGroupContainer-->
                                </div><!--form-group-->

                                <div class="form-group">
                                    <div class="col-sm-12" inputGroupContainer>
                                        <div class="input-group">
                                            <input type="hidden" class="form-control" 
                                            id="ref_id" name="ref_id" value="<?php echo $tlf_id; ?>" placeholder="Referrer Code" readonly/>
                                        </div><!--input-group-->
                                    </div><!--inputGroupContainer-->
                                </div><!--form-group-->

                            </form> 
                        </div><!--modal-body-->

                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" id="regSubmit" name="submit" class="btn btn-primary">Add</button>
                        </div><!--modal-footer-->
                    </div><!--modal-content-->
                </div><!--modal-dialog-->
            </div><!--modal register-->
    
    <!-- Modal -->
            <div class="modal fade" id="termsOptIn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Privacy Policy and Terms & Conditions</h4>
                        </div>

                        <!-- Modal Body -->
                        <div class="modal-body">
                            <form class="form-horizontal" data-toggle="validator" id="registerForm" role="form">


                            <div class="form-group">
                                <label  class="sr-only" for="referrer_name"><?php echo $referrer_name; ?></label>
                                <div class="col-sm-12" inputGroupContainer>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    </div><!--input-group-->
                                    <p>Hello Eden Family!</p>
                                    <p>Please review and agree to our Privacy Policy and our Terms and Conditions before entering the software.</p>
                                    <p>Thank you!</p>
                                </div><!--inputGroupContainer-->
                            </div><!--form-group-->

                                <div class="form-group">
                                    <div class="col-sm-12" inputGroupContainer>
                                        <div class="input-group">
                                            <input type="hidden" class="form-control" 
                                            id="tlf_id" name="ref_id" value="<?php echo $tlf_id; ?>" placeholder="Referrer Code" readonly/>
                                        </div><!--input-group-->
                                    </div><!--inputGroupContainer-->
                                </div><!--form-group-->
                                
                            <div class="form-inline">
                                <div class="form-check">
                                   <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" onchange="activateButton(this)"/>
                                  <label class="form-check-label" for="defaultCheck1">
                                    I agree to the <a href="#privacy" data-toggle="modal" data-target="#privacy">Privacy Policy</a> and <a href="#terms" data-toggle="modal" data-target="#terms">Terms and Conditions</a>
                                  </label>
                                </div>
                            </div><!--form-group-->


                            </form> 
                        </div><!--modal-body-->

                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" id="checkLogin" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" id="termsSubmit" name="submit" class="btn btn-primary" disabled>OK</button>
                        </div><!--modal-footer-->
                    </div><!--modal-content-->
                </div><!--modal-dialog-->
            </div><!--modal register-->

    
      <!-- footer -->
<footer class="wrapper dark" id="footer">
      
    <div class="container">
      <div class="row ">

        <div class=" col-lg-5 footer-widget">
          <div class="widget-box">
            <div class="widget-title">
              <h3>About</h3>
            </div>
        <div class="widget-about">
                        
        <p>Our vision is to boldly and confidently create a continuous, self-supporting, wealth-building platform that enables every man, woman and child to become socially and economically self-motivated, self-educated and self-empowered to break the proverbial chains of generational poverty, perceived limitations, lack and fear.</p>
                       
                       
        </div>

        </div>
      </div><!-- .footer-widget -->
        <div class="col-lg-4 footer-widget">
          <div class="widget-box">
            <div class="widget-title">
              <h3>Head Office</h3>
            </div>   
            <ul class="widget-box-ul">
             <li><i class="fa fa-map-marker"></i>&nbsp;&nbsp;&nbsp; 
              <span>4850 Sugarloaf Parkway Suite 209-146, Lawrenceville, GA 30044</span>
            </li>
            <li><a href="mailto:info@breakingchainscoop.com"><i class="fa fa-envelope"></i>&nbsp;&nbsp;&nbsp; <span>info@breakingchainscoop.com</span></a>
            </li>
            <li><i class="fa fa-clock-o"></i>&nbsp;&nbsp;&nbsp; <span>Mon - Fri: 10:00am - 10:00pm EST, Sat: 10am - 2pm EST, Sun: Closed</span>
            </li>  
            </ul>
        </div>
      </div><!-- .footer-widget -->
        <div class="col-lg-3 footer-widget">
          <div class="widget-box">
            <div class="widget-title">
              <h3>Menu</h3>
            </div>
         <ul class="menu-li">
                <li><a title="Home" href="https://www.breakingchainscoop.com/">Home</a></li>
                <li><a title="About BCPC" href="https://www.breakingchainscoop.com/about-us/">About BCPC</a></li>
                <li><a title="Articles" href="https://www.breakingchainscoop.com/articles/">Articles</a></li>
                <li><a title="Shop" href="https://www.breakingchainscoop.com/store/">Shop</a></li>
                <li><a title="Contact Us" href="https://www.breakingchainscoop.com/contact-us/">Contact Us</a></li>
                <li><a title="Member Login" href="https://www.breakingchainscoop.com/login/">Member Login</a>
                 <ul class="menu-li pt-2">
                   <li><a title="My Account" href="#">My Account</a></li>
                   <li><a title="Logout" href="https://www.breakingchainscoop.com/">Logout</a>
                 </ul>
                </li>
              </ul>
            </div>
          </div><!-- .footer-widget -->
      </div>
    </div>

     
<hr>

      <!-- Copyrights -->

      <div id="copyrights">
        <div class="container">
          <div class="w-100 text-center">
          Copyright © 2021 Breaking Chains Private Cooperative - All Rights Reserved. 
          </div>
<div class="row">
<div class="col-md-7 xs-padding">
<ul class="footer-menu pb-0">
<li class=""><a href="#">Home</a></li>
<li class=""><a href="#">About BCPC</a></li>
<li class=""><a href="#">Articles</a></li>
<li class=""><a href="#">Shop</a></li>
<li class=""><a href="#">Contact Us</a></li>
<li><a title="Member Login" href="#">Member Login</a></li>
            </ul>
</div>
</div>
        </div>

      </div><!-- #copyrights end -->

    </footer><!-- #footer end -->

  </div><!-- #wrapper end -->



  <!-- Go To Top

  ============================================= -->

  <div id="gotoTop" class="icon-angle-up"></div>
  
<!-- Modal -->
<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">The Eden Project Login</h4>
            </div><!--modal-header-->
            
           <!-- Modal Body -->
            <div class="modal-body">
                <form class="form-horizontal" data-toggle="validator" id="loginForm4" role="form">
                    
                <div class="form-group">
                    <label  class="sr-only" for="email">Email</label>
                    <div class="col-sm-12" inputGroupContainer>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                            <input type="email" class="form-control" 
                            id="loginEmail" name="loginEmail" placeholder="Email"/>
                        </div><!--input-group-->
                    </div><!--inputGroupContainer-->
                </div><!--form-group-->

                <div class="form-group">
                    <label class="sr-only" for="password" >MyPassword</label>
                    <div class="col-sm-12" inputGroupContainer>
                        <div class="input-group" id="visibility">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input type="password" class="form-control"
                            id="loginPassword" name="loginPassword" data-minlength="6" placeholder="Password"/><div class="input-group-addon">
                            <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                            </div>
                        </div><!--input-group-->
                    </div><!--inputGroupContainer-->
                  </div><!--form-group-->
                    
                <h4>First Time? Go to www.breakingchainscoop.com to register.</h4>
                    
                </form><!--form-horizontal--> 
            </div><!--modal-body-->

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" id="loginSubmit" name="submit" class="btn btn-primary">Login</button>
            </div><!--modal-footer-->
        </div><!--modal-content-->
    </div><!--modal-dialog-->
</div><!--modal login-->
<!-- JavaScripts

  ============================================= -->

  
    <script src="assets/js/jquery.js"></script>

    <script src="assets/js/plugins.min.js"></script>

    <!-- For Countdown -->

    <script src="assets/js/components/moment.js"></script>

    <script src="assets/js/carousel/jquery-3.3.1.min.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <script src="assets/js/carousel/jquery-migrate-3.0.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
       
        <script src="assets/js/carousel/jquery.backstretch.min.js"></script>
        <script src="assets/js/carousel/wow.min.js"></script>
        <script src="assets/js/carousel/waypoints.min.js"></script>
        <script src="assets/js/carousel/scripts.js"></script>


    <!-- Footer Scripts

    ============================================= -->

    <script src="assets/js/functions.js"></script>

     <!-- <script src="assets/js/_myscript.js"></script> -->
     <!-- new change -->
     <script>


       $('#loginSubmit').click(function(){
    
    var email = $("#loginEmail").val();
    var password = $("#loginPassword").val();
    var dataString = 'email=' + email + '&password=' + password;
    if (email == '' || password == '') {
        alert("Please fill all fields"); 
    } else {
         jQuery.ajax({
             type: "POST",
             url: "_/components/php/processLogin.php",
             data: dataString,
             success: function(data1){
                var obj = JSON.parse(data1);
                localStorage.setItem("logged_in", "IN");
                localStorage.setItem("terms", obj[1]);
                localStorage.setItem("tlf_id", obj[2]);
                window.location.href = "seeds.php"; 
                },
             error: function(data1){
                alert(data1);
             }
            });
    }
});

$('#editSubmit').click(function(){
        var first_name = $("#first_name").val();
        var last_name = $("#last_name").val();
        var email = $("#email2").val();
        var phone = $("#phone").val();
        var hobbies = $("#hobbies").val();
        var book = $("#book").val();
        var website = $("#website").val();
        var referrer_name= $(".referrer_name").val();
        var tlf_id = $("#tlf_id").val();
        var dataString = 'first_name=' + first_name + '&last_name=' + last_name + '&email=' + email + '&phone=' + phone + '&referrer_name=' + referrer_name + '&tlf_id=' + tlf_id + '&hobbies=' + hobbies + '&book=' + book + '&website=' + website;
             
             jQuery.ajax({
                 type: "POST",
                 url: "_/components/php/editUser.php",
                 data: dataString,
                 success: function(){
                         alert('User updated');
                        //$("#editUser").modal('hide');
                         window.location.href = "user.php"; 
                 },
                 error: function(data){
                 alert('error' + data);
                 }
            });
    });

$('#replaceFlowerSubmit').click(function(){
    var replFlower = $("#replacedFlower").val();
    var addedFlower = $("#addedFlower").val(); 
    var dataString = 'replacedFlower=' + replFlower + '&addedFlower=' + addedFlower;
         jQuery.ajax({
             type: "POST",
             url: "_/components/php/replaceFlower.php",
             data: dataString,
             success: function(data1){
                     alert(data1);
                    // $("#replaceFlower").modal('hide');
                     window.location.href = "admin_portal.php";  
             },
             error: function(data){ 
             alert(data);
             }
            }); 
});


function getSeeds() { 
   $('#addTree').css("display",'none');
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
             
             //$("#addFromSeeds").modal();
         },
         error: function(data){
         alert('error' + data);
         }
    });
} 

function getTrees() {
$('#addTree').css("display",'none'); 
    jQuery.ajax({
         type: "POST",
         url: "_/components/php/getTreesList.php",
         success: function(msg){
             var select = document.getElementById("addNewTree"); 
             var obj = JSON.parse(msg);
             for(var i = 0; i < obj.length; i++) {
                var optVal = obj[i]['tlf_id'];
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
             var desc = document.getElementById("treeDesc");
             desc.innerHTML = note;
             //$("#addFromTrees").modal('show');

         },
         error: function(data){
         alert('error' + data);
         }
    });
}


$('#addSeedSubmit').click(function(){
    var seed_id = $("#addSeed").val();
    var fireDate = $("#fireDate3").val(); 
    var parent_id = localStorage.getItem('parent_id');
    var dataString = 'seed_id=' + seed_id + '&parent_id=' + parent_id + '&fireDate=' + fireDate;
    if (fireDate == '') {
        alert("Please select a Sow Date"); 
    } else {
         jQuery.ajax({
             type: "POST",
             url: "_/components/php/addFlower.php",
             data: dataString,
             success: function(data){
                    alert(data);
                      $('#addFromSeeds').css("display",'none');
                     window.location.href = "myTrees.php";  
             },
             error: function(data){
             alert(data);
             }
            }); 
    }
});

$('#addTreeSubmit').click(function(){
    var tree_id = $("#addNewTree").val();
    var fireDateTree = $("#fireDateTree").val(); 
    var parent_id = localStorage.getItem('parent_id');
    var dataString = 'tree_id=' + tree_id + '&parent_id=' + parent_id + '&fireDateTree=' + fireDateTree;
    if (fireDateTree == '') {
        alert("Please select a Sow Date"); 
    } else {
         jQuery.ajax({ 
             type: "POST",
             url: "_/components/php/addTree.php",
             data: dataString,
             success: function(data){
                    alert(data);
                    $('#addFromTrees').css("display",'none');
                     window.location.href = "myTrees.php";  
             },
             error: function(data){
             alert(data);
             }
            }); 
    }
});

function treeView(id, user) {
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
<style type="text/css">

  .footer-links {

    display: inherit !important;

  }

</style>



</body>

</html>
     

<script>
 function disableSubmit() {
  document.getElementById("termsSubmit").disabled = true;
 }

  function activateButton(element) {

      if(element.checked) {
        document.getElementById("termsSubmit").disabled = false;
       }
       else  {
        document.getElementById("termsSubmit").disabled = true;
      }

  }
</script>