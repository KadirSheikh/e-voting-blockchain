<?php 
  session_start();
  ob_start(); 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/x-icon" href="fav.png">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="mdbcss/mdb.min.css">
  

    <title>Vote Count</title>

</head>
<body style="background-color: #76b852;">
<?php if(isset($_SESSION['admin_loggedin'])){   ?>
<div id="wrapper">
<?php include'connect.php'; 
error_reporting(0);
?>
<?php include'sidebar.php'; ?>

<div class="main-w3layouts wrapper mt-5">
<div class="container">
<div class="row">
<?php 
$query = "SELECT * FROM `candidates`";
   $data = mysqli_query($conn , $query);
   
   if (!$data) {  
    die("Failed".mysqli_error($conn));
        }

        while($row = mysqli_fetch_assoc($data)){
            $name = $row['name'];
            $party_name = $row['party_name'];
            $count = $row['vote_count'];
            $image = $row['image'];

            ?>
<div class="card mt-2 mr-3" style="width: 18rem; border-radius:20px;border: 3px solid green;">
  <img src="can_img/<?php echo $image ?>" class="card-img-top" alt="<?php echo $name ?>"  height="250" width="250" style="border-radius: 50%;padding:50px;">
  <div class="card-body"  style="text-align:center;">
    <h4 class="card-title"><?php echo $name ?></h4>
    <h5 class="card-title"><?php echo $party_name ?></h5>
    <h5 class="card-title"><b>Votes : <?php echo $count ?></b></h5>

    </div>
    </div>
        <?php }
        ?>
</div>
</div>
</div>
<div class="card" style="width: 50rem; border-radius:20px;margin: auto;border: 3px solid green; margin-top:40px;">
  <div class="card-body" style="text-align:center;">
<?php 

$result = mysqli_query($conn, "SELECT  MAX(`vote_count`) as max FROM `candidates`");

      while($res = mysqli_fetch_array($result)) { 
        $max = $res['max']; 
 }

 $query = mysqli_query($conn, "SELECT * FROM `candidates` WHERE `vote_count` = $max");
 while($res = mysqli_fetch_array($query)) { 
    $c_name = $res['name']; 
    $par_name = $res['party_name'];

}

?>

<h4 class="card-title" ><b><?php echo $c_name ?></b> Of <b><?php echo $par_name ?></b> party get highest votes of <b><?php echo $max ?></b></h4>


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
      