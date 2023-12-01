<?php
// Assuming verify.php is in the PAYMENT folder
require('../NOTIFICATION/smtp/PHPMailerAutoload.php');

require('config.php');
session_start();
require_once 'common.php';
require('Razorpay.php');
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

$success = true;
$error = "Payment Failed";

if (empty($_POST['razorpay_payment_id']) === false) {
    $api = new Api($keyId, $keySecret);

    try {
        $attributes = array(
            'razorpay_order_id' => $_SESSION['razorpay_order_id'],
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature' => $_POST['razorpay_signature']
        );

        $api->utility->verifyPaymentSignature($attributes);
    } catch (SignatureVerificationError $e) {
        $success = false;
        $error = 'Razorpay Error : ' . $e->getMessage();
    }
}

if ($success === true) {
    $razorpayOrderId = $_SESSION['razorpay_order_id'];
    $razorpayPaymentId = $_POST['razorpay_payment_id'];
    $ownerEmail = $_SESSION['service_email'];
    $email = $_SESSION['service_email'];
    $from = $_SESSION['email'];
    $serviceCharge = $_SESSION['service_charge'];
    $requestID = $_SESSION['requestID'];

    // echo $requestID;

    $db = mysqli_connect("localhost", "root", "", "farmer") or die('connection failed');

    $updateReceiptQuery = "UPDATE purchase_requests SET receipt_available = 1 WHERE email= '$from'";
    mysqli_query($db, $updateReceiptQuery);

    $sql = "INSERT INTO online_payment (razorpayOrderId,razorpayPaymentId,customer_id, owner_id,total_cost,requestID) VALUES ('$razorpayOrderId','$razorpayPaymentId', '$from','$ownerEmail', '$serviceCharge','$requestID')";
    $Result = mysqli_query($db, $sql) or die("unSUCCESS IN verify.php");

    // Send email notification
    $emailSubject = 'Payment Successfully Done';
    $emailMessage = 'Your payment has been done successfully. Kindly check your login.';
    $customerEmail = $_SESSION['email'];
    $ownerEmail = $_SESSION['service_email'];

    $recipients = [$customerEmail, $ownerEmail];
    echo smtp_mailer($recipients, $emailSubject, $emailMessage);
} else {
    $paymentStatus = 'FAILURE';
    $updatestamp = date('Y-m-d h:i:s');
    $applicatF->updatePayStatus($email, $razorpayOrderId, $razorpayPaymentId, $paymentStatus, $updatestamp);
}

// Function definition for smtp_mailer
function smtp_mailer($recipients, $subject, $msg) {
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587;
    $mail->IsHTML(true);
    $mail->CharSet = 'UTF-8';
    //$mail->SMTPDebug = 2; 
    $mail->Username = "agrirenthub@gmail.com";
    $mail->Password = "yrmc grym ueod jelw";
    $mail->SetFrom("email");
    $mail->Subject = $subject;
    $mail->Body = $msg;

    foreach ($recipients as $recipient) {
        $mail->addAddress($recipient);
    }

    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => false
        )
    );

    if (!$mail->Send()) {
        echo $mail->ErrorInfo;
    } else {
        echo '<script> alert("Payment successful,check your mail");</script>';
        echo "<script> window.location.replace('http://localhost/mini-Project/pages/Booking_Details.php');</script>";

    }

}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Razorpay | Payment Gateway Integration </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/noui/nouislider.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!--===============================================================================================-->
</head>

<body>
    <div class="container-contact100 row">
        <div class="wrap-contact100 col-12 justify-content-center ">
            <?php
	if(isset($errMSG)){
			?>
            <?php header("location:success.php?response=0"); ?>
            <?php
	}
	else if(isset($successMSG)) header("location:success.php?response=1");
		?>


            <form method="post" action="Download_receipt.php">
                <input type="text" name="razorpayPaymentId" value="your_payment_id">

                <input type="submit" value="Submit">
            </form>



            <!-- <table>
  <tr>
    <td class="txt-agl-rt">Customer Email</td>
    <td class="txt-agl-lt"><?php echo $from; ?></td>
  </tr> 
             <tr>
    <td class="txt-agl-rt">Owner Email</td>
    <td class="txt-agl-lt"><?php echo $email; ?></td>
  </tr> 
             <tr>
    <td class="txt-agl-rt">Order ID</td>
    <td class="txt-agl-lt"><?php echo $razorpayOrderId; ?></td>
  </tr>
	<tr>
    <td class="txt-agl-rt">Payment ID</td>
    <td class="txt-agl-lt"><?php echo $razorpayPaymentId; ?></td>
  </tr> 
             <tr>
    <td class="txt-agl-rt">Mobile Number</td>
    <td class="txt-agl-lt"><?php echo $phone; ?></td>
  </tr>  -->
   <!-- <tr>
    <td class="txt-agl-rt">Selected Service</td>
    <td class="txt-agl-lt"><?php echo $service; ?></td>
  </tr> -->
  <!-- <tr>
    <td class="txt-agl-rt">Equipment Type</td>
    <td class="txt-agl-lt"><?php echo $type; ?></td>
  </tr>  -->
            <!-- <tr>
              <td class="txt-agl-rt">Amount</td>
    <td class="txt-agl-lt"><?php echo $serviceCharge; ?></td>
  </tr>
  
</table>

                 </div>
  <button class='btn btn-success ' Download>
		Download
	</button>
</div>  --> 

                <!--===============================================================================================-->
                <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
                <!--===============================================================================================-->
                <script src="vendor/animsition/js/animsition.min.js"></script>
                <!--===============================================================================================-->
                <script src="vendor/bootstrap/js/popper.js"></script>
                <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
                <!--===============================================================================================-->
                <script src="vendor/select2/select2.min.js"></script>
                <script>
                $(".js-select2").each(function() {
                    $(this).select2({
                        minimumResultsForSearch: 20,
                        dropdownParent: $(this).next('.dropDownSelect2')
                    });


                    $(".js-select2").each(function() {
                        $(this).on('select2:close', function(e) {
                            if ($(this).val() == "Please chooses") {
                                $('.js-show-service').slideUp();
                            } else {
                                $('.js-show-service').slideUp();
                                $('.js-show-service').slideDown();
                            }
                        });
                    });
                })
                </script>
                <!--===============================================================================================-->
                <script src="vendor/daterangepicker/moment.min.js"></script>
                <script src="vendor/daterangepicker/daterangepicker.js"></script>
                <!--===============================================================================================-->
                <script src="vendor/countdowntime/countdowntime.js"></script>
                <!--===============================================================================================-->
                <script src="vendor/noui/nouislider.min.js"></script>
                <script>
                var filterBar = document.getElementById('filter-bar');

                noUiSlider.create(filterBar, {
                    start: [10, 2000],
                    connect: true,
                    range: {
                        'min': 10,
                        'max': 2000
                    }
                });

                var skipValues = [
                    document.getElementById('value-lower'),
                    document.getElementById('value-upper')
                ];

                filterBar.noUiSlider.on('update', function(values, handle) {
                    skipValues[handle].innerHTML = Math.round(values[handle]);
                    $('.contact100-form-range-value input[name="fromValue"]').val($('#value-lower').html());
                    $('.contact100-form-range-value input[name="toValue"]').val($('#value-upper').html());
                });
                </script>
                <!--===============================================================================================-->
                <script src="js/main.js"></script>

</body>

</html>