<?php session_start();

$_SESSION['admin_name'] = null;
session_destroy();

header("Location:admin_login.php");

?>