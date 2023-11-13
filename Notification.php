<?php
require 'vendor/autoload.php'; 

// Replace these variables with dynamic values from your application
$senderEmail = "sahilgolhar7@gmail.com";
$senderName = "Sahil";
$recipientEmail = "justforfun7385@gmail.com";
$recipientName = "Mahesh";
$paymentConfirmationMessage = "Payment for your order has been confirmed.";

$email = new \SendGrid\Mail\Mail();
$email->setFrom($senderEmail, $senderName);
$email->setSubject("Payment Confirmation");
$email->addTo($recipientEmail, $recipientName);
$email->addContent("text/plain", $paymentConfirmationMessage);

$sendgrid = new \SendGrid('1CF690E8FBC2338A085C8181D6031DAD1D3DBF6225F5ABDCF33E9CE2AC767D9F7E33384A2C816BB372886D02FFF12264');
try {
    $response = $sendgrid->send($email);
    echo "Email sent successfully!";
} catch (Exception $e) {
    echo 'Email could not be sent: ' . $e->getMessage();
}
?>
