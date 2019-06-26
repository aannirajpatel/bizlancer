<?php
session_start();
require 'includes/db.php';
require 'includes/constants.php';
?>

<!doctype html>
<html lang="en">

<!-- faq42:00-->
<head>
	<!-- Basic Page Needs
	================================================== -->
	<title>Job Stock - Responsive Job Portal Bootstrap Template</title>
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
					<h1>FAQs</h1>
				</div>
			</section>
			<div class="clearfix"></div>
			<!-- Title Header End -->
			
			<!-- Accordion Design Start -->
			<section class="accordion">
				<div class="container">
					<div class="col-md-12 col-sm-12">
						<div class="simple-tab">
							<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
								<div class="panel panel-default">
									<div class="panel-heading" role="tab" id="headingOne">
										<h4 class="panel-title">
											<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
											   I want to get jobs using BizLancer. What should I do?
											</a>
										</h4>
									</div>
									<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
										<div class="panel-body">
                                            <ol>
											<li>The first step is to create a Candidate account:</li>
                                            <ul>
                                                <li>Click sign up/login from the top menu buttons</li>
                                                <li>Click on sign up</li>
                                                <li>Fill-in your details</li>
                                                <li>Submit the form</li>
                                            </ul>
                                            <li>Now, you will automatically be logged in. <b>If you don't get logged in, you wont see a logout button on the top right corner of the screen. In such case:</b></li>
                                            <ul>
                                                <li>Click sign up/login from the top menu buttons</li>
                                                <li>Click on login</li>
                                                <li>Enter e-mail and password</li>
                                                <li>Submit the form</li>
                                            </ul>
                                            <li>Now that you are logged in, add all your details by clicking on "MANAGE PROFILE" from the top menu</li>
                                            <li>Once done, you can search for jobs and apply for any job by clicking on "FIND JOBS" from the top menu.</li>
                                            <li>You can see the status of your applications from the "MANAGE APPLICATIONS" page.</li>
                                            </ol>
										</div>
									</div>
								</div>
								<div class="panel panel-default">
									<div class="panel-heading" role="tab" id="headingTwo">
										<h4 class="panel-title">
											<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
												I want to find a freelancer/employee. What should I do?
											</a>
										</h4>
									</div>
									<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
										<div class="panel-body">
                                            <ol>
                                                <li>The first step is to create an Employer account:</li>
                                                <ul>
                                                    <li>Click sign up/login from the top menu buttons</li>
                                                    <li>Click on sign up</li>
                                                    <li>Fill-in your details. Click on the dropdown in the sign up form and select the Employer account option</li>
                                                    <li>Submit the form</li>
                                                </ul>
                                                <li>Now, you will automatically be logged in. <b>If you don't get logged in, you wont see a logout button on the top right corner of the screen. In such case:</b></li>
                                                <ul>
                                                    <li>Click sign up/login from the top menu buttons</li>
                                                    <li>Click on login</li>
                                                    <li>Enter e-mail and password</li>
                                                    <li>Submit the form</li>
                                                </ul>
                                                <li>Now that you are logged in, add all the details about your company by clicking on "COMPANY PROFILE" from the top menu. Then at the bottom of that page, click on submit to save your company details</li>
                                                <li>You can now post a job by clicking on "ADD JOB LISTING" from the top menu.</li>
                                                <li>You can see all the jobs that you have posted by going to the "TOOLS" dropdown and selecting "MANAGE JOB LISTINGS" from the top menu</li>
                                                <li>Once you are in the "MANAGE JOB LISTINGS" page, click on the black tie (<i class="fa fa-black-tie"></i>)symbol to see, shortlist, message, hire or reject the applicants to that particular job.</li>
                                                <li>Another way to get a freelancer is to search for freelancers by going to the "TOOLS" dropdown and clicking "FIND FREELANCERS", or directly searching for freelancers from the search bar on the top menu or home page.</li>
                                                <li>After searching from our large database of candidates, you can choose to message any one for further talks for hiring</li>
                                            </ol>
										</div>
									</div>
								</div>
								<div class="panel panel-default">
									<div class="panel-heading" role="tab" id="headingThree">
										<h4 class="panel-title">
											<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                I want to change my login e-mail/password. What do I do?
											</a>
										</h4>
									</div>
									<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
										<div class="panel-body">
                                            <ol>
                                                <li>If you have a Candidate account:</li>
                                                <ul>
                                                    <li>Click on "MANAGE PROFILE" from the top menu</li>
                                                    <li>Scroll down to the "GENERAL INFORMATION" section</li>
                                                    <li>Enter the new password into the fields</li>
                                                    <li>Submit the new data by clicking the submit button at the bottom of page</li>
                                                </ul>
                                                <li>If you have an Employer account:</li>
                                                <ul>
                                                    <li>Click on "PROFILE AND SETTINGS" from the "TOOLS" dropdown on the top menu</li>
                                                    <li>Scroll down to the "GENERAL INFORMATION" section</li>
                                                    <li>Enter the new password into the fields</li>
                                                    <li>Submit the new data by clicking the submit button at the bottom of page</li>
                                                </ul>
                                            </ol>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<!-- Accordion Design End -->
			
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

<!-- faq42:01-->
</html>