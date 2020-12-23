<!DOCTYPE html>
<html>
<head>
  <title>Admin Login</title>
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

   $admin_name = mysqli_real_escape_string($conn , $_POST['admin_name']);
   $email = mysqli_real_escape_string($conn , $_POST['email']);
   $psw = mysqli_real_escape_string($conn , $_POST['psw']);
  
   $query = "SELECT * FROM `admin`";
   $data = mysqli_query($conn , $query);
   $num_rows = mysqli_num_rows($data);

   if ($num_rows == 1) {
     $_SESSION['admin_loggedin'] = true;
     $_SESSION['admin_name'] = $admin_name;
 }
   if (!$data) {  
    die("Failed".mysqli_error($conn));
        }

        while($row = mysqli_fetch_assoc($data)){
          
          $db_email = $row['email'];
          $db_psw = $row['password'];
        
        }

      
        echo ".";
        
       
if(($email === $db_email) && ($psw === $db_psw)){
 
    echo '<script type="text/javascript">
    swal("Admin LoggedIn Successfully :)", "", "success").then(() => {
      window.location.href="voter_verify.php";
    });
    
    </script>';

}else{
    echo '<script type="text/javascript">
    swal("Login Failed :(", "Invalid Credentials.", "error");
    </script>';
   }



}
   ?>


<div class="main-w3layouts wrapper" style="margin-top:73px;">
    
    <h1>Admin Login</h1>
    
    <div class="main-agileinfo">
      <div class="agileits-top">
        <form  action="" method="POST" enctype="multipart/form-data">
        <input class="text" type="text" name="admin_name" placeholder="Admin Name" required="">
          <input class="text email" type="email" name="email" placeholder="Email" required="">
          <input class="text" type="password" name="psw" placeholder="Password" required="">
          
          <input type="submit" name="submit" value="LOGIN" width="200">
        </form>
      
      </div>
    </div><br><br><br><br><br><br><br><br><br>
  
<?php include'bubble.php'; ?>
  </div>
  <!-- //main -->

</body>
</html>
