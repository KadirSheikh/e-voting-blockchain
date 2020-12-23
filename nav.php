<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="fav.png">
  <title>Navbar</title>
  <link rel="stylesheet"  integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
</html>
<?php include'connect.php'; ?>
 
<!--Navbar -->
<nav class="mb-1 navbar navbar-expand-lg navbar-light  fixed-top" style="background-color: rgba(255, 255, 255, 0.2);">
  <a class="navbar-brand">e-Voting(blockchain)</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-4"
    aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
    <ul class="navbar-nav ml-auto">
 
    <?php 
error_reporting(0);
session_start();
$activePage = basename($_SERVER['PHP_SELF'], ".php");

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    ?>
  
  <li class="nav-item <?= ($activePage == 'admin_login') ? 'active':''; ?>" >
        <a class="nav-link" href="admin_login.php" style="font-size:18px;">
        <i class="fa fa-lock" aria-hidden="true"></i> Admin</a>
      </li>
      <li class="nav-item <?= ($activePage == 'candidate') ? 'active':''; ?>">
        <a class="nav-link" href="candidate.php" style="font-size:18px;">
        <i class="fa fa-archive" aria-hidden="true"></i> Vote Now</a>
      </li>
     
      <li class="nav-item dropdown <?= ($activePage == 'profile') ? 'active':''; ?>">
        <a class="nav-link dropdown-toggle " id="navbarDropdownMenuLink-4" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false" style="font-size:18px;">
          <i class="fa fa-user" aria-hidden="true"></i> Profile </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-info" aria-labelledby="navbarDropdownMenuLink-4">
          <a class="dropdown-item" href="profile.php" style="font-size:15px;">My account</a>
          <a class="dropdown-item" href="<?php echo $activePage ?>.php?act=logout" style="font-size:15px;">Log out</a>
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
        </div>
      </li>
    <?php
    
} else {
    ?>
       <li class="nav-item <?= ($activePage == 'admin_login') ? 'active':''; ?>" >
        <a class="nav-link" href="admin_login.php" style="font-size:18px;">
        <i class="fa fa-lock" aria-hidden="true"></i> Admin</a>
      </li>
     <li class="nav-item <?= ($activePage == 'login') ? 'active':''; ?>">
        <a class="nav-link" href="login.php" style="font-size:18px;">
        <i class="fa fa-sign-in" aria-hidden="true"></i> Login</a>
      </li>
   <li class="nav-item <?= ($activePage == 'index') ? 'active':''; ?>">
        <a class="nav-link" href="index.php" style="font-size:18px;">
        <i class="fa fa-user-plus" aria-hidden="true"></i> Register
          
        </a>
      </li>
     
    <?php

}


?>

  
    </ul>
  </div>
</nav>
<!--/.Navbar -->