<?php
require("Connection.php");
?>

<html>

<head>
    <title>ADMIN LOGIN PANEL</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="mycss.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</head>

<body>

    <div class="login-form">
        <h2>ADMIN LOGIN PANEL</h2>
        <form method="POST">
            <div class="input-field">
                <i class="bi bi-person-circle"></i>
                <input type="text" placeholder="Admin Name" name="AdminName">
            </div>
            <div class="input-field">
                <i class="bi bi-shield-lock"></i>
                <input type="password" placeholder="Password" name="AdminPassword">
            </div>

            <button type="submit" name="Signin">Sign In</button>

        </form>
    </div>

    <?php

    if (isset($_POST['Signin'])) {
        $adminName = $_POST['AdminName'];
        $adminPassword = $_POST['AdminPassword'];

        // Use prepared statements to avoid SQL injection
        $query = "SELECT * FROM admin_login WHERE Admin_Name = ? AND Admin_Password = ?";
        $stmt = mysqli_prepare($con, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $adminName, $adminPassword);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 1) {
                echo "<script> window.location.replace('http://localhost/mini-Project/Admin_Panel//admin.php');</script>";
            } else {
                echo "<script>alert('Invalid login credentials');</script>";
            }
            

            mysqli_stmt_close($stmt);
        } else {
            echo "Error in the SQL query.";
        }
    }
    ?>

</body>

</html>
