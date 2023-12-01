<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $name = $_POST["name"];
    $address = $_POST["address"]; 
    $password = $_POST["password"];

    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $address = filter_var($address, FILTER_SANITIZE_STRING); 
  
    $conn = mysqli_connect("localhost", "root","", "farmer") or die("Connection Failed");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO registration (email, name, address, password) VALUES (?, ?, ?, ?)"; 
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $email, $name, $address, $password); 

    if ($stmt->execute()) {
        echo "<SCRIPT> alert('Registration successful!')  </SCRIPT> ";
        echo "<script>window.location.href = 'http://localhost/mini-Project/pages/HomePage.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
