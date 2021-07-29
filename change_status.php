<?php require_once("_/components/php/includes/connect.php"); ?>
<?php 

//$conn=mysqli_connect("localhost","root","","thelotus");
$id=$status="";
$action=isset($_POST['action'])?$_POST['action']:'';
 

if($action=='add'){
  $errors=array();
  $category=$_POST['category'];
    $message=trim($_POST['message']);
  if(empty($category)){
      $is_error=1;
       $errors['err_category']="Category is required";
    }
   if(empty($message)){
      $is_error=1;
       $errors['err_message']="Message is required";
   }
   if(count($errors)>0){
      echo json_encode(['status'=>'error','message'=>$errors]);
      exit;
   }
   else{
      $sql="INSERT INTO admin_message SET category='".$category."', message='".addslashes($message)."'";

     $obj=mysqli_query($connection,$sql);
     if ($obj) {

      echo json_encode(['status'=>'success','message'=>'Message added successfully.']);
      exit;
     }
   }

}else{
$id=isset($_POST['id'])?$_POST['id']:'';
  if(isset($_POST['status'])){
      $status =$_POST['status']==1?0:1;
      }
      

$sql="UPDATE admin_message SET status='$status' WHERE id=".$id;
mysqli_query($connection,$sql) or die(mysqli_error());    
echo "1";
}


