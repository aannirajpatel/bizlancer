<?php
require('includes/auth.php');
require('includes/db.php');
require('includes/constants.php');
require('includes/files.php');
$uid = $_SESSION['uid'];
$message = "";
if(getUserTypeFromTable($con,$uid)!=USER_CANDIDATE){
    header_remove();
    header("location:404.php");
}
?>

<!doctype html>
<html lang="en">

<!-- manage-company41:40-->
<head>
	<!-- Basic Page Needs
	================================================== -->
	<title>Manage Applications | BizLancer</title>
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
					<h1>Manage Applications</h1>
                    <?php
                    if($message!=""){
                        echo "<h3>".$message."</h3>";
                    }
                    ?>
				</div>
			</section>
			<div class="clearfix"></div>
			<!-- Title Header End -->
			
			<!-- Manage Company List Start -->
			<section class="manage-company gray">
				<div class="container">
				
					<!-- search filter -->

					<!-- search filter End -->
                    <?php
                    if($message=="") {
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                $jobQuery = "SELECT * FROM job, application WHERE application.uid=$uid AND job.jid = application.jid";
                                $jobResult = mysqli_query($con, $jobQuery) or die(mysqli_error($con));
                                while ($jobRow = mysqli_fetch_array($jobResult)) {
                                    $companyQuery = "SELECT * FROM company WHERE cid=".$jobRow['cid'];
                                    $companyResult = mysqli_query($con, $companyQuery) or die(mysqli_error($con));
                                    $companyRow = mysqli_fetch_array($companyResult);
                                    ?>
                                    <article>
                                        <div class="mng-company">
                                            <div class="col-md-5 col-sm-5">
                                                <div class="mng-company-name">
                                                    <h4><?php echo $jobRow['title']; ?><span class="cmp-tagline"></span>
                                                    </h4>
                                                    <span class="cmp-time">Company: <?php echo $companyRow['cname'];?>,&nbsp;Status: <?php echo $statusArray[$jobRow['status']]; ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-3">
                                                <div class="mng-company-name">
                                                    <h5><i class="fa fa-money"></i> ₹ <?php echo $jobRow['pay']; ?>
                                                        /<?php echo $payScaleArray[$jobRow['paytype']]; ?></h5>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-2">
                                                <div class="mng-company-location">
                                                    <p>
                                                        <i class="fa fa-map-marker"></i>&nbsp;<?php echo $jobRow['location']; ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-2">
                                                <div class="mng-company-action">
                                                    <a href="chat-with-company.php?user=<?php echo $jobRow['cid']; ?>"
                                                       data-toggle="tooltip" title="Chat with company"><i
                                                                class="fa fa-envelope"></i></a>
                                                    <a href="job-detail.php?jid=<?php echo $jobRow['jid']; ?>"
                                                       data-toggle="tooltip" title="View Job Details"><i
                                                                class="fa fa-eye"></i></a>
                                                    <a href="job-detail.php?jid=<?php echo $jobRow['jid']; ?>&apply=0"
                                                       data-toggle="tooltip" title="Withdraw Application"><i
                                                                class="fa fa-trash-o"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
					<!--<div class="row">
						<ul class="pagination">
							<li><a href="#">&laquo;</a></li>
							<li class="active"><a href="#">1</a></li>
							<li><a href="#">2</a></li>
							<li><a href="#">3</a></li> 
							<li><a href="#">4</a></li> 
							<li><a href="#"><i class="fa fa-ellipsis-h"></i></a></li> 
							<li><a href="#">&raquo;</a></li> 
						</ul>
					</div>-->
					
				</div>
			</section>
			<!-- Manage Company List End -->
			
			<!-- Footer Section Start -->
            <?php
            require('footer.php');
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
			
			<script>
				$(document).ready(function(){
					$('[data-toggle="tooltip"]').tooltip();   
				});
			</script>
		</div>
	</body>

<!-- manage-company41:40-->
</html>