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
      <th class="th-sm">ID

      </th>
      <th class="th-sm">Name

      </th>
      <th class="th-sm">Email

      </th>
      <th class="th-sm">Contact

      </th>
      <th class="th-sm">Voter ID Number

      </th>
      <th class="th-sm">Voter ID Image

      </th>
      
      <th class="th-sm">Status

      </th>
      <th >Action

      </th>

 
    </tr>
    
  </thead>
  <tbody>
 
    <?php 

$query = "SELECT `voter_id`, `full_name`, `email`, `contact_no`, `voter_id_no`, `voter_img`, `voter_token`, `is_verified` FROM `voters`";
$data = mysqli_query($conn , $query);
while($row = mysqli_fetch_assoc($data)){
    $voter_id = $row['voter_id'];
    $voter_name = $row['full_name'];
    $voter_email = $row['email'];
    $voter_no = $row['contact_no'];
    $voter_id_no = $row['voter_id_no'];
    $voter_img = $row['voter_img'];
    $voter_verified = $row['is_verified'];
   ?>
<tr>
      <td><?php echo $voter_id ?></td>
      <td><?php echo $voter_name ?></td>
      <td><?php echo $voter_email ?></td>
      <td><?php echo $voter_no ?></td>
      <td><?php echo $voter_id_no ?></td>
      <td><img src="uploads/<?php echo $voter_img ?>" height="50" width="60"
    onclick="onClick(this)" class="w3-hover-opacity">
    <div id="modal01" class="w3-modal" onclick="this.style.display='none'">
  <span class="w3-button w3-hover-red w3-xlarge w3-display-topright" style="background-color:red;">&times;</span>
  <div class="w3-modal-content w3-animate-zoom">
    <img id="img01" style="width:70%">
  </div>
</div>
    </td>
    <td>
        <?php if($voter_verified == 'no'){
 
           ?>
          
          <b style="font-weight:800;color:red;">UNVERIFIED</b>
             
           <?php

        }else{
            ?>
               
               <b style="font-weight:800;color:green;">VERIFIED</b>
            <?php
        } ?>  
     
    
    </td>
      <td>
        <?php if($voter_verified == 'no'){
 
           ?>
          
        <span class="btn btn-success" title="verify voter" id="<?php echo $voter_id ?>"><i class="fa fa-check" aria-hidden="true"></i></span>
             
           <?php

        }else{
            ?>
               <span class="btn btn-danger" title="unverify voter" id="<?php echo $voter_id ?>"><i class="fa fa-times" aria-hidden="true"></i></span>
               <!-- <a class="btn btn-danger" href="voter_verify.php?id=<?php echo $voter_id ?>&status=<?php echo  $voter_verified ?>">Unverify</a> -->
            <?php
        } ?>  
     
    
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
<th>Name

</th>
<th >Email

</th>
<th >Contact

</th>
<th >Voter ID Number

</th>
<th >Voter ID Image

</th>

<th >Is verified

</th>
<th >Action

</th>
      
    </tr>
  </tfoot>
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
    "paging": false // false to disable pagination (or any other option)
  });
  $('.dataTables_length').addClass('bs-select');
});

function onClick(element) {
  document.getElementById("img01").src = element.src;
  document.getElementById("modal01").style.display = "block";
}

$(document).ready(function(){
  $('span.btn-success').on('click', function (e) {
    e.preventDefault();
    $.ajax({
      url:'verify.php',
      method:'POST',
      data:{
          id:this.id,
          status:'yes'
      },
      success:function(response){
       window.location.reload(true);
      
      }
  });
});

});

$(document).ready(function(){
  $('span.btn-danger').on('click', function (e) {
    e.preventDefault();
    $.ajax({
      url:'unverify.php',
      method:'POST',
      data:{
          id:this.id,
          status:'no'
      },
      success:function(response){
       window.location.reload(true);
      
      }
  });
});

});
  </script>

</body>
</html>
<?php }else {
  header("Location: admin_login.php");
}
?>
    