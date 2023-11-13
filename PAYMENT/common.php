<?php
require_once 'dbconfig.php';

class STUDENT {

	private $conn;

	public function __construct() {
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
	}

	public function runQuery( $sql ) {
		$stmt = $this->conn->prepare( $sql );
		return $stmt;
	}

	public function lasdID() {
		$stmt = $this->conn->lastInsertId();
		return $stmt;
	}


	public function razorPayOnline($name,$email,$phone, $service, $typeProduct, $toValue, $message,$razorpayOrderId,$razorpayPaymentId,$paymentStatus,$makerstamp,$updatestamp) {
		try {
			$stmt = $this->conn->prepare( "INSERT INTO onlinepayment(name, email, phone, service, typeProduct, toValue, message, razorpayOrderId, razorpayPaymentId, paymentStatus,makerstamp,updatestamp) 	
			VALUES(:name_o,:email_o,:phone_o,:service_o,:typeProduct_o,:toValue_o,:message_o,:razorpayOrderId_o,:razorpayPaymentId_o,:paymentStatus_o,:makerstamp_o,:updatestamp_o)" );
			$stmt->bindparam( ":name_o", $name );
  			$stmt->bindparam( ":email_o", $email );
  			$stmt->bindparam( ":phone_o", $phone );
  			$stmt->bindparam( ":service_o", $service );
  			$stmt->bindparam( ":typeProduct_o", $typeProduct ); 
			$stmt->bindparam( ":toValue_o", $toValue ); 
			$stmt->bindparam( ":message_o", $message );
			$stmt->bindparam( ":razorpayOrderId_o", $razorpayOrderId );
			$stmt->bindparam( ":razorpayPaymentId_o", $razorpayPaymentId );
			$stmt->bindparam( ":paymentStatus_o", $paymentStatus );
			$stmt->bindparam( ":makerstamp_o", $makerstamp );
			$stmt->bindparam( ":updatestamp_o", $updatestamp );
			$stmt->execute();
			return $stmt;

		} catch ( PDOException $ex ) {
			echo $ex->getMessage();
		}
	}
	
	public function updatePayStatus($email, $razorpayOrderId, $razorpayPaymentId, $paymentStatus, $updatestamp) {
		try {
			$stmt = $this->conn->prepare( "UPDATE onlinepayment SET razorpayPaymentId=:razorpayPaymentId,paymentStatus=:paymentStatus,updatestamp=:updatestamp WHERE email=:email and razorpayOrderId='$razorpayOrderId'" );
			$stmt->bindparam( ":email", $email );
  			$stmt->bindparam( ":razorpayPaymentId", $razorpayPaymentId );
			$stmt->bindparam( ":paymentStatus", $paymentStatus );
  			$stmt->bindparam( ":updatestamp", $updatestamp );
			$stmt->execute();
			return $stmt;

		} catch ( PDOException $ex ) {
			echo $ex->getMessage();
		}
	}
}