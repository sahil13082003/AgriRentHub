<?php
include '../components/Links.php';
include '../components/Navbar.php';
$db = mysqli_connect("localhost", "root", "", "farmer") or die("Connection Failed");

$query = "SELECT DISTINCT equipment.*, purchase_requests.status_owner
FROM equipment
LEFT JOIN purchase_requests ON equipment.owner_id = purchase_requests.owner_id
WHERE purchase_requests.status_owner IS NULL OR purchase_requests.status_owner = 'Accepted'";


$result = mysqli_query($db, $query);

if (!$result) {
    die('Error in SQL query: ' . mysqli_error($db));
}

$equipmentData = array(); 

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $equipmentData[] = $row;
    }
} else {
    echo 'No equipment data found.';
}

mysqli_close($db);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgriRentHub</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    .equipment-container {
        border: 1px solid #ddd;
        margin: 30px;
        padding: 10px;
        width: 300px;
        display: inline-block;
        box-shadow: 5px 5px 5px rgba(16, 111, 21, 0.3);
        border-radius: 5px;
        background-color: #fff;
    }

    .equipment-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .green-text {
    color: green;
    }

    .equipment-description {
        max-height: 100px;
        overflow: hidden;
    }

    .equipment-price {
        font-weight: bold;
    }

    .buy-now-button {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #007bff;
        color: #fff;
        padding: 5px;
        border-radius: 5px;
        text-decoration: none;
    }


    .container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        align-items: flex-start;
        background-color: rgb(216, 220, 217);
    }

    h1 {
        text-align: center;
        color: #186720;
        position: relative;
        margin-top: 50px;
    }

    </style>
</head>

<body>
    <h1>Equipment Dashboard</h1>
    <div class="container">
    <?php foreach ($equipmentData as $equipment) : ?>
    <div class="equipment-container">
        <img class="equipment-image" src="../images/<?php echo $equipment['image']; ?>" alt="Equipment Image">
        <h4><b>Equipment Type:</b> <b class="green-text"><?php echo $equipment['equipment_type']; ?></b></h4>
        <div class="equipment-description">
            <p><b>Description:</b> <?php echo $equipment['description']; ?></p>
        </div>
        <p><b>Rental Cost:</b></p>
        <ul>
            <li>Per Hour: $<?php echo $equipment['rental_cost_per_hour']; ?></li>
            <li>Per Day: $<?php echo $equipment['rental_cost_per_day']; ?></li>
        </ul>
        <p><b>Availability:</b></p>
        <ul>
            <p><b>Available From:</b> <?php echo $equipment['from_date']; ?></p>
            <p><b>Available To:</b> <?php echo $equipment['to_date']; ?></p>

        </ul>

        <?php
        if (isset($_SESSION['email']) && $_SESSION['email'] === $equipment['owner_id']) {
            echo '<div class="alert alert-info" role="alert">';
            echo 'You are viewing your own equipment.';
            echo '</div>';
        } else {
            $isAvailable = ($equipment['status_owner'] === null || $equipment['status_owner'] == 'Accepted');

            if ($isAvailable) {
                echo '<a class="btn btn-success" href="Book_Now.php?owner_id=' . $equipment['owner_id'] . '&equipment_id=' . $equipment['equipment_id'] . '">Book Now</a>';

            } else {
                echo '<div class="disabled-card">';
                echo '<button class="btn btn-success" disabled>Not Available</button>';
                echo '</div>';
            }
        }
        ?>
    </div>
<?php endforeach; ?>

    </div>
</body>


</html>