<?php require_once("_/components/php/includes/session.php"); ?>
<?php require_once("_/components/php/includes/connection.php"); ?>
<?php require_once("_/components/php/includes/functions.php"); ?>

 <style>
   .error{
color:red
}
span#error_message {
    color: red;
}
span#error_category {
    color: red;
}
 </style>

         <?php include "_/components/php/new_header.php"; ?>
         <!-- #page-menu end -->
         <!-- Content -->
         <section id="content">
            <div class="content-wrap py-0">
               <div id="section-about" class="center">
                  <div class="section m-0">
                     <div class="container clearfix">
                        <div style="text-align: right;">
                           <button class="btn profile-btn" data-toggle="modal" data-target="#myModalmsg">Add Message</button>
                        </div>
                        <div class="mx-auto center">
                           <h2 class="font-weight-light ls1">Flip Messages</h2>
                        </div>
                        <!--======= show data =========-->
                        <?php 
                           $sql_show="SELECT * FROM  admin_message";
                           $obj_show=mysqli_query($connection,$sql_show);
                          
                        ?>
                        <div class="row grid-container" data-layout="masonry" style="overflow: visible">
                           <div class="table-responsive">
                              <table class="table table-striped">
                                 <thead class="modal-head">
                                    <tr>
                                       <th scope="col">S.No</th>
                                       <th scope="col">Category</th>
                                       <th scope="col">Message</th>
                                       <th scope="col">Status</th>
                                       <th scope="col">Action</th>
                                       
                                    </tr>
                                 </thead>
                                 <tbody>

                                    <?php 
                                    $sno='1'; 
                                    while ($data=mysqli_fetch_assoc($obj_show)) {
                                      
                                    ?>
                                    <tr>
                                       <td><?php echo $sno;?></td>
                                       <td><?php echo $data['category'];?></td>
                                       <td><?php echo $data['message'];?></td>
                                       
                                       <td>
                            <button type="button" id="button" class="btn btn-status profile-btn <?php echo ($data['status']==1)?'bg-success':'bg-danger'?>" data-id="<?php echo $data['id'];?>" data-status="<?php echo $data['status'];?>" ><?php 
                              if($data['status']==1){ 
                                 echo 'Active'; 
                              }else{ 
                                 echo 'Inactive'; 
                              } 
                              ?></button> </td>
                                       <!-- <button type = "button" class = "btn btn-danger disabled">Inactive</button> -->
                                      
                                        <td><span><a class="btn_edit" href="update.php?userid=<?php echo $data['id'];?>"><button class="profile-btn1"><i class="fa fa-pencil-square-o success fa-lg success" style="color: #fff" aria-hidden="true"></i></button></a></span>
                                           &nbsp;
                                         <a href="delete.php?userid=<?php echo $data['id']; ?>" onClick="javascript:return confirm('Are you sure you want to delete this?')"><button class="profile-btn1"><i class="fa fa-trash-o fa-lg danger"  style="color: #fff" aria-hidden="true"></i></button></a>
                                       </td> 
                                    </tr>                                    
                                 <?php $sno++; } ?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- #content end -->
         <!-- Footer-->
         <?php include "_/components/php/new_footer.php"; ?>
         <!-- #footer end -->
     
      <!-- Modal -->
      <div class="pl-0 modal fade" id="myModalmsg" role="dialog">
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="modal-header modal-head">
                  <p class="modal-title">Add Message</p>
               </div>
               <div class="modal-body">
                  <div class="card-body">
                     <form method="post" action="">
                        <div class="form-group">
                           <label for="inputPasswordNew">Category</label>
                           <select class="form-control" name="category"  id="category">
                              <option value="">Select Category</option>
                              <option value="tree">Tree</option>
                              <option value="family">Family</option>
                              <option value="farvest">Harvest</option>
                              <option value="admin">Admin</option>
                            
                           </select>
                           <span id="error_category"></span>
                        </div>
                        <div class="form-group">
                           <label for="inputPasswordOld">Message</label>
                           <textarea  type="text" name="message" id="message"value="utf8[mb4]_unicode_ci" class="form-control" id="inputPasswordOld"></textarea>
                          <span id="error_message"></span>
                        </div>
                        
                       
                        <button type="button" class="btn profile-btn1 btn-add" >Save</button>
                        <button type="button" class="btn profile-btn1 " data-dismiss="modal">Cancel</button>
                     </form>
                  </div>
               </div>
               
            </div>
         </div>
      </div>
<!-- =========update========== -->

     
      <!-- JavaScripts
         ============================================= -->



      <script src="assets/js/jquery.js"></script>

      <script src="assets/js/plugins.min.js"></script>
      <!-- <script src="https://maps.google.com/maps/api/js?key=YOUR-API-KEY"></script> -->
      <!-- For Countdown -->
      <script src="assets/js/components/moment.js"></script>
      <!-- Footer Scripts
         ============================================= -->
      <script src="assets/js/functions.js"></script>
      <script type="text/javascript">

         $(".btn-add").click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "change_status.php",
                type: "POST",
                dataType:'json',
                data: {action:'add',category:$("#category").val(),message:$("#message").val()},
                success: function (response) 
                {
                  console.log(response); 
                  if(response.status=='error'){
                     if(response.message.err_category!='undefined'){
                        $("#error_category").html(response.message.err_category);
                       
                     }
                     if(response.message.err_message!='undefined'){
                        $("#error_message").html(response.message.err_message);
                     }
                     return false;
                  }  
                  if(response.status=='success'){        
                     alert('Message has been updated successfully');
                     location.reload(); 
                  }
                }

            });
         });
       
         $(".btn-status").click(function() {
            
            $.ajax({
                url: "change_status.php",
                type: "POST",
                data: {id:$(this).data('id'),status:$(this).data('status')},
                success: function (response) 
                {
                  console.log(response);           
                  alert('Status has been updated successfully');
                  location.reload(); 
                }

            });
         });
         
      </script>
 

      <style type="text/css">
         .footer-links {
         display: inherit !important;
         }
        
      </style>
   </body>
</html>

