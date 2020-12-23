<?php 
  session_start();
  ob_start(); 

?>
     <!DOCTYPE html>
     <html lang="en">
     <head>
         <meta charset="UTF-8">
         <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <link rel="icon" type="image/x-icon" href="fav.png">
         <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

         <link rel="stylesheet" type="text/css" href="css/sidebar.css">
     </head>
     <body>
         <?php 
         $activePage = basename($_SERVER['PHP_SELF'], ".php");
         ?>
         <?php if(isset($_SESSION['admin_loggedin'])){   ?>
     <div id="sidebar-wrapper" style="background-color: rgba(255, 255, 255, 0.2);">
            <ul class="sidebar-nav">
                <li class="sidebar-brand" style="font-size:30px;">
                    
                        <b>Admin Panel</b>
                   
                </li>
                <li class="<?= ($activePage == 'voter_verify') ? 'active':''; ?>">
                    <a href="voter_verify.php">Verify Voters</a>
                </li>
                <li  class="<?= ($activePage == 'allcandidates') ? 'active':''; ?>">
                    <a href="allcandidates.php">Candidates</a>
                </li>
                <li class="<?= ($activePage == 'addcandidate') ? 'active':''; ?>">
                    <a href="addcandidate.php">Add New Candidate</a>
                </li>
                <li class="<?= ($activePage == 'voting_status') ? 'active':''; ?>">
                    <a href="voting_status.php">Voting Status</a>
                </li>
                <li class="<?= ($activePage == 'vote_count') ? 'active':''; ?>">
                    <a href="vote_count.php">Vote Count</a>
                </li>
                <li>
                    <a href="<?php echo $activePage ?>.php?act=alogout">Logout</a>
                    <?php
         
         $act = $_GET['act'];

                 if($act=='alogout'){
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
               window.location.href="admin_logout.php";
             } else {
               swal("Logout has been canceled!");
             }
           });
           </script>';
         }
         ?> 
                </li>
                <?php
                session_start();

                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                    ?>
                 <li style="margin-top:280px;">
                    Logged in as:<br><h4><?php echo $_SESSION['admin_name']; ?><h4>
                </li>
                    <?php
                } 
                ?>
                
            </ul>
       
        </div>
        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle"><i class="fa fa-bars" aria-hidden="true"></i></a>
     </body>
     </html>
     <script>
         $("#menu-toggle").click(function(e) {
  e.preventDefault();
  $("#wrapper").toggleClass("toggled");
});
     </script>
     <?php }else {
  header("Location: admin_login.php");
}
?>
      