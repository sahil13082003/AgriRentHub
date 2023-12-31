<?php
include '../components/Links.php';
include '../components/Navbar.php';


$db = mysqli_connect("localhost", "root", "", "farmer");

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

$user = $_SESSION['email'];

$query = "SELECT p.*, e.equipment_type, e.owner_id AS equipment_owner, e.image AS equipment_image,
                 p.confirmation_time as confirmation_timestamp,
                 p.status_time as status_timestamp
         FROM purchase_requests AS p
         JOIN equipment AS e ON p.owner_id = e.owner_id 
         WHERE p.owner_id = '$user' AND p.equipment_id = e.equipment_id";


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
    if (isset($_POST['accept'])) {
        $requestID = $_POST['requestID']; 
        $acceptQuery = "UPDATE purchase_requests SET status_owner = 'Accepted' WHERE requestID = '$requestID'";
        if (mysqli_query($db, $acceptQuery)) {
            
            $updateCustomerStatusQuery = "UPDATE purchase_requests SET status_customer = 'Accepted' WHERE requestID = '$requestID'";
            if (mysqli_query($db, $updateCustomerStatusQuery)) {
                echo "<script> alert('Request Accetted Successfully'); </script>";
                echo "<script> window.location.replace('http://localhost/mini-Project/pages/Booking_Request.php');</script>";
            } else {
                
                echo "Error updating customer status: " . mysqli_error($db);
            }
        } else {
            echo "Error accepting the request: " . mysqli_error($db);
        }
    } elseif (isset($_POST['reject'])) {
        $requestID = $_POST['requestID']; 
        $rejectQuery = "UPDATE purchase_requests SET status_owner = 'Rejected' WHERE requestID = '$requestID'";
        if (mysqli_query($db, $rejectQuery)) {
            
            $updateCustomerStatusQuery = "UPDATE purchase_requests SET status_customer = 'Rejected' WHERE requestID = '$requestID'";
            if (mysqli_query($db, $updateCustomerStatusQuery)) {
                echo "<script> alert('Request Rejecyed Successfully'); </script>";
                echo "<script> window.location.replace('http://localhost/mini-Project/pages/Booking_Request.php');</script>";
            } else {
               
                echo "Error updating customer status: " . mysqli_error($db);
            }
        } else {
            
            echo "Error rejecting the request: " . mysqli_error($db);
        }
    }
    if (isset($_POST['confirmation'])) {
        $requestID = $_POST['requestID'];
        $updateConfirmationQuery = "UPDATE purchase_requests SET owner_confirmation = 'Yes' WHERE requestID = '$requestID'";
        if (mysqli_query($db, $updateConfirmationQuery)) {
            echo "<script> alert('Equipment Confirmation Done.'); </script>";
            echo "<script> window.location.replace('http://localhost/mini-Project/pages/Booking_Request.php');</script>";
        } else {
            echo "Error updating Equipment Confirmation: " . mysqli_error($db);
        }
    }

    if (isset($_POST['damageYes'])) {
        $requestID = $_POST['requestID'];
    
        $updateDamageQuery = "UPDATE purchase_requests SET equipment_damage = 'Yes' WHERE requestID = '$requestID'";
    
        if (mysqli_query($db, $updateDamageQuery)) {
            echo "<script> alert('Equipment damage set to Yes.'); </script>";
            echo "<script> window.location.replace('http://localhost/mini-Project/pages/Booking_Request.php');</script>";
        } else {
            echo "Error updating equipment damage: " . mysqli_error($db);
        }
    }
    
}


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
    <h1 style="text-align:center; color:green; padding:30px">Booking Request</h1>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Images</th>
                    <th>Equipment Name</th>
                    <th>Owner ID</th>
                    <th>Customer ID</th>
                    <th>From Date</th>
                    <th>Rental Time</th>
                    <th>Time</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Equipment Dispatch</th>
                    <th>Download Receipt</th>
                    <th>Equipment Status</th>
                    <th>Equipment Damage By Customer</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($bookingDetails as $detail) {
                    echo "<tr>";

                    echo '<td>';
                    echo '<img src="../images/' . $detail['equipment_image'] . '" alt="Equipment Image" style="width: 90px; height: 60px; border-radius:10px;">';
                    echo '</td>';

                    echo "<td>{$detail['equipment_type']}</td>";

                    echo "<td>{$detail['equipment_owner']}</td>";
                    echo "<td>{$detail['customer_id']}</td>";
                    echo "<td>{$detail['fromdate']}</td>";
                    echo "<td>{$detail['rental_time']}</td>";
                    echo "<td>{$detail['rental_duration']}</td>";
                    echo "<td>{$detail['address']}</td>";

                    echo '<td>';
                    echo '<form method="POST" action="">';

                    echo "<input type='hidden' name='requestID' value='{$detail['requestID']}'>";

                    if ($detail['status_owner'] === 'Accepted') {
                        echo '<button class="btn btn-success" name="accept" disabled>Accepted</button>';
                    } elseif ($detail['status_owner'] === 'Rejected') {
                        echo '<button class="btn btn-danger" name="reject" disabled>Rejected</button>';
                    } else {
                        echo '<button class="btn btn-success" name="accept">Accept</button>';
                        echo '<button class="btn btn-danger ml-3" name="reject">Reject</button>';
                    }
                    echo '</td>';


                    echo '<td>';
                    if ($detail['receipt_available'] == 1) {
                        if($detail['customer_confirmation'] == 'Yes'){
                            
                                echo '<button class="btn btn-success" name="confirmation" disabled>Yes</button><br>';
                                echo '<span id="confirmationTime_' . $detail['requestID'] . '">Equipment Received At: ' . $detail['confirmation_time'] . '</span>';
                            } 
                        else{
                            echo '<button class="btn btn-success" name="confirmation">Yes</button>';
                       
                    }
                }
                    echo '</td>';


                    echo '<td>';
                    if ($detail['receipt_available'] == 1) {
                        echo '<a class="btn btn-info" href="download_receipt.php?id=' . $detail['requestID'] . '">Download</a>';
                    }
                    echo '</td>';


                    echo '<td>';
                    if ($detail['equipment_status'] == 'Yes') {
                        echo '<button class="btn btn-success" disabled>Work Done</button><br>';
                        echo '<span id="statusTime_' . $detail['requestID'] . '">Work Done On: ' . $detail['status_timestamp'] . '</span><br>';
                        echo 'Collect your Equipment';
                    }
                    echo '</td>';

                    

                    echo '<td>';
                    if ($detail['equipment_damage'] === 'Yes') {
                        echo '<button class="btn btn-success" name="damageYes" disabled>Yes</button>';
                    }
if ($detail['status_owner'] === 'Accepted' && $detail['equipment_status'] === 'Yes' && $detail['customer_confirmation'] === 'Yes' && $detail['equipment_damage'] === 'Yes') {
    echo '<div>Equipment damage by this customer last time</div>';
} else {
    echo '<form method="POST" action="">';

echo "<input type='hidden' name='requestID' value='{$detail['requestID']}'>";
    if ($detail['equipment_damage'] === 'Yes') {
        echo '<button class="btn btn-success" name="damageYes" disabled>Yes</button>';
    } elseif($detail['equipment_status'] === 'Yes') {
        echo '<button class="btn btn-success" name="damageYes">Yes</button>';
        echo '<button class="btn btn-danger ml-3" name="damageNo" onclick="removeNoButton()">No</button>';
    }

    
    $pastDamageQuery = "SELECT COUNT(*) as damage_count FROM purchase_requests WHERE owner_id = '{$detail['owner_id']}' AND customer_id = '{$detail['customer_id']}' AND equipment_damage = 'Yes' AND requestID != '{$detail['requestID']}'";
    $pastDamageResult = mysqli_query($db, $pastDamageQuery);

    if ($pastDamageResult && mysqli_num_rows($pastDamageResult) > 0) {
        $pastDamageRow = mysqli_fetch_assoc($pastDamageResult);

        if ($pastDamageRow['damage_count'] > 0) {
            echo '<div>Equipment damage by this customer last time</div>';
        }
    }

    echo '</form>';
}
echo '</td>';



                    echo "</form>";
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