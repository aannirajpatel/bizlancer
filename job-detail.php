<?php
require('includes/auth.php');
require('includes/db.php');
require('includes/constants.php');
$uid = $_SESSION['uid'];
if(!isset($_GET['jid'])){
    header_remove();
    header("location:404.php");
}
$jid = $_GET['jid'];
$jobQuery = "SELECT * FROM job WHERE jid=$jid";
$jobResult = mysqli_query($con, $jobQuery);
if(mysqli_num_rows($jobResult) !=1 ){
    header("location:404.php");
}
$job = mysqli_fetch_array($jobResult);
$company = "SELECT * FROM company WHERE cid = ".$job['cid'];
$company = mysqli_query($con,$company);
$company = mysqli_fetch_array($company);
if(isset($_GET['apply']) && $_GET['apply']== 1){
    $applyQuery = "INSERT INTO application(uid, jid, status, timeofapply) VALUES($uid, $jid, 0, CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE status=0";
    mysqli_query($con, $applyQuery) or die(mysqli_error($con));
}
if(isset($_GET['apply']) && $_GET['apply'] == 0){
    $applyQuery = "UPDATE application SET status=4 WHERE uid=$uid AND jid=$jid";
    mysqli_query($con, $applyQuery) or die(mysqli_error($con));
}
?>

<!doctype html>
<html lang="en">

<!-- job-detail41:26-->
<head>
	<!-- Basic Page Needs
	================================================== -->
	<title><?php echo $job['title'];?> at <?php echo $company['cname'];?></title>
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
			<?php require('header.php'); ?>
			<!-- End Navigation -->
			<div class="clearfix"></div>
			
			<!-- Title Header Start -->
			<section class="inner-header-title" style="background-image:url(assets/img/banner-10.jpg);">
				<div class="container">
					<h1>Job Detail</h1>
				</div>
			</section>
			<div class="clearfix"></div>
			<!-- Title Header End -->
			
			<!-- Job Detail Start -->
			<section class="detail-desc">
				<div class="container white-shadow">
				
					<div class="row">
					
						<div class="detail-pic">
                            <a href="company-detail.php?cid=<?php echo $company['cid'];?>" title="View company details">
							<img src="<?php echo $company['cimg']?>" class="img" alt="" />
                            </a>
						</div>
						
						<div class="detail-status">
							<span>Posted <?php echo DateTime::createFromFormat('Y-m-d',$job['startdate'])->format('M d, Y');?></span>
						</div>
						
					</div>
					
					<div class="row bottom-mrg">
                        <div class="col-md-8 col-sm-8">
                            <div class="detail-desc-caption">
                                <h4><?php echo $job['title']?> at <?php echo $company['cname']?>&nbsp;&nbsp;<small class="designation"><i class="fa fa-money"></i> ₹<?php echo $job['pay']."/".$payScaleArray[$job['paytype']];?></small></h4>
                                <br>
                                <div class="show-as-is">
                                    <?php echo $job['requirements'];?>
                                </div>
                                <br>
                                <ul>
                                    <li><i class="fa fa-briefcase"></i><span><?php echo $jobTypeArray[$job['jobtype']];?></span></li>
                                    <li><i class="fa fa-calendar"></i><span>Apply by <?php echo DateTime::createFromFormat('Y-m-d',$job['enddate']) -> format('M d, Y');?></span></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-4">
                            <div class="get-touch">
                                <h4>Get in Touch</h4>
                                <ul>
                                    <li><i class="fa fa-map-marker"></i><span><?php echo $job['location'];?></span></li>
                                    <li><i class="fa fa-envelope"></i><span><?php echo $company['email'];?></span></li>
                                    <li><i class="fa fa-globe"></i><span><?php echo $company['website']; ?></span></li>
                                    <li><i class="fa fa-phone"></i><span><?php echo $company['phone'];?></span></li>
                                </ul>
                            </div>
                        </div>

                    </div>
					
					<div class="row no-padd">
						<div class="detail pannel-footer">
							<div class="col-md-5 col-sm-5">
								<ul class="detail-footer-social">
									<li><a href="<?php echo $company['facebook']; ?>"><i class="fa fa-facebook"></i></a></li>
									<li><a href="<?php echo $company['gplus']; ?>"><i class="fa fa-google-plus"></i></a></li>
									<li><a href="<?php echo $company['twitter']; ?>"><i class="fa fa-twitter"></i></a></li>
									<li><a href="<?php echo $company['linkedin']; ?>"><i class="fa fa-linkedin"></i></a></li>
									<li><a href="<?php echo $company['dribble']; ?>"><i class="fa fa-instagram"></i></a></li>
								</ul>
							</div>
							
							<div class="col-md-7 col-sm-7">
								<div class="detail-pannel-footer-btn pull-right">
                                    <?php
                                    $applyCheck = "SELECT * FROM application WHERE uid=$uid AND jid=$jid";
                                    $applyResult = mysqli_query($con,$applyCheck) or die(mysqli_error($con));
                                    if(mysqli_num_rows($applyResult) == 0){
                                    ?>
                                    <a href="job-detail.php?jid=<?php echo $jid;?>&apply=1" class="footer-btn grn-btn" title="">Apply</a>
                                    <?php
                                    } else{
                                        $applyData = mysqli_fetch_array($applyResult);
                                        if($applyData['status']==CANDIDATE_WITHDRAWN) {
                                            ?>
                                            <a href="job-detail.php?jid=<?php echo $jid;?>&apply=1" class="footer-btn grn-btn" title="">Apply</a>
                                            <?php
                                        } else{
                                            ?>
                                            <a href="#" class="footer-btn grn-btn" title=""><?php echo $statusArray[$applyData['status']];?></a>
                                            <?php
                                            if($applyData['status'] != CANDIDATE_REJECTED) {
                                                ?>
                                                <a href="job-detail.php?jid=<?php echo $jid; ?>&apply=0"
                                                   class="footer-btn grn-btn" title="">Withdraw Application</a>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<!-- Job Detail End -->
			
			<!-- Job full detail Start -->
			<!-- Job full detail End -->
			
			<!-- Footer Section Start -->
            <?php
            require 'footer.php';
            ?>
			<div class="clearfix"></div>
			<!-- Footer Section End -->
			
			<!-- Sign Up Window Code -->
            <?php
            require('loginModal.php');
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

<!-- job-detail41:26-->
</html>