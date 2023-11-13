<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = $_POST["email"];
    $name = $_POST["name"];
    $address = $_POST["address"]; 
    $password = $_POST["password"];

    // Validate and sanitize input (you should improve validation)
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $address = filter_var($address, FILTER_SANITIZE_STRING); 
   
    // Database connection settings
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "farmer";

    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name) or die("Connection Failed");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert data into the database
    $sql = "INSERT INTO registration (email, name, address, password) VALUES (?, ?, ?, ?)"; 
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $email, $name, $address, $password); 

    if ($stmt->execute()) {
        // Data inserted successfully
        echo "<SCRIPT> alert('Registration successful!')  </SCRIPT> ";
        echo "<script>window.location.href = 'http://localhost/mini-Project/pages/HomePage.php';</script>";
    } else {
        // Error inserting data
        echo "Error: " . $stmt->error;
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>
