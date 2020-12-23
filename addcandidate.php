<?php 
  session_start();
  ob_start(); 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
<link rel="icon" type="image/x-icon" href="fav.png">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
  
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
  
  <link rel="stylesheet" href="mdbcss/mdb.min.css">

<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
    <title>Verify Voters</title>

</head>
<body style="background-color: #76b852;">
<?php if(isset($_SESSION['admin_loggedin'])){   ?>
<div id="wrapper">
<?php include'connect.php'; 
error_reporting(0);
?>
<?php include'sidebar.php'; ?>
<?php


 
if (isset($_POST['submit'])) {

  $name = mysqli_real_escape_string($conn , $_POST['name']);
  $partyname = mysqli_real_escape_string($conn , $_POST['partyname']);
  $contact = mysqli_real_escape_string($conn , $_POST['contactno']);
  


   $candidateimg = $_FILES["candidateimg"]["name"];
  $candidateimg_tmp = $_FILES["candidateimg"]["tmp_name"];

 
  $fileinfo = @getimagesize($candidateimg_tmp);
  $width = $fileinfo[0];
  $height = $fileinfo[1];
  
  $allowed_image_extension = array(
      "png",
      "jpg",
      "jpeg"
  );
  
  
  $file_extension = pathinfo($candidateimg, PATHINFO_EXTENSION);
  
 
  if (!file_exists( $candidateimg_tmp)) {
      $response = array(
          "message" => "Choose image file to upload."
      );
  }    
  else if (!in_array($file_extension, $allowed_image_extension)) {
      $response = array(
          "message" => "Upload valid images. Only PNG and JPEG are allowed."
      );
      
  }    
  else if (($_FILES["voterimg"]["size"] > 2000000)) {
      $response = array(
          "message" => "Image size exceeds 2MB"
      );
  }    
  else if ($width > "1400" || $height > "1200") {
      $response = array(
          "message" => "Image dimension should be within 1400X1200"
      );
  } 
  else {
   $target_dir = "../can_img/";
   $target_file = $target_dir . basename($candidateimg); 

   move_uploaded_file($candidateimg_tmp, $target_file);
  }

  echo ".";
  
  if(!empty($response)) {  
   $msg = $response["message"];
   
   echo "<script type='text/javascript'>
   swal('$msg' , 'Go back and try again.','error');
   </script>";
   
    }else{
        $query = "INSERT INTO `candidates`(`name`, `party_name`, `contact`, `image`) VALUES ('{$name}','{$partyname}','{$contact}','{$candidateimg}')";
    
        $register = mysqli_query($conn , $query);
    
        
        echo ".";
       
        if ($register) { 
    
    echo '<script type="text/javascript">
    swal("Candidate Added Successfully :)", "", "success").then(() => {
    window.location.href="addcandidate.php";
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
<div class="main-w3layouts wrapper">
    
  
    
    <div class="main-agileinfo">
      <div class="agileits-top">
        <form  action="" method="POST" enctype="multipart/form-data">
          <input class="text" type="text" name="name" placeholder="Candidate Name" required="">
                    <input class="text email" type="text" name="partyname" placeholder="Party Name" required="">
                    <input class="text email" type="number" name="contactno" placeholder="Phone Number" required="">
          <label for="candidateimg" style="color: white;">Candidate Image</label>
                     <input type="file" name="candidateimg">
          <input type="submit" name="submit" value="ADD">
        </form>
      </div>
    </div>
    </div>
    <?php include'bubble.php'; ?> 
 

</body>
</html>
<?php }else {
  header("Location: admin_login.php");
}
?>
    