
<!DOCTYPE html>
<html>
<head>
<title>Voter Registration</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/x-icon" href="fav.png">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  
<link href="//fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,700,700i" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<?php include'nav.php'; ?>	
<?php include'connect.php'; ?>
   
   <?php


 
 if (isset($_POST['submit'])) {

   $name = mysqli_real_escape_string($conn , $_POST['name']);
   $email = mysqli_real_escape_string($conn , $_POST['email']);
   $contact = mysqli_real_escape_string($conn , $_POST['contactno']);
   $psw = mysqli_real_escape_string($conn , $_POST['psw']);
   $voterno = mysqli_real_escape_string($conn , $_POST['voterno']);
   
   $psw = password_hash($psw, PASSWORD_DEFAULT);
   $token = hash('sha256', $voterno);

    $voterimg = $_FILES["voterimg"]["name"];
   $voterimg_tmp = $_FILES["voterimg"]["tmp_name"];

   $fileinfo = @getimagesize($voterimg_tmp);
   $width = $fileinfo[0];
   $height = $fileinfo[1];
   
   $allowed_image_extension = array(
	   "png",
	   "jpg",
	   "jpeg"
   );
   
   
   $file_extension = pathinfo($voterimg, PATHINFO_EXTENSION);
   
  
   if (!file_exists( $voterimg_tmp)) {
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
	$target_dir = "uploads/";
	$target_file = $target_dir . basename($voterimg); 
 
	move_uploaded_file($voterimg_tmp, $target_file);
   }

   echo ".";
   
   if(!empty($response)) {  
	$msg = $response["message"];
	
	echo "<script type='text/javascript'>
	swal('$msg' , 'Go back and try again.','error');
	</script>";
	
	 }else {
		$query = "INSERT INTO `voters`(`full_name`, `email`, `contact_no`, `password`, `voter_id_no`, `voter_img`, `voter_token`) VALUES ('{$name}' ,'{$email}' ,'{$contact}' , '{$psw}' , '{$voterno}' , '{$voterimg}' , '{$token}')";
     
		$register = mysqli_query($conn , $query);
   
	   
		echo ".";
   
			if ($register) { 
   
   echo '<script type="text/javascript">
   swal("Voter Registered Successfully :)", "Please Login.", "success").then(() => {
	 window.location.href="login.php";
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
<body>
    

	<div class="main-w3layouts wrapper mt-5">
		
		<h1>Voter Registration </h1>
    
		<div class="main-agileinfo">
			<div class="agileits-top">
				<form  action="" method="POST" enctype="multipart/form-data">
					<input class="text" type="text" name="name" placeholder="Full Name" required="">
                    <input class="text email" type="email" name="email" placeholder="Email" required="">
                    <input class="text email" type="number" name="contactno" placeholder="Contact Number" required="">
					<input class="text" type="password" name="psw" placeholder="Password" required="">
					<input class="text w3lpass" type="text" name="voterno" placeholder="Voter ID Number" required="">
					<label for="voterimg" style="color: white;">Voter ID Image</label>
                     <input type="file" name="voterimg">
                  
					<div class="wthree-text">
						<label class="anim">
							<input type="checkbox" class="checkbox" required="">
							<span>Yes, I am eligible to vote.</span>
						</label>
						<div class="clear"> </div>
					</div>
					<input type="submit" name="submit" value="REGISTER">
				</form>
				<p>Already Registered.<a href="login.php"> Login Now!</a></p>
			</div>
		</div>
	
<?php include'bubble.php'; ?>
	</div>
	
	<!-- //main -->
</body>
</html>