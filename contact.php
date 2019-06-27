<?php
session_start();
require 'includes/db.php';
require 'includes/files.php';
require 'includes/constants.php';

if(isset($_POST['contactrequest'])){
    $to = "bmc581998@gmail.com";
    $from = mysqli_real_escape_string($con, $_POST['email']);
    $sub = "Contact Request from BizLancer, Sub: ".mysqli_real_escape_string($con, $_POST['sub']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $msg = "Name: ".$name."<br>Phone:<a href='tel:$phone'>".$phone."</atel><br>Message:<br>".mysqli_real_escape_string($con, $_POST['msg']);
    $mailHeader = "MIME-Version: 1.0\r\nContent-Type:text/html\r\nFrom: support@bizlancer.com\r\n";
    mail($to,$sub,$msg,$mailHeader);
}
?>

<!doctype html>
<html lang="en">

<!-- contact42:01-->
<head>
	<!-- Basic Page Needs
	================================================== -->
	<title>Contact Us | BizLancer</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- CSS
	================================================== -->
	<link rel="stylesheet" href="assets/plugins/css/plugins.css">
    
    <!-- Custom style -->
    <link href="assets/css/style.css" rel="stylesheet">
	<link type="text/css" rel="stylesheet" id="jssDefault" href="assets/css/colors/green-style.css">
    
	</head>
	<body>
		<div class="Loader"></div>
		<div class="wrapper">
			
			<!-- Start Navigation -->
            <?php
            require 'header.php';
            ?>
			<!-- End Navigation -->
			<div class="clearfix"></div>
			
			<!-- Title Header Start -->
			<section class="inner-header-title" style="background-image:url(assets/img/banner-10.jpg);">
				<div class="container">
					<h1>Contact Us</h1>
				</div>
			</section>
			<div class="clearfix"></div>
			<!-- Title Header End -->
			
			<!-- Contact Page Section Start -->
			<section class="contact-page">
				<div class="container">
					<div class="col-md-4 col-sm-4">
						<div class="contact-box">
							<i class="fa fa-map-marker"></i>
							<p>C-505, Manubhai Tower<br>Sayajigunj, Vadodara, Gujarat IN 390021</p>
						</div>
					</div>
					
					<div class="col-md-4 col-sm-4">
						<div class="contact-box">
							<i class="fa fa-envelope"></i>
							<p>support@bizlancer.com</p>
						</div>
					</div>
					
					<div class="col-md-4 col-sm-4">
						<div class="contact-box">
							<i class="fa fa-phone"></i>
							<p>+91 72029 98877</p>
						</div>
					</div>
					
				</div>
			</section>
			<!-- contact section End -->
			
			<!-- contact form -->
			<section class="contact-form">
				<div class="container">
                    <form method="post" action="" id="contact-form">
					<h2>Drop A Mail</h2>
					
					<div class="col-md-6 col-sm-6">
						<input type="text" class="form-control" placeholder="Your Name" name="name">
					</div>
					
					<div class="col-md-6 col-sm-6">
						<input type="email" class="form-control" placeholder="Your Email" name="email">
					</div>
					
					<div class="col-md-6 col-sm-6">
						<input type="text" class="form-control" placeholder="Phone Number" name="phone">
					</div>
					
					<div class="col-md-6 col-sm-6">
						<input type="text" class="form-control" placeholder="Subject" name="sub">
					</div>
					
					<div class="col-md-12 col-sm-12">
						<textarea class="form-control" placeholder="Message" name="msg"></textarea>
					</div>
					
					<div class="col-md-12 col-sm-12">
						<button type="submit" class="btn btn-primary" name="contactrequest">Submit</button>
					</div>
                    </form>
				</div>
			</section>
			<!-- Contact form End -->
			
			<!-- Footer Section Start -->
            <?php
            require 'footer.php';
            ?>
			<div class="clearfix"></div>
			<!-- Footer Section End -->
			
			<!-- Sign Up Window Code -->
            <?php
            require 'loginModal.php';
            ?>
			<!-- End Sign Up Window -->

			<!-- Scripts
			================================================== -->
			<script type="text/javascript" src="assets/plugins/js/jquery.min.js"></script>
			<script type="text/javascript" src="assets/plugins/js/viewportchecker.js"></script>
			<script type="text/javascript" src="assets/plugins/js/bootstrap.min.js"></script>
			<script type="text/javascript" src="assets/plugins/js/bootsnav.js"></script>
			<script type="text/javascript" src="assets/plugins/js/select2.min.js"></script>
			<script type="text/javascript" src="assets/plugins/js/wysihtml5-0.3.0.js"></script>
			<script type="text/javascript" src="assets/plugins/js/bootstrap-wysihtml5.js"></script>
			<script type="text/javascript" src="assets/plugins/js/datedropper.min.js"></script>
			<script type="text/javascript" src="assets/plugins/js/dropzone.js"></script>
			<script type="text/javascript" src="assets/plugins/js/loader.js"></script>
			<script type="text/javascript" src="assets/plugins/js/owl.carousel.min.js"></script>
			<script type="text/javascript" src="assets/plugins/js/slick.min.js"></script>
			<script type="text/javascript" src="assets/plugins/js/gmap3.min.js"></script>
			<script type="text/javascript" src="assets/plugins/js/jquery.easy-autocomplete.min.js"></script>
			<!-- Custom Js -->
			<script src="assets/js/custom.js"></script>
        </div>
	</body>

<!-- contact42:01-->
</html>