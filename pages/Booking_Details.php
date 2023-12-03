<?php
include '../components/Links.php';
include '../components/Navbar.php';

function validateInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

$db = mysqli_connect("localhost", "root", "", "farmer");

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

$customer_id = $_SESSION['email'];

$query = "SELECT pr.*
          FROM purchase_requests pr
          JOIN equipment e ON pr.equipment_id = e.equipment_id
          WHERE pr.customer_id = '$customer_id'
          ORDER BY pr.requestID ASC";


$result = mysqli_query($db, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($db));
}

$bookingDetails = array();

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $bookingDetails[] = $row;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['Cconfirmation'])) {
        $requestID = $_POST['requestID'];
        $updateConfirmation = "UPDATE purchase_requests SET customer_confirmation = 'Yes', confirmation_time = CURRENT_TIMESTAMP WHERE requestID = '$requestID'";

        if (mysqli_query($db, $updateConfirmation)) {
            echo "<script> alert('Equipment Received.'); </script>";
            echo "<script> window.location.replace('http://localhost/mini-Project/pages/Booking_Details.php');</script>";
        } else {
            echo "Error updating Equipment Confirmation: " . mysqli_error($db);
        }
    }

    if (isset($_POST['equipmentStatus'])) {
        $requestID = $_POST['requestID'];
        $updatestatus = "UPDATE purchase_requests SET equipment_status = 'Yes', status_time = CURRENT_TIMESTAMP WHERE requestID = '$requestID'";

        if (mysqli_query($db, $updatestatus)) {
            echo "<script> alert('Request Status Updated Successfully.'); </script>";
            echo "<script> window.location.replace('http://localhost/mini-Project/pages/Booking_Details.php');</script>";
        } else {
            echo "Error updating Equipment Confirmation: " . mysqli_error($db);
        }
    }
}

mysqli_close($db);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <h1 style="text-align:center; color:green; padding:30px">Booking Details</h1>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Equipment Type</th>
                    <th>Owner ID</th>
                    <th>Customer ID</th>
                    <th>From_Date</th>
                    <th>Rental Time</th>
                    <th>Time</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th>Equipment Received</th>
                    <th>Download Receipt</th>
                    <th>Equipment Status</th>
                </tr>
            </thead>
            <tbody>
               <?php
foreach ($bookingDetails as $detail) {
    echo "<tr>";
    echo '<td>';
    echo "<img src='../images/{$detail['image']}' alt='Equipment Image' style='width: 90px; height: 60px; border-radius:10px'>";
    echo '</td>';
    echo "<td>{$detail['equipment_type']}</td>";
    echo "<td>{$detail['owner_id']}</td>";
    echo "<td>{$detail['customer_id']}</td>";
    echo "<td>{$detail['fromdate']}</td>";
    echo "<td>{$detail['rental_time']}</td>";
    echo "<td>{$detail['rental_duration']}</td>";
    echo "<td>{$detail['address']}</td>";

    echo '<td>';
    echo '<form method="POST" action="">';
    echo "<input type='hidden' name='requestID' value='{$detail['requestID']}'>";

    if ($detail['status_owner'] === 'Accepted') {
        echo '<button class="btn btn-success" disabled>Accepted</button>';
    } elseif ($detail['status_owner'] === 'Rejected') {
        echo '<button class="btn btn-danger" disabled>Rejected</button>';
    } else {
        echo '<button class="btn btn-warning" disabled>Pending</button>';
    }
    echo '</td>';

    echo '<td>';
    if ($detail['status_owner'] === 'Accepted') {
        if ($detail['receipt_available'] == 1) {
            echo '<button class="btn btn-success" disabled>Done</button>';
        } else {
            echo '<a class="btn btn-primary" href="../Payment/pay.php?id=' . $detail['owner_id'] . '">Payment</a>';
        }
    } elseif ($detail['status_owner'] !== 'Accepted') {
        echo '<button class="btn btn-primary" disabled>Payment</button>';
    }
    echo '</td>';

    echo '<td>';
    if ($detail['owner_confirmation'] == 'Yes') {
        if ($detail['customer_confirmation'] == 'Yes') {
            echo '<button class="btn btn-success" name="Cconfirmation" disabled>Yes</button><br>';
            echo '<span id="confirmationTime_' . $detail['requestID'] . '">Equipment Received At: ' . $detail['confirmation_time'] . '</span>';
        } else {
            echo '<button class="btn btn-success" name="Cconfirmation" onclick="updateConfirmationTime(' . $detail['requestID'] . ')">Yes</button>';
            echo '<span id="confirmationTime_' . $detail['requestID'] . '"></span>';
        }
    }
    echo '</td>';

    echo '<td>';
    if ($detail['receipt_available'] == 1) {
        echo '<a class="btn btn-info" href="Download_receipt.php?id=' . $detail['requestID'] . '">Download</a>';
    }
    echo '</td>';

    echo '<td>';
    if ($detail['customer_confirmation'] == 'Yes') {
        if ($detail['equipment_status'] == 'Yes') {
            echo '<button class="btn btn-success" name="equipmentStatus" disabled>Work Done</button><br>'; 
            echo '<span id="statusTime_' . $detail['requestID'] . '">Work Done On: ' . $detail['status_time'] . '</span>';
        } else {
            echo '<button class="btn btn-success" name="equipmentStatus" onclick="updateStatusTime(' . $detail['requestID'] . ')">Work Done</button>';
            echo '<span id="statusTime_' . $detail['requestID'] . '"></span>';
        }
    }
    echo '</td>';

    echo '</form>';
    echo "</tr>";
}
?>

            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
