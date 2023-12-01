<?php
$db = mysqli_connect("localhost", "root", "", "farmer") or die('connection failed');

$Payment_id= $_GET['id']; 

$sql = "select * from online_payment where requestId='$Payment_id'";

$result = mysqli_query($db,$sql) or die ("connection failed in card")  ;

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id = $row['requestId'];
    $amount = $row['total_cost'];
    $customer_id = $row['customer_id'];
    $owner_id = $row['owner_id'];
    $razorpayPaymentId = $row['razorpayPaymentId'];

} else {
    echo "Transaction not found in the database.";
    exit; 
}

require_once('../PDF/tcpdf.php'); // Include TCPDF library

$pdf = new TCPDF();

$pdf->SetCreator('AgriRentHub');
$pdf->SetAuthor('AgriRentHub');
$pdf->SetTitle('Receipt');
$pdf->SetSubject('Receipt');
$pdf->SetKeywords('Receipt, Razorpay, Transaction');

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

$pdf->AddPage();

$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 30, 'Receipt', 0, 1, 'C');
$pdf->Cell(0, 10, 'Transaction ID: ' . $razorpayPaymentId, 0, 1); 
$pdf->Cell(0, 10, 'Customer ID: ' . $customer_id, 0, 1);
$pdf->Cell(0, 10, 'Owner ID: ' . $owner_id, 0, 1);
$pdf->Cell(0, 10, 'Amount Paid: Rs. ' . $amount, 0, 1);

$pdfFilePath = 'c:\xampp\htdocs\Receipt\Receipts\receipt.pdf'; 
$pdf->Output($pdfFilePath, 'D');

$pdf->Close();

echo '<a href="path/to/receipt.pdf" download>Download Receipt (PDF)</a>';
?>
