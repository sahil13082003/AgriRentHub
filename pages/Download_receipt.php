<?php

$db = mysqli_connect("localhost", "root", "", "farmer") or die("Connection Failed");

$transaction_id = $_POST['razorpayPaymentId']; // Assuming you receive the transaction ID correctly via POST

$sql = "SELECT * FROM online_payment WHERE razorpayPaymentId = '$transaction_id'";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id = $row['id'];
    $amount = $row['total_cost'];
    $customer_id = $row['customer_id'];
} else {
    echo "Transaction not found in the database.";
    exit; // Exit script if the transaction is not found.
}

require_once('tcpdf/tcpdf.php'); // Include TCPDF library

$pdf = new TCPDF();

$pdf->SetCreator('AgriRentHub');
$pdf->SetAuthor('AgriRentHub');
$pdf->SetTitle('Receipt');
$pdf->SetSubject('Receipt');
$pdf->SetKeywords('Receipt, Razorpay, Transaction');

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

$pdf->AddPage();

$pdf->SetFont('Bookman old style', '', 12);
$pdf->Cell(0, 30, 'Receipt', 0, 1, 'C');
$pdf->Cell(0, 10, 'Transaction ID: ' . $transaction_id, 0, 1); // Use the correct variable
$pdf->Cell(0, 10, 'Customer ID: ' . $customer_id, 0, 1);
$pdf->Cell(0, 10, 'Amount Paid: Rs. ' . $amount, 0, 1);

$pdfFilePath = 'c:\xampp\htdocs\Receipt\Receipts\receipt.pdf'; // Update the file path as needed
$pdf->Output($pdfFilePath, 'D');

$pdf->Close();

// Provide a link to download the PDF
echo '<a href="path/to/receipt.pdf" download>Download Receipt (PDF)</a>';
?>
