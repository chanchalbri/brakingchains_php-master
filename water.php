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


  <?php include "_/components/php/new_header.php"; ?>
  <style type="text/css">
    .modal-backdrop.show {
    opacity: 0 !important;
    }
    .modal-backdrop {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    z-index: 0 !important;
    width: 0vw !important;
    height: 0vh !important;
    background-color: #000 !important;
}
#page-menu-wrap {
  z-index: 1 !important;
}
</style>
  <section id="content">
      <div class="content-wrap py-0">
        <div id="section-about" class="center">
                <div class="section">
            <div class="container clearfix">

              <div class="mx-auto center">
                <h2 class="font-weight-light ls1">My Harvest</h2>
              </div>
              <div class="row grid-container" data-layout="masonry" style="overflow: visible">
   
<?php 
    $tlf_id = $_SESSION['tlf_id'];

 echo getLastGift($connection, $tlf_id);
 echo getNextGift($connection, $tlf_id); 
    
?>

</div>  
            </div>
          </div>
        </div>
      </div>
    </section><!-- #content end -->
      
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

<script type="text/javascript">
  $(document).ready(function(){
    $(".flip-card").mouseover(function(){
      console.log("run mousehover event");
      var $container=$(this).find(".flip-card-inner").find("p.message");
     
         $.ajax({
                type: "POST",
                url: "flip_messages.php",
                data: {action:'get_message',category:'harvest'},
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
         

      //$(this).find(".flip-card-inner").find("p.message").html("this is test message");
      //$('.pizza-maker').children('.cheese').children('a').addClass('cheese-style')
    });
  });
</script> 

  <script type="text/javascript">
    $(document).ready(function(){
      
      $("body").on("click",".view_detail_btn",function(){
        $("#data-table").html('');
        var id=$(this).data("flower_id");
        var next_water="";
        next_water=$(this).data("next_water");
        $("#myModal").modal("show");
        if($(this).data("gift")=='board_fires'){
          $("#flower_id").html("Board ID #"+id);
        }else{
          $("#flower_id").html("Flower ID #"+id);
        }
        
        jQuery.ajax({
                type: "POST",
                url: "_/components/php/modal_harvest.php",
                data: {id:$(this).data("flower_id"),lotus_id:$(this).data("lotus_id"),gift:$(this).data("gift"),next_water:next_water},
                dataType:'json',
                success: function(data) {
                    console.log(data); 
                    $("#data-table").html(data.content);
                                  
                },
                error: function(e) {
                    console.log(e);
                }
            })
      });

    });


  </script>   

   <script type="text/javascript">
    $(document).ready(function(){
      
      $("body").on("click",".view_detail_btn",function(){
        $("#data-table").html('');
        var id=$(this).data("flower_id");
        var next_water="";
        next_water=$(this).data("next_water");
        $("#myModal").modal("show");
        if($(this).data("gift")=='board_fires'){
          $("#flower_id").html("Board ID #"+id);
        }else{
          $("#flower_id").html("Flower ID #"+id);
        }
        
        jQuery.ajax({
                type: "POST",
                url: "_/components/php/modal_harvest.php",
                data: {id:$(this).data("flower_id"),lotus_id:$(this).data("lotus_id"),gift:$(this).data("gift"),next_water:next_water},
                dataType:'json',
                success: function(data) {
                    console.log(data); 
                    $("#data-table").html(data.content);
                                  
                },
                error: function(e) {
                    console.log(e);
                }
            })
      });

    });


  </script>
      
    <!-- Modal -->
                      <div class="modal fade pl-0" id="myModal" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                             <div class="modal-header">
          
                              <h4 class="modal-title" id="flower_id">Flower ID #56501</h4>
                               </div>
                               <div class="modal-body">
                               <div class="card-body">
                              <div class="table-responsive" id="data-table">
                              
                  
                             </div>
                                
                   </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn profile-btn" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>