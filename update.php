<?php require_once("_/components/php/includes/session.php"); ?>
<?php require_once("_/components/php/includes/connection.php"); ?>
<?php require_once("_/components/php/includes/functions.php"); ?>

<?php
// $connection=mysqli_connectionect("localhost","root","","thelotus");
$id = $_GET['userid'];
$sql = "SELECT * FROM admin_message WHERE id='$id'";
$obj = mysqli_query($connection,$sql);
$data = mysqli_fetch_assoc($obj);
if(isset($_POST['submit']))
{

$message=$_POST['message'];
$category=$_POST['category'];
$sql2 = "UPDATE admin_message SET id='$id',message='$message', category='$category'WHERE id='$id'";
$obj=mysqli_query($connection,$sql2);

if($obj)
{
    echo "<script>
    alert('success')
    window.location.href='admin.php'
    </script>";
}
else{
    echo "<script>
    alert('error')
    window.location.href='update.php'
    </script>";
}
}
if(isset($_POST['submit'])){
    if(!empty($_POST['category'])) {
        $category = $_POST['category'];
       
    } else {
        echo 'Please select the value.';
    }
    }
?>

<?php include "_/components/php/new_header.php"; ?>
         <!-- Content -->
         <section id="content">
            <div class="content-wrap py-0">
               <div id="section-about" class="">
                  <div class="section m-0">
                     <div class="container clearfix">
                        <!-- <div style="text-align: right;">
                           <button class="btn profile-btn" data-toggle="modal" data-target="#myModal">Add Messages</button>
                        </div> -->
                        <!-- <div class="mx-auto center">
                           <h2 class="font-weight-light ls1">Admin</h2>
                        </div> -->
         <!--#form section---start -->
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="modal-header modal-head">
                  <p class="modal-title">Edit Message</p>
               </div>
                <div class="modal-body">
                  <div class="card-body">
                     <form method="post" action="">
                          <div class="form-group">
                           <label for="inputPasswordNew">Category</label>
                           <select class="form-control " name="category">
                              <option value="">Select Category</option>
                              <option value="tree" <?php echo isset($data['category']) && $data['category']=='tree'?'selected="selected"':''?>>Tree</option>
                              <option value="family" <?php echo isset($data['category']) && $data['category']=='family'?'selected="selected"':''?>>Family</option>
                              <option value="harvest" <?php echo isset($data['category']) && $data['category']=='harvest'?'selected="selected"':''?>>Harvest</option>
                              <option value="admin" <?php echo isset($data['category']) && $data['category']=='admin'?'selected="selected"':''?>>Admin</option>
                           </select>
                          </div>
                        <div class="form-group">
                        <label>Message</label>
                        <textarea id="message" name="message" class="form-control" rows="4" cols="50"><?php echo $data['message'];?></textarea>
                        
                        </div>   
                       
                        
                          <input type="submit" name="submit" class="btn profile-btn1"> &nbsp;   
                          <a href="admin.php" class="btn profile-btn1" data-dismiss="modal">Cancel</a>        
                         <!--  <div class="modal-footer modal_footer">
                        
               </div> -->
                     </form>
                  </div>
              </div>
 <!--#form section---end-->
                        </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- #content end -->
         <!-- Footer-->
        <?php include "_/components/php/new_footer.php"; ?>
      <div id="gotoTop" class="icon-angle-up"></div>