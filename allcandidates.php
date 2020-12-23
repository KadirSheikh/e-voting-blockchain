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
      <th class="th-sm">ID

      </th>
      <th class="th-sm">Candidate's Name

      </th>
      <th class="th-sm">Pary Name

      </th>
      <th class="th-sm">Candidate's Contact

      </th>
    
      <th class="th-sm">Candidate's Image

</th>

 
    </tr>
    
  </thead>
  <tbody>
 
    <?php 

$query = "SELECT * FROM `candidates`";
$data = mysqli_query($conn , $query);
while($row = mysqli_fetch_assoc($data)){
    $candidate_id = $row['can_id'];
    $candidate_name = $row['name'];
    $candidate_party = $row['party_name'];
    $candidate_no = $row['contact'];
    $candidate_img = $row['image'];
   ?>
<tr>
      <td><?php echo $candidate_id ?></td>
      <td><?php echo $candidate_name ?></td>
      <td><?php echo $candidate_party ?></td>
      <td><?php echo $candidate_no ?></td>
      <td><img src="can_img/<?php echo $candidate_img ?>" height="50" width="60"
    onclick="onClick(this)" class="w3-hover-opacity">
    <div id="modal01" class="w3-modal" onclick="this.style.display='none'">
  <span class="w3-button w3-hover-red w3-xlarge w3-display-topright" style="background-color:red;">&times;</span>
  <div class="w3-modal-content w3-animate-zoom">
    <img id="img01" style="width:70%">
  </div>
</div>
    </td>
    </tr>

   <?php
    
}

?>

   
    
</tbody>
  <tfoot>
    <tr>
    <th>ID

</th>
<th>Candidate's Name

</th>
<th >Party Name

</th>
<th >Candidate's Contact

</th>
<th >Candidate's Image

</th>
      
    </tr>
  </tfoot>
</table>
</div>
    </div>
    <?php include'../bubble.php'; ?> 
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

function onClick(element) {
  document.getElementById("img01").src = element.src;
  document.getElementById("modal01").style.display = "block";
}
  </script>

</body>
</html>
<?php }else {
  header("Location: admin_login.php");
}
?>