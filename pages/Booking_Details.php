<?php
include '../components/Links.php';
include '../components/Navbar.php';

$db = mysqli_connect("localhost", "root", "", "farmer");

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

$customer_id = $_SESSION['email'];

$query = "SELECT *
          FROM purchase_requests
          WHERE customer_id = '$customer_id'";

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
                <th>Rental Time</th>
                <th>Time</th>
                <th>Status</th>
                <th>Payment</th>
                <th>Equipment Confirmation</th>
                <th>Download Receipt</th>
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
                echo "<td>{$detail['rental_time']}</td>";
                echo "<td>{$detail['rental_duration']}</td>";
                
                echo '<td>';
                if ($detail['status_owner'] === 'Accepted') {
                    echo '<button class="btn btn-success">Accepted</button>';
                } elseif ($detail['status_owner'] === 'Rejected') {
                    echo '<button class="btn btn-danger">Rejected</button>';
                } else {
                    echo '<button class="btn btn-warning">Pending</button>';
                }
                echo '</td>';

                echo '<td>';
        if ($detail['status_owner'] === 'Accepted') {
            if ($detail['receipt_available'] == 1) {
                echo '<button class="btn btn-success">Done</button>';
            } else {
                echo '<a class="btn btn-primary" href="../Payment/pay.php? id=' . $detail['owner_id']  . '">Payment</a>';

            }
        } elseif ($detail['status_owner'] !== 'Accepted') {
            echo '<button class="btn btn-primary" disabled>Payment</button>';
        }
        echo '</td>';

                echo '<td>';
                if ($detail['equipment_confirmation'] === 'Yes') {
                    echo '<button class="btn btn-success">Yes</button>';
                }
                echo '</td>';

                echo '<td>';
                if ($detail['receipt_available'] == 1) {
                    echo '<a class="btn btn-info" href="Download_receipt.php?id=' . $detail['requestID']  . '">Download</a>';
                }
                echo '</td>';

                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>