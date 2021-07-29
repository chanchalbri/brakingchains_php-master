
<?php require_once("_/components/php/includes/connect.php"); ?>
<?php 
// $connection=mysqli_connect("localhost","root","","thelotus");
    //print_r($_POST);die;
if(isset($_POST['category']) && !empty($_POST['category'])){
    $sql_show="SELECT * FROM  admin_message WHERE status=1 and category='".$_POST['category']."' ORDER BY rand() LIMIT 1";
    $obj_show=mysqli_query($connection,$sql_show);
    //confirm_query($obj_show, $connection);
    $message="";
    $row=mysqli_fetch_array($obj_show);
         $message=$row['message'];
    
    echo json_encode(array('content'=>$message));
     exit;
   } 




?>