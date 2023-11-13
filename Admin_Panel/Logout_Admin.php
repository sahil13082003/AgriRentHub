<?php 
  session_start();

// Clear all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

echo "<SCRIPT> alert('You Are Logout Successfully !!')  </SCRIPT> ";

// Redirect to the login page or any other page
echo "<script> window.location.replace('http://localhost/mini-Project/Admin_Panel//Admin%20Login.php');</script>";

exit();
?>