<!DOCTYPE html>
<html>
<head>
  <title>Voter Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="fav.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<?php include'nav.php'; ?>
<?php include'connect.php'; ?>

   <?php
    session_start();
    
    if(isset($_POST['submit'])) {


   $email = mysqli_real_escape_string($conn , $_POST['email']);
   $psw = mysqli_real_escape_string($conn , $_POST['psw']);

   $_SESSION['email'] = $email;
  
   $query = "SELECT * FROM `voters` WHERE email = '{$email}'";
   $data = mysqli_query($conn , $query);
   $num_rows = mysqli_num_rows($data);
   if ($num_rows == 1) {
     $_SESSION['loggedin'] = true;
 }
   if (!$data) {  
    die("Failed".mysqli_error($conn));
        }

        while($row = mysqli_fetch_assoc($data)){
          
          $db_email = $row['email'];
          $db_psw = $row['password'];
          $token = $row['voter_token'];
        }

      
        echo ".";
        
        $verify = password_verify($psw, $db_psw);
if($email === $db_email){
  if($verify){
    echo '<script type="text/javascript">
    swal("Login Successful :)", "Please Vote.", "success").then(() => {
      window.location.href="profile.php";
    });
    
    </script>';


   }else{
    echo '<script type="text/javascript">
    swal("Login Failed :(", "Invalid Credentials.", "error");
    </script>';
   }

 
}



}
   ?>


<div class="main-w3layouts wrapper" style="margin-top:73px;">
    
    <h1>Voter Login </h1>
    
    <div class="main-agileinfo">
      <div class="agileits-top">
        <form  action="" method="POST" enctype="multipart/form-data">
          
          <input class="text email" type="email" name="email" placeholder="Email" required="">
          <input class="text" type="password" name="psw" placeholder="Password" required="">
          
          <input type="submit" name="submit" value="LOGIN" width="200">
        </form>
        <p>Not Registered Yet.<a href="index.php"> Register here!</a></p>
      </div>
    </div><br><br><br><br><br><br><br><br><br>
  
<?php include'bubble.php'; ?>
  </div>
  <!-- //main -->

</body>
</html>