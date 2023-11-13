<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $equipmentType = $_POST['equipmentType'];
    $description = $_POST['description'];
    $rentalCostPerHour = $_POST['rentalCostPerHour'];
    $rentalCostPerDay = $_POST['rentalCostPerDay'];
    $fromDate = $_POST['fromDate'];
    $toDate = $_POST['toDate'];

    $uploadDirectory = '../Images/'; 

    if (isset($_FILES['image'])) {
        $image = $_FILES['image'];
        $image_name = $image['name'];
        $image_tmp = $image['tmp_name'];
        $image_path = $uploadDirectory . $image_name;

        if (move_uploaded_file($image_tmp, $image_path)) {
            // echo "<script> alert('File uploaded successfully'); </script>";

        } else {
            echo "<script>alert('Somrthing Wrong')</script>";
            echo "<script> window.location.replace('http://localhost/mini-Project/pages/Dashboard.php');</script>";
        exit;
        }
    }

    $ownerID = $_SESSION['email'];
    $db = mysqli_connect("localhost", "root", "", "farmer");

    $insertQuery = "INSERT INTO equipment (equipment_type, owner_id, description, rental_cost_per_hour, rental_cost_per_day, from_date, to_date, image) VALUES ('$equipmentType', '$ownerID', '$description', $rentalCostPerHour, $rentalCostPerDay, '$fromDate', '$toDate', '$image_name')";


    if (mysqli_query($db, $insertQuery)) {
        echo "<script> window.location.replace('http://localhost/mini-Project/pages/Dashboard.php');</script>";
        exit;
    } else {
        echo "Error: " . mysqli_error($db);
    }

    mysqli_close($db);
}



?>