<?
require 'includes/db.php';
if(isset($_POST['forgot'])){
    $email = mysqli_real_escape_string($con, $_POST['forgot']);
    $existQuery = "SELECT * FROM user WHERE email = '$email'";
    $existResult = mysqli_connect($con, $existQuery);
    if(mysqli_num_rows($existResult) == 0){
        header("location:login.php?message=");
    }
    $existData = mysqli_fetch_array($existResult);
}
?>

<!doctype html>
<html lang="en">

<!-- lost-password42:17-->
<head>
	<!-- Basic Page Needs
	================================================== -->
	<title>Forgot Password | BizLancer</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- CSS
	================================================== -->
	<link rel="stylesheet" href="assets/plugins/css/plugins.css">
    
    <!-- Custom style -->
    <link href="assets/css/style.css" rel="stylesheet">
	<link type="text/css" rel="stylesheet" id="jssDefault" href="assets/css/colors/green-style.css">
    
	</head>
	<body class="simple-bg-screen" style="background-image:url(assets/img/banner-10.jpg);">
		<div class="Loader"></div>
		<div class="wrapper">  
			
			<!-- Title Header Start -->
			<section class="lost-ps-screen-sec">
				<div class="container">
					<div class="lost-ps-screen">
						<a href="index-2.html"><img src="assets/img/logo.png" class="img-responsive" alt=""></a>
						<form method="post" action="">
							<input type="email" class="form-control" placeholder="Enter your Email" name="email">
							<button class="btn btn-login" type="submit" name="forgot">Submit</button>
						</form>
					</div>
				</div>
			</section>

			
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

<!-- lost-password42:17-->
</html>