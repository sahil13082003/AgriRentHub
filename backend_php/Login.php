<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $EMAIL = $_POST['email'];
        $PASSWORD = $_POST['password'];
        $db = mysqli_connect("localhost","root","","farmer") or die("connectiion Failed");
        $sql = "SELECT * FROM registration WHERE email = '{$EMAIL}' and password = '{$PASSWORD}'";
         $res = mysqli_query($db,$sql) or die("result failed");
       
      if(mysqli_num_rows($res) >0)
      {   
        $row=mysqli_fetch_assoc($res);
        session_start();
		    $_SESSION['email']=$row['email'];
		    $_SESSION['uname']=$row['name'];
        echo "<SCRIPT> alert('login Successful')  </SCRIPT> ";
        echo "<script> window.location.replace('http://localhost/mini-Project/pages/HomePage.php');</script>";

      }else{
        echo "<SCRIPT> alert('lnvalid Login try another credential')  </SCRIPT> ";
        echo $error;echo "<script> window.location.replace('http://localhost/mini-Project/pages/HomePage.php');</script>";
      }
    }
?>
