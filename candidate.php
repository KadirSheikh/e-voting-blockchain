<?php 
  
  ob_start(); 
?>
<?php include'connect.php'; ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
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
    <style>
    .custom{
    width: 300px;
    margin-left:auto;
    margin-right:auto;
    display:block;
    background: #69aa46;
  }
      </style>
</head>
<title>Candidates</title>
<body>
<?php include'nav.php'; ?>
<?php 
session_start();
error_reporting(0);
$email =  $_SESSION['email'];

$query = "SELECT * FROM `voters` WHERE email = '{$email}'";
   $data = mysqli_query($conn , $query);
   if (!$data) {  
    die("Failed".mysqli_error($conn));
        }

        while($row = mysqli_fetch_assoc($data)){
            $voter_id = $row['voter_id'];
            $voter_name = $row['full_name'];
            $voter_email = $row['email'];
            $voter_contact = $row['contact_no'];
            $voter_id_no = $row['voter_id_no'];
            $token = $row['voter_token'];
        }
       

?>

<?php 


$query = "SELECT * FROM `blockvotes`";
$data = mysqli_query($conn , $query);
   
   if (!$data) {  
    die("Failed".mysqli_error($conn));
        }

        while($row = mysqli_fetch_assoc($data)){
        $db_hash = $row['hash_id'];
        }

        $p_hash = $db_hash;
?>

<?php 

if(isset($_POST['vote'])){
  
  $entered_token = $_POST['voter_token'];
  $v_name = $_POST['voter_name'];
  $v_contact = $_POST['voter_contact'];
  $v_email = $_POST['voter_mail'];
  $c_name = $_POST['can_name'];
  $c_contact = $_POST['can_contact'];
  $candidate_id = $_POST['can_id'];
  $can_party = $_POST['can_party'];
  $flag = false;

  echo ".";
 if($entered_token !== $token){
  echo '<script type="text/javascript">
  swal("Invalid Token.", "Please Check Your Token and Try Again.", "error");
  </script>';
 }else{

   $data = $v_name . " voted for candidate " . $c_name . " of " . $can_party . " party"; 
   $hash_id =  hash('sha256', $v_contact);
   $pre_hash = $p_hash;

   $query = "INSERT INTO `blockvotes`(`data`, `hash_id`, `pre_hash_id`) VALUES ('{$data}','{$hash_id}','{$pre_hash}')";
   $result = mysqli_query($conn , $query);
   
   echo ".";
   if ($result)
    {  
      echo '<script type="text/javascript">
         swal("Thank You :)", "Your vote is recorded successfully.", "success").then(() => {
          window.location.href="profile.php";
        });
         </script>';
     
         $flag = true;
          
         $query1 = "INSERT INTO `voter_voted_or_not`(`voter_id`,`voter_name`, `voter_email`, `is_voted`) VALUES ({$voter_id},'{$v_name}','{$v_email}','{$flag}')";
         $data1 = mysqli_query($conn , $query1);
         if (!$data1) { 

          die("Failed".mysqli_error($conn));
        
        }
        $query2 = "SELECT * FROM `candidates` WHERE can_id = $candidate_id";
        $data2 = mysqli_query($conn , $query2);
        if (!$data2) { 

          die("Failed".mysqli_error($conn));
        
        }
        while($row = mysqli_fetch_assoc($data2)){
          $votes = $row['vote_count'];
        }

        $c = $votes+1;

         $query3  = "UPDATE `candidates` SET `vote_count`= $c WHERE can_id = $candidate_id";
         $data3 = mysqli_query($conn , $query3);
         if (!$data3) { 

          die("Failed".mysqli_error($conn));
        
        }
    }


  }
 
}


?>
<?php if(isset($_SESSION['loggedin'])){   ?>
<h1 style="margin-top:100px;">Candidates List</h1>
<div class="main-w3layouts wrapper mt-5">
<div class="container-fluid">
<div class="row">
<?php 


$query = "SELECT * FROM `candidates`";
   $data = mysqli_query($conn , $query);
   
   if (!$data) {  
    die("Failed".mysqli_error($conn));
        }

        while($row = mysqli_fetch_assoc($data)){
            $can_id = $row['can_id'];
            $name = $row['name'];
            $party_name = $row['party_name'];
            $contact = $row['contact'];
            $image = $row['image'];

            ?>
<div class="card mt-5" style="width: 18rem; border-radius:20px;border: 3px solid green;">
  <img src="can_img/<?php echo $image ?>" class="card-img-top" alt="<?php echo $name ?>"  height="250" width="250" style="border-radius: 50%;padding:40px;">
  <div class="card-body">
    <h4 class="card-title"><?php echo $name ?></h4>
    <h5 class="card-title"><?php echo $party_name ?></h5>
    <h5 class="card-title"><?php echo $contact ?></h5>
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
<button type="button"  data-toggle="modal" data-target="#myModal_<?php echo $can_id;?>">
    Give Vote
  </button>
<?php 
        }  
  
}
  ?>
  

  <!-- The Modal -->
  <div class="modal" id="myModal_<?php echo $can_id;?>">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header" >
          <h4 class="modal-title"><b> Vote For Better Future :)</b></h4>
          <a type="button" class="close" data-dismiss="modal">&times;</a>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <div>
        <form action="candidate.php" method="POST">
          <input type="hidden" name="can_id" value="<?php echo $can_id;?>">
  <div class="form-group">
    <label for="candidatename" style="float:left;">Candidate Name</label>
    <input type="text" class="form-control"  name="can_name" value="<?php echo $name ?>" readonly>
  </div>
  <div class="form-group">
    <label for="partyname" style="float:left;">Party Name</label>
    <input type="text" class="form-control" name="can_party" value="<?php echo $party_name ?>" readonly>
    
  </div>
  <div class="form-group">
    <label for="contact" style="float:left;">Contact</label>
    <input type="number" class="form-control" name="can_contact" value="<?php echo $contact ?>" readonly>
  </div>
  <small id="emailHelp" class="form-text text-muted">You can't change candidate details once selected.</small>
  <hr>
  <div class="form-group">
    <label for="votername" style="float:left;"><b>Your name</b></label>
    <input type="text" class="form-control" name="voter_name"  value="<?php echo $voter_name; ?>" >
  </div>
  <div class="form-group">
    <label for="voteremail" style="float:left;"><b>Your Email</b></label>
    <input type="email" class="form-control"  name="voter_mail" value="<?php echo $voter_email; ?>" >
  </div>
  <div class="form-group">
    <label for="votercontact" style="float:left;"><b>Your Contact</b></label>
    <input type="number" class="form-control"  name="voter_contact" value="<?php echo $voter_contact; ?>" >
  </div>
  <div class="form-group">
    <label for="token" style="float:left;"><b>Your Voting Token</b></label>
    <input type="text" class="form-control" name="voter_token">
  </div>
  </div>
  <input type="submit" class="btn btn-primary" value="Vote" name="vote">
</form>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal" style="width:90px;">Close</button>
        </div>
        
      </div>
    </div>
  </div>
    
  </div>
  
</div>

<?php
            
}
?>


</div>

</div>
<br><br><br><br><br><br><br><br><br><br><br>


<?php include'bubble.php'; ?>
  </div>       

</body>
</html>
<?php }else {
  header("Location: login.php");
}
?>