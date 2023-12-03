 <?php
$db = mysqli_connect("localhost", "root", "", "farmer") or die("Connection Failed");

// Total no. of User Login into the website
$countQuery = "SELECT COUNT(*) as total_users FROM registration";
$countResult = mysqli_query($db, $countQuery);

if ($countResult) {
    $row = mysqli_fetch_assoc($countResult);
    $totalUsers = $row['total_users'];
} else {
    $totalUsers = 0;
}

$countQuery = "SELECT COUNT(*) as totalEquipments FROM equipment";
$countResult = mysqli_query($db, $countQuery);

if ($countResult) {
    $row = mysqli_fetch_assoc($countResult);
    $totalEquipments = $row['totalEquipments'];
} else {
    $totalEquipments = 0;
}

$countQuery = "SELECT COUNT(*) as total_bookings FROM purchase_requests";
$countResult = mysqli_query($db, $countQuery);

if ($countResult) {
    $row = mysqli_fetch_assoc($countResult);
    $totalBookings = $row['total_bookings'];
} else {
    $totalBookings = 0;
}

// Total no. of Amount
$amountQuery = "SELECT SUM(total_cost) as total_amount FROM online_payment";
$amountResult = mysqli_query($db, $amountQuery);

if ($amountResult) {
    $row = mysqli_fetch_assoc($amountResult);
    $totalAmount = $row['total_amount'];
} else {
    $totalAmount = 0;
}


mysqli_close($db);


?>

 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>AgroRentHub</title>
     <link rel="stylesheet" href="style.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
         integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
     </script>
     <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
         integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
     </script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
         integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
     </script>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
         integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
 </head>

 <body>

     <div class="d-flex" id="wrapper">
         <!-- Sidebar -->
         <div class="bg-white" id="sidebar-wrapper">
             <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold border-bottom">
                 <img src="../../Images/logo.png" alt="Your Logo"
                     style="width: 40px; height: 40px; border-radius: 50%; background: #SecondaryBgColor; padding: 3px;">
                 AgriRentHub
             </div>


             <div class="list-group list-group-flush my-3">
                 <a href="#" class="list-group-item list-group-item-action bg-transparent second-text active"><i
                         class="fas fa-tachometer-alt me-2 "></i>Dashboard</a>
                  <a href="#" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                         class="fas fa-project-diagram me-2"></i>Projects</a>
                 <!--<a href="#" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                         class="fas fa-chart-line me-2"></i>Analytics</a>
                 <a href="#" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                         class="fas fa-paperclip me-2"></i>Reports</a>
                 <a href="#" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                         class="fas fa-shopping-cart me-2"></i>Store Mng</a>
                 <a href="#" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                         class="fas fa-gift me-2"></i>Products</a>
                 <a href="#" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                         class="fas fa-comment-dots me-2"></i>Chat</a>
                 <a href="#" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                         class="fas fa-map-marker-alt me-2"></i>Outlet</a>-->
                 <a href="Logout_Admin.php" 
                     class="list-group-item list-group-item-action bg-transparent text-danger fw-bold"><i
                         class="fas fa-power-off me-5"></i>Logout</a>
             </div>
         </div>

         <div id="page-content-wrapper">
             <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                 <div class="d-flex align-items-center">
                     <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                     <h2 class="fs-2 m-2">   Admin Dashboard</h2>
                 </div>

                 <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                     data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                     aria-expanded="false" aria-label="Toggle navigation">
                     <span class="navbar-toggler-icon"></span>
                 </button>
             </nav>

             <div class="container-fluid px-4">
                 <div class="row g-3 my-2">
                     <div class="col-md-3">
                         <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                             <div>
                                 <h3><span id="totalUsers"><?php echo $totalUsers; ?></span></h3>
                                 <p class="fs-5">Total Users</p>
                             </div>
                             <i class="fas fa-user fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                         </div>

                     </div>

                     <div class="col-md-3">
                         <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                             <div>
                                 <h3><span id="totalBookings"><?php echo $totalBookings; ?></span></h3>
                                 <p class="fs-5">Total Bookings</p>
                             </div>
                             <i
                                 class="fas fa-hand-holding-usd fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                         </div>
                     </div>

                     <div class="col-md-3">
                         <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                             <div>
                                 <h3> <span id="totalBookings"><?php echo $totalEquipments; ?></span></h3>
                                 <p class="fs-5">Total Equipments</p>
                             </div>
                             <i class="fas fa-truck fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                         </div>
                     </div>

                     <div class="col-md-3">
                         <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                             <div>
                                 <h3><span id="totalBookings">&#x20B9;<?php echo $totalAmount; ?></span></h3>
                                 <p class="fs-5">Total Amount</p>
                             </div>
                             <i class="fas fa-chart-line fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                         </div>
                     </div>
                 </div>

                 <?php
$db = mysqli_connect("localhost", "root", "", "farmer") or die("Connection Failed");

    $sql = "SELECT owner_id, customer_id, name, address, total_cost FROM purchase_requests";
$result = mysqli_query($db, $sql);

if (mysqli_num_rows($result) > 0) {
    echo '<div class="row my-5">
        <h3 class="fs-4 mb-3">Recent Orders</h3>
        <div class="col">
            <div style="max-height: 400px; overflow-y: scroll;"> 
                <table class="table bg-white rounded shadow-sm table-hover">
                    <thead>
                        <tr>
                            <th scope="col" width="50">#</th>
                            <th scope="col">Owner ID</th>
                            <th scope="col">Customer ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Address</th>
                            <th scope="col">Total Cost</th>
                        </tr>
                    </thead>
                    <tbody>';

    $rowNumber = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $ownerID = $row['owner_id'];
        $ownerCount[$ownerID] = isset($ownerCount[$ownerID]) ? $ownerCount[$ownerID] + 1 : 1;

        if (isset($ownerProfit[$ownerID])) {
            $ownerProfit[$ownerID] += $row['total_cost'];
        } else {
            $ownerProfit[$ownerID] = $row['total_cost'];
        }

        echo "<tr>
            <th scope='row'>$rowNumber</th>
            <td>" . $row['owner_id'] . "</td>
            <td>" . $row['customer_id'] . "</td>
            <td>" . $row['name'] . "</td>
            <td>" . $row['address'] . "</td>
            <td>" . $row['total_cost'] . "</td>
        </tr>";
        $rowNumber++;
    }

    echo '</tbody>
                </table>
            </div>
        </div>
    </div>';
} else {
    echo "No records found in the database.";
}




$ownerSQL = "SELECT owner_id, COUNT(*) AS BookingCount, SUM(total_cost) AS TotalAmount
            FROM purchase_requests
            GROUP BY owner_id";

$customerSQL = "SELECT customer_id, COUNT(*) AS BookingCount, SUM(total_cost) AS TotalAmount
            FROM purchase_requests
            GROUP BY customer_id";

$ownerResult = mysqli_query($db, $ownerSQL);
$customerResult = mysqli_query($db, $customerSQL);

echo '<div class="row my-5">
    <div class="col">
        <h3 class="fs-4 mb-3">Owner Statistics</h3>
        <div style="max-height: 400px; overflow-y: scroll;"> <!-- Adjust the max-height as needed -->
            <table class="table bg-white rounded shadow-sm table-hover">
                <thead>
                    <tr>
                        <th scope="col">Owner ID</th>
                        <th scope="col">Booking Count</th>
                        <th scope="col">Total Amount</th>
                    </tr>
                </thead>
                <tbody>';

while ($row = mysqli_fetch_assoc($ownerResult)) {
    echo "<tr>
        <td>" . $row['owner_id'] . "</td>
        <td>" . $row['BookingCount'] . "</td>
        <td>" . $row['TotalAmount'] . "</td>
    </tr>";
}

echo '</tbody>
            </table>
        </div>
    </div>
</div>';

echo '<div class="row my-5">
    <div class="col">
        <h3 class="fs-4 mb-3">Customer Statistics</h3>
        <div style="max-height: 400px; overflow-y: scroll;"> 
            <table class="table bg-white rounded shadow-sm table-hover">
                <thead>
                    <tr>
                        <th scope="col">Customer ID</th>
                        <th scope="col">Booking Count</th>
                        <th scope="col">Total Amount</th>
                    </tr>
                </thead>
                <tbody>';

while ($row = mysqli_fetch_assoc($customerResult)) {
    echo "<tr>
        <td>" . $row['customer_id'] . "</td>
        <td>" . $row['BookingCount'] . "</td>
        <td>" . $row['TotalAmount'] . "</td>
    </tr>";
}

echo '</tbody>
            </table>
        </div>
    </div>
</div>';

?>


             </div>
         </div>
     </div>
     </div>

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
     <script>
     var el = document.getElementById("wrapper");
     var toggleButton = document.getElementById("menu-toggle");

     toggleButton.onclick = function() {
         el.classList.toggle("toggled");
     };
     </script>

 </body>

 </html>