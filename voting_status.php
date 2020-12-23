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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="icon" type="image/x-icon" href="fav.png">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
  <!-- Google Fonts Roboto -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="mdbcss/bootstrap.min.css">
  <!-- Material Design Bootstrap -->
  <link rel="stylesheet" href="mdbcss/mdb.min.css">
  <!-- Your custom styles (optional) -->
  <link rel="stylesheet" href="mdbcss/style.css">
  <!-- MDBootstrap Datatables  -->
<link href="mdbcss/addons/datatables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <title>Verify Voters</title>

</head>
<body style="background-color: #76b852;">
<?php if(isset($_SESSION['admin_loggedin'])){   ?>
<div id="wrapper">
<?php include'connect.php'; 

error_reporting(0);
?>
<?php include'sidebar.php'; ?>
 
<div class="container" style="background-color: #fff;border-radius:10px;">
   <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%" >
   <thead>
    <tr>
      <th class="th-sm"><h3 style="text-align:center;"><b>Voting Status</b></h3>

      </th>
  </tr>
    
  </thead>
  <tbody>
 
    <?php 

$query = "SELECT * FROM `blockvotes`";
$data = mysqli_query($conn , $query);
while($row = mysqli_fetch_assoc($data)){
    $status = $row['data'];
   ?>
<tr>
      <td><h6>Voter <?php echo $status ?></h6></td>
</tr>

   <?php
    
}

?>

    
</tbody>
</table>
</div>
    </div>
    <?php include'bubble.php'; ?> 
 <!-- jQuery -->
 <script type="text/javascript" src="mdbjs/jquery.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="mdbjs/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="mdbjs/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="mdbjs/mdb.min.js"></script>
  <!-- Your custom scripts (optional) -->
  <!-- MDBootstrap Datatables  -->
<script type="text/javascript" src="mdbjs/addons/datatables.min.js"></script>
  <script type="text/javascript">
    // Basic example
$(document).ready(function () {
  $('#dtBasicExample').DataTable({
    "paging": true // false to disable pagination (or any other option)
  });
  $('.dataTables_length').addClass('bs-select');
});

  </script>

</body>
</html>
<?php }else {
  header("Location: admin_login.php");
}
?>
      