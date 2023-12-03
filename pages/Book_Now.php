<?php
include '../components/Links.php';
include '../components/Navbar.php';

// var_dump($_GET);

$id = $_GET['owner_id'];

$equipment_id = isset($_GET['equipment_id']) ? $_GET['equipment_id'] : null;

if ($equipment_id === null) {
    
    echo "Error: Equipment ID is missing.";
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $fromDate = $_POST['fromDate'];
    $rentalTime = $_POST['rentalTime'];
    $rentalDuration = $_POST['rentalDuration'];
    $acceptTerms = isset($_POST['acceptTerms']) ? 1 : 0;
    $customer_id = $_SESSION['email'];


    $db = mysqli_connect("localhost", "root", "", "farmer");

    if (!$db) {
        die("Connection failed: " . mysqli_connect_error());
    }


    $fetchEquipmentDetailsQuery = "SELECT equipment_id, equipment_type, image, owner_id FROM equipment WHERE equipment_id='$equipment_id' and owner_id='$id'";

    $equipmentResult = mysqli_query($db, $fetchEquipmentDetailsQuery);
    
    if ($equipmentRow = mysqli_fetch_assoc($equipmentResult)) {
        $equipmentType = $equipmentRow['equipment_type'];
        $equipmentImage = $equipmentRow['image'];
        $equipmentid = $equipmentRow['equipment_id'];
    
        
        $fetchEquipmentCostQuery = "SELECT rental_cost_per_hour, rental_cost_per_day FROM equipment WHERE equipment_id='$equipmentid'";
        $result = mysqli_query($db, $fetchEquipmentCostQuery);
    
        if ($row = mysqli_fetch_assoc($result)) {
            $rentalCostPerHour = $row['rental_cost_per_hour'];
            $rentalCostPerDay = $row['rental_cost_per_day'];
                
            $totalPrice = 0;
            if ($rentalTime === 'perHour') {
                $totalPrice = $rentalDuration * $rentalCostPerHour;
            } elseif ($rentalTime === 'perDay') {
                $totalPrice = $rentalDuration * $rentalCostPerDay;
            }

            $fetchEquipmentDetailsQuery = "SELECT from_date, to_date FROM equipment WHERE equipment_id='$equipmentid'";
            $equipmentResult = mysqli_query($db, $fetchEquipmentDetailsQuery);

            if ($equipmentRow = mysqli_fetch_assoc($equipmentResult)) {
                $from_date = $equipmentRow['from_date'];
                $to_date = $equipmentRow['to_date'];
    
            if (!empty($from_date) && !empty($to_date)) {
        // Check availability based on the selected dates                                     // 30-11          28-10            3           9-11
       // $checkBookingAvailabilityQuery = "SELECT * FROM equipment WHERE owner_id='$id' AND ('$fromDate' >= $from_date AND '$fromDate' + '$rentalDuration' <= $to_date)";   + INTERVAL $rentalDuration DAY
                                                                                                            // 4-11                            12-11                                    4-11                                            22-11
        $checkBookingAvailabilityQuery = "SELECT * FROM equipment WHERE owner_id='$id' AND !((STR_TO_DATE('$fromDate', '%Y-%m-%d') >= STR_TO_DATE('$from_date', '%Y-%m-%d')) AND (STR_TO_DATE('$fromDate', '%Y-%m-%d')  <= STR_TO_DATE('$to_date', '%Y-%m-%d')))";

        $existingBookings = mysqli_query($db, $checkBookingAvailabilityQuery);

        if (mysqli_num_rows($existingBookings) > 0) {
            echo "<script>alert('Equipment is not available for the selected dates. Please choose different dates.');</script>";
        } else {

            $sql = "INSERT INTO purchase_requests (owner_id, customer_id, name, address, email, message, fromDate, rental_time, rental_duration, image, equipment_type, total_cost, terms_accepted, equipment_id)
        VALUES ('$id', '$customer_id', '$name', '$address', '$email', '$message', '$fromDate', '$rentalTime', '$rentalDuration', '$equipmentImage', '$equipmentType', '$totalPrice', '$acceptTerms', '$equipmentid')";

            if (mysqli_query($db, $sql)) {
                echo '<script> alert(" Total Price : '.$totalPrice.' ");</script>';
                
                echo "<script>alert('Your purchase request has been submitted successfully.');</script>";

                echo "<script> window.location.replace('http://localhost/mini-Project/pages/Booking_Details.php?equipment_id={$equipmentid}');</script>";
                
                exit();

            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($db);
            }
        }
    } else {
        echo "Equipment not found or rental cost details are missing.";
    }

    mysqli_close($db);
}
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
        margin: 0;
        padding: 0;
    }

    .container {
        background: #a0e3af81;
        padding: 40px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(13, 15, 1, 0.503);
        max-width: 550px;
        width: 90%;
        margin: 50px auto;
    }

    .container h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .form-group {
        margin: 20px 0;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 8px;
    }

    .form-group textarea {
        resize: vertical;
    }

    .form-group input[type="submit"] {
        background: #0056b3;
        color: #fff;
        cursor: pointer;
    }

    .form-group input[type="submit"]:hover {
        background: #249748;
    }

    p.round3 {
        border: 2px solid green;
        border-radius: 12px;
        padding: 10px;
        font-size: 15px;
    }

    @media screen and (max-width: 768px) {
        .container {
            padding: 20px;
        }
    }
    </style>
</head>

<body>
    <div class="container">
        <h2>Rent Now</h2>
        <form id="contactForm" method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="4"></textarea>
            </div>


            <div class="form-group">
                <label for="fromDate">Rent From:</label>
                <input type="date" class="form-control" name="fromDate" id="fromDate" required>
            </div>


            <div class="form-group">
                <label for="rentalTime">Rental Type:</label>
                <div class="rental-time-inputs">
                    <select id="rentalTime" name="rentalTime" required>
                        <option value="perHour">Hour</option>
                        <option value="perDay">Day</option>
                    </select>
                    <input type="number" id="rentalDuration" name="rentalDuration" required min="1" max="24">
                </div>
            </div>

            <div class="form-group">
                <label for="totalPrice"></label>
                <div id="totalPrice"></div>
            </div>

            <input type="checkbox" id="acceptTerms" required>
            <label for="acceptTerms"><b>I accept the Terms and Conditions</b></label><br>
            <p class="round3"> 1) Equipments that are overdue after the rental period are subjected to extra fines.<br>
                2) The fine will be added to their due amount.</p>
            <input type="hidden" name="owner_id" value="<?php echo $ownerID; ?>">
            <input type="hidden" name="customer_id" value="<?php echo $email; ?>">

            <input type="hidden" name="equipment_id" value="<?php echo htmlspecialchars($equipment_id, ENT_QUOTES, 'UTF-8'); ?>">


            <div class="form-group">
                <input type="submit" value="Submit">
            </div>
        </form>
    </div>

</body>

</html>