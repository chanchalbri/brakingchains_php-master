<?php require_once("_/components/php/includes/session.php"); 
 require_once("_/components/php/includes/connection.php"); 
 require_once("_/components/php/includes/functions.php"); 

   ini_set('display_errors',1);
   error_reporting(E_ALL);
    $tlf_id = trim($_REQUEST['tlf_id']);	
       $s = $_FILES['profile']['tmp_name'];
	   $d = "images/".$_FILES['profile']['name'];
	   $f =   $_FILES['profile']['name'];
	
		if(move_uploaded_file($s,$d)) { 
       //Update user	
		$query = "UPDATE users  SET  profile='$f' WHERE  tlf_id='{$tlf_id}' ";
		echo $query;
		$result = mysqli_query($connection, $query);
		confirm_query($result, $connection);
        if(mysqli_affected_rows($connection) > 0) {
		$_SESSION['profile'] = $f;
		header("location:user.php");
		 } 
		}
      else  {
     echo  "Upload failed with error code " . $_FILES['profile']['error'];
      }
  	
?>