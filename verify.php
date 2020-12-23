<?php include'connect.php';?>
<?php 
$id=$_POST["id"];
$status=$_POST["status"];

$verify = "UPDATE `voters` SET `is_verified`='$status' WHERE `voter_id`=$id";
$v_status =  mysqli_query($conn , $verify);


?>