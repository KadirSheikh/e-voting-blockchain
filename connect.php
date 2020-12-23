<?php 


$conn = mysqli_connect('localhost' , 'root' , '' , 'blockchainvoting');

if ($conn) {
	//echo "connected";
}
else{
	die('Failed'.mysqli_error());
}

?>