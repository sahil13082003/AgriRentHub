<?php 
  session_start();
$_SESSION = [];
session_destroy();

echo "<SCRIPT> alert('You Are Logout Successfully !!')  </SCRIPT> ";

echo "<script> window.location.replace('http://localhost/mini-Project/pages/HomePage.php');</script>";

exit();
?>