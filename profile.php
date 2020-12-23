<?php 
  
  ob_start(); 
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/x-icon" href="fav.png">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/profile.css">
<title>Voter's Profile</title>
</head>
<body>
  <?php include'nav.php'; ?>
<?php include'connect.php'; ?>

<?php 
error_reporting(0);
session_start();

$email =  $_SESSION['email'];

$query = "SELECT * FROM `voters` WHERE email = '{$email}'";
   $data = mysqli_query($conn , $query);
   if (!$data) {  
    die("Failed".mysqli_error($conn));
      }

        while($row = mysqli_fetch_assoc($data)){
          $voter_id = $row['voter_id'];
            $name = $row['full_name'];
            $db_email = $row['email'];
            $contact = $row['contact_no'];
            $voter_id_no = $row['voter_id_no'];
            $token = $row['voter_token'];
            $profile = $row['voter_profile'];
        }
       

?>
<?php if(isset($_SESSION['loggedin'])){   ?>
<div class="wrapper" style="margin-top:70px;">
<!-- <h1 class="text mb-4" style="text-align:center">Voter Profile Card</h1> -->

<div class="card" >
  <div class="row">
  <a class="ml-4 mt-2" href="#" data-toggle="modal" data-target="#myModal" title="Change Profile">
  <i class="fa fa-camera text-primary" aria-hidden="true" style="font-size:25px;" id="logout"></i>
  </a>
  <?php


 
if (isset($_POST['upload'])) {

   $profileimg = $_FILES["profileimg"]["name"];
  $profileimg_tmp = $_FILES["profileimg"]["tmp_name"];

  $fileinfo = @getimagesize($profileimg_tmp);
  $width = $fileinfo[0];
  $height = $fileinfo[1];
  
  $allowed_image_extension = array(
    "png",
    "jpg",
    "jpeg"
  );
  
  
  $file_extension = pathinfo($profileimg, PATHINFO_EXTENSION);
  
 
  if (!file_exists( $profileimg_tmp)) {
    $response = array(
      "message" => "Choose image file to upload."
    );
  }    
  else if (!in_array($file_extension, $allowed_image_extension)) {
    $response = array(
      "message" => "Upload valid images. Only PNG and JPEG are allowed."
    );
    
  }    
  else if (($_FILES["profileimg"]["size"] > 2000000)) {
    $response = array(
      "message" => "Image size exceeds 2MB"
    );
  }    
  else if ($width > "300" || $height > "200") {
    $response = array(
      "message" => "Image dimension should be within 300X200"
    );
  } 
  else {
 $target_dir = "profile/";
 $target_file = $target_dir . basename($profileimg); 

 move_uploaded_file($profileimg_tmp, $target_file);
  }

  echo ".";
  
  if(!empty($response)) {  
 $msg = $response["message"];
 
 echo "<script type='text/javascript'>
 swal('$msg' , 'Go back and try again.','error');
 </script>";
 
  }else {
   $query = "UPDATE `voters` SET `voter_profile`='{$profileimg}' WHERE `voter_id` = $voter_id";
    
   $upload = mysqli_query($conn , $query);
  
    
   echo ".";
  
     if ($upload) { 
  
  echo '<script type="text/javascript">
  swal("Profile Uploaded Successfully :)", "", "success").then(() => {
  window.location.href="profile.php";
  });
  
  </script>';
  
   } else { 
  echo '<script type="text/javascript">
  swal("Something went wrong :(", "Go back and try again.", "error");
  </script>';
    }
  } 

}

?>

 <!-- The Modal -->
 <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header" >
          <h4 class="modal-title"><b>Upload Profile Photo</b></h4>
          <a type="button" class="close" data-dismiss="modal">&times;</a>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <input type="file" class="form-control"  name="profileimg">
            </div>
            <input type="submit" class="btn btn-primary" value="Upload" name="upload">
            </form>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal" style="width:90px;">Close</button>
        </div>
        
      </div>
    </div>
  </div>
  

  
  <a href="profile.php?act=logout" style="margin-left:228px;margin-top:5px;" title="Logout Voter"><i class="fa fa-sign-out " aria-hidden="true" style="font-size:30px; color:red;" id="logout"></i></a>
  </div>
  
  <?php
         
          $act = $_GET['act'];

				  if($act=='logout'){
				  	echo '<script type="text/javascript">
            swal({
              title: "Are you sure want to logout?",
              text: "Once logout, you will not be able to vote!",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {
                window.location.href="logout.php";
              } else {
                swal("Logout has been canceled!");
              }
            });
            </script>';
          }
          
          ?>
          
  <img src="profile/<?php echo $profile ?>" alt="John" style="border-radius: 50%;padding:40px;">
  
   <h2 ><?php echo $name ?></h2>
  
  <p class="title"><?php echo $voter_id_no ?></p>
  <p><?php echo $db_email ?></p>
  <p><?php echo $contact ?></p>

  <p><button onclick="location.href='candidate.php'">Vote Now!</button></p>
      
</div>
<br>

<?php 

    $query = "SELECT * FROM `voter_voted_or_not` WHERE voter_id = {$voter_id}";
   $res = mysqli_query($conn , $query);
   if (!$res) {  
    die("Failed".mysqli_error($conn));
      }

      while($row = mysqli_fetch_assoc($res)){
          $is_voted = $row['is_voted'];
      }

      $q = "SELECT * FROM `voters` WHERE voter_id = {$voter_id}";
      $rese = mysqli_query($conn , $q);
      if (!$rese) {  
       die("Failed".mysqli_error($conn));
         }
   
         while($row = mysqli_fetch_assoc($rese)){
             $is_verified = $row['is_verified'];
         }

    
      if($is_verified == "yes"){
        if(!$is_voted){
      ?>


<div class="card2 mb-1" style="background: #fff;">
<input type="text" value="<?php echo $token ?>" id="myInput">
<button onclick="myFunction()">copy token to vote</button>
</div>

<?php 
        }  
        else if($is_voted){
          ?>
        <div class="card2" style="background: #fff;">
        <h1 style="color: #000;">You have already voted!</h1>
        </div>
          <?php
        }   
}else {
  ?>
<div class="card2" style="background: #fff;">
<h1 style="color: #000;">You are not verified.Can't vote!</h1>
</div>

<?php
}
  ?>
  
<br><br>
<?php include'bubble.php'; ?>
    
    </div>
</body>
</html>

<script>
function myFunction() {
  var copyText = document.getElementById("myInput");
  copyText.select();
  copyText.setSelectionRange(0, 99999)
  document.execCommand("copy");
  swal("Copied the text:", copyText.value, "info");
}

</script>
<?php }else {
  header("Location: login.php");
}
?>