<?php require_once("_/components/php/includes/session.php"); ?>
<?php require_once("_/components/php/includes/connection.php"); ?>
<?php require_once("_/components/php/includes/functions.php"); ?>
<?php
// $connection=mysqli_connectionect("localhost","root","","thelotus");

$id = $_GET['userid'];
$sql = "DELETE FROM admin_message WHERE id='$id'";
$obj = mysqli_query($connection,$sql);
if($obj)

	
{
	echo "<script>
  alert('Delete successfully')
  window.location.href='admin.php'
	</script>";
}
else{
	echo "<script>
	alert('Please try again')
	window.location.href='admin.php'
	</script>";
}
?>