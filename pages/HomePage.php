<?php
include '../components/Links.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>AgriRentHub</title>
</head>
<body>
	<?php 
include '../components/navbar.php';
	?>

<div class="slider-container">
    <div class="slide">
      <img src="../Images/wp7525688.jpg" alt="Image 1">
      <div class="slide-content">
        <p style="font-size: larger;">Namaste, Welcome to <span class="special_text">AgriRentHub.</span></p>
        <h1>Top-Quality <span class="special_text">Farming Equipment</span> <br>at Down-to-Earth Prices.</h1>
        <p>Access quality farm equipment with just one click</p>
        <a href="../pages/Dashboard.php"><button>Book Now</button></a>
      </div>
    </div>
  </div>


<div class="title">
		<span>Features of AgriRentHub</span>
	</div> 

  <div class="service-swipe container">
		<div class="diffSection" id="services_section">
		</div>
		<a ><div class="s-card"><img src="../images/booking.jpeg"><p>One Click Booking</p></div></a>
		<a ><div class="s-card"><img src="../images/trust.jpeg"><p>Trusted Seller/Buyess</p></div></a>
		<a ><div class="s-card"><img src="../images/Shipping.jpeg"><p>Fast Shipping/Delivery</p></div></a>
		<a ><div class="s-card"><img src="../images/Secure_Payment.jpeg"><p>Secure Payment Processing</p></div></a>
	</div> 
	<hr>

	<!-- EQUIPMENT LIST -->
	
	<div class="title">
		<span>Equipment list</span>
	</div> 
	<div class="Equp_list ">
    <div class="card-list ">
		<div class="card">
            <img src="../images/tractor.jpeg" class="equipImg" style = "height : 80%" alt="Card 1">
            <h2>Tractor</h2>
        </div>
		<div class="card">
            <img src="../images/tillage.jpeg"  class="equipImg"  style = "height : 80%" alt="Card 1">
            <h2>Tillage Equipments</h2>
            
        </div>
        <div class="card">
            <img src="../images/seeding.jpeg"   class="equipImg" style = "height : 80%" alt="Card 1">
            <h2>Seeding Equipments</h2>
        </div>
        <div class="card">
            <img src="../images/landscape.jpeg"   class="equipImg"  style = "height : 80%" alt="Card 2">
            <h2>Landscape Equipments</h2>
        </div>
		<div class="card">
            <img src="../images/crop_protection.jpeg"   class="equipImg" style = "height : 80%" alt="Card 1">
            <h2>Crop Protection</h2>
        </div>
        <div class="card">
            <img src="../images/harvest.jpeg"  class="equipImg" style = "height : 80%"  alt="Card 2">
            <h2>Harvest Equipments</h2>
     </div> 
	 <div class="card">
            <img src="../images/tractor.jpeg"  class="equipImg" style = "height : 80%"  alt="Card 1">
            <h2>Tractor</h2>
        </div>
		<div class="card">
            <img src="../images/tillage.jpeg"  class="equipImg" style = "height : 80%"  alt="Card 1">
            <h2>Tillage Equipments</h2>
            
        </div>
	</div>     

</div>


<!-- Contact Us -->


<div class="diffSection" id="contactus_section">
		<center><p style="font-size: 50px; padding: 80px; color:#175b1e ">Contact Us</p></center>
		<div class="back-contact">
			<div class="cc">
			 <form action="contactUsphp.php" method="post" > 
				<label>First Name <span class="imp">*</span></label><label style="margin-left: 185px">Last Name <span class="imp">*</span></label><br>
				<center>
				<input type="text" name="fname" style="margin-right: 10px; width: 175px" required="required"><input type="text" name="lname" style="width: 175px" required="required"><br>
				</center>
				<label>Email <span class="imp">*</span></label><br>
				<input type="email" name="email" style="width: 100%" required="required"><br>
				<label>Message <span class="imp">*</span></label><br>
				<input type="text" name="message" style="width: 100%" required="required"><br>
				<label>Additional Details</label><br>
				<textarea name="addtional"></textarea><br>
				<button type="submit" id="csubmit">Send Message</button>
			</form>
			</div>
		</div>
	</div>


  
	<!-- FOOTER -->
	<footer>
		<div class="footer-container">
			<div class="">
				<img src="../images/logo.png" style="width: 90px;">
				<p style="font-weight:bold">AgroRentHub</p>
				<div class="logo"></div>
				<div class="social-media">
					<a href="#"><img src="../images/fb2.png"></a>
					<a href="#"><img src="../images/insta.png"></a>
					<a href="#"><img src="../images/google.png"></a>
					<a href="#"><img src="../images/mail.png"></a>
					<a href="#"><img src="../images/linkedin.png"></a>
				</div><br><br>
				<p class="rights-text">Copyright © 2023 Created By <br><b> Sahil Golhar </b><br> Nayan Raut <br> Vedant Dalwi.</p>
				<br><p><img src=""> Bajaj Institute of Technology <br>Pipri, Wardha-442001</p><br>
			</div>

			<div class="">
				<img src="../images/logo.png" style="width: 90px;">
				<p style="font-weight:bold">AgroRentHub</p>
				<div class="logo"></div>
				<div class="social-media">
					<a href="#"><img src="../images/fb2.png"></a>
					<a href="#"><img src="../images/insta.png"></a>
					<a href="#"><img src="../images/google.png"></a>
					<a href="#"><img src="../images/mail.png"></a>
					<a href="#"><img src="../images/linkedin.png"></a>
				</div><br><br>
				<p class="rights-text">Copyright © 2023 Created By <br> Sahil Golhar <br> <b>Nayan Raut</b> <br> Vedant Dalwi.</p>
				<br><p><img src=""> Bajaj Institute of Technology <br>Pipri, Wardha-442001</p><br>
			</div>

			<div class="">
				<img src="../images/logo.png" style="width: 90px;">
				<p style="font-weight:bold">AgroRentHub</p>
				<div class="logo"></div>
				<div class="social-media">
					<a href="#"><img src="../images/fb2.png"></a>
					<a href="#"><img src="../images/insta.png"></a>
					<a href="#"><img src="../images/google.png"></a>
					<a href="#"><img src="../images/mail.png"></a>
					<a href="#"><img src="../images/linkedin.png"></a>
				</div><br><br>
				<p class="rights-text">Copyright © 2023 Created By <br> Sahil Golhar <br> Nayan Raut <br><b> Vedant Dalwi.</b></p>
				<br><p><img src=""> Bajaj Institute of Technology <br>Pipri, Wardha-442001</p><br>
			</div>
			
		</div>
	</footer>
	</body>
</html>
