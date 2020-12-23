<?php include'connect.php';?>
<?php 
$id=$_POST["id"];
$status=$_POST["status"];
   $unverify = "UPDATE `voters` SET `is_verified`='$status' WHERE `voter_id`=$id";
   $u_status =  mysqli_query($conn , $unverify);

  
?>