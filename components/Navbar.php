<?php
   session_start(); 
   include '../components/Links.php';
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgroRentHub</title>
    <link rel="stylesheet" href="css/navbar.css">
</head>
<body>
    <div class="topbar"> 
        <p>Agriculture Equipments Rental System</p>

        <!-- <div id="google_translate_element">
				<script type="text/javascript">
					function googleTranslateElementInit() {
						new google.translate.TranslateElement({ pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE }, 'google_translate_element');
					}
				</script>
				<script type="text/javascript"
					src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">

					</script>
		</div> -->
	</div>
        
    <header>
        <div class="navbar">
            <div class="logo">
                <a href="../pages/HomePage.php">
                    <img src="../Images/logo.png" alt="Logo">
                </a>
                <a href="../pages/HomePage.php"><p>AgriRentHub</p></a>
            </div>
            
            <button class="menu-button" onclick="toggleMenu()">&#9776;</button>
            
            <ul class="links">
                <li><a href="../pages/HomePage.php">Home</a></li>
                <li><a href="../pages/Dashboard.php">Dashboard</a></li>
                <?php if(!isset($_SESSION['email'])) { ?>
                <li><a href="#Contact">Contact</a></li>
                <li><a href="../pages/help.php">Help</a></li>
                <?php }?>
                <?php if(isset($_SESSION['email'])) { ?>
                <li>
                    <a  style="cursor: pointer" data-toggle="modal" data-target="#equipmentModal11">Add Product</a>
                </li>
                <?php } ?>
                <?php if(isset($_SESSION['email'])) { ?>
                <li><a href="../pages/help.php">Help</a></li>
                <?php } ?>
            </ul>
            
            <div class="user-dropdown-container position">
                <?php
                    if (isset($_SESSION['email'])) {
                    $user = $_SESSION['uname'];
                    echo '<div class="dropdown ">';
                    echo '<button class="btn btn-success font-weight-bold">'. $user .'<i class="fa fa-caret-down"></i></button>';
                    echo '<div class="dropdown-content">';
                    echo '<div><a href="../pages/Booking_Details.php">Booking Details</a></div>';
                    echo '<div><a href="../pages/Booking_Request.php">Booking Request</a></div>';
                    echo '<div><a href="../backend_php/Logout.php">Log Out</a></div>';
                    echo '</div>';
                    echo '</div>';
                } else {
                    echo '<button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter">SignIn</button>';
                }
                ?>
            </div>
        </div>
    </header>

    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"> LogIn </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        <form action="../backend_php/Login.php" method="post">
                            <div class="mb-3">
                                <label class="form-label mediumGreenText">Email address</label>
                                <input type="email" name="email" class="form-control shadow-none" />
                            </div>

                            <div class="mb-4">
                                <label class="form-label mediumGreenText">Password</label>
                                <input type="password" name="password" class="form-control shadow-none" />
                            </div>

                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <button class="btn btn-success SHADOW-NONE w-100">
                                    Login
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <div style="display : block">
                        <h6 class="mediumGreenText">Not Registered Yet ? Click on Register</h6>
                    </div>
                    <div>
                        <button type="button" class="btn btn-outline-success w-100" data-dismiss="modal"
                            data-toggle="modal" data-target="#registermodel">Register</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal for register in -->
    <div class="modal fade" id="registermodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Registration</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="modal-body">

                        <!-- form  -->
                        <form action="../backend_php/Register.php" method="post">
                            <div class="mb-3">
                                <label class="form-label mediumGreenText">Email address</label>
                                <input type="email" name="email" class="form-control shadow-none" />
                            </div>

                            <div class="mb-4">
                                <label class="form-label mediumGreenText">Name</label>
                                <input type="text" name="name" class="form-control shadow-none" />
                            </div>

                            <div class="mb-4">
                                <label class="form-label mediumGreenText">Address</label>
                                <input type="text" name="address" class="form-control shadow-none" />
                            </div>

                            <div class="mb-4">
                                <label class="form-label mediumGreenText">Password</label>
                                <input type="password" name="password" class="form-control shadow-none" />
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <button class="btn btn-success SHADOW-NONE w-100">
                                    Register
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <div style="display : block">
                        <h6 class="mediumGreenText">Already Registered ? Click on LogIn</h6>
                    </div>
                    <div>
                        <button type="button" class="btn btn-outline-success w-100" data-dismiss="modal"
                            data-toggle="modal" data-target="#exampleModalCenter">LogIn</button>
                    </div>
                </div>

            </div>
        </div>
    </div>



    <!-- add product -->


    <?php include '../pages/Add_Product.php' ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="../js/navbar.js"></script>
</body>

</html>