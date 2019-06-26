<?php
session_start();
require('includes/db.php');
require('includes/constants.php');
$searchQuery = "SELECT job.jid,job.title,job.location, job.pay, job.paytype, company.cimg, company.cname FROM job INNER JOIN company ON job.cid=company.cid WHERE 1=1";
if(!empty($_GET['q'])){
    $keyword = preg_split('/[;,\.]/', mysqli_real_escape_string($con, $_GET['q']));
    $searchQuery .= " AND (1=0";
    foreach($keyword as $v){
        $v = strtolower($v);
        $searchQuery .= " OR job.title LIKE('%$v%') OR job.requirements LIKE('%$v%') OR company.cname LIKE('%$v%') OR company.cdesc LIKE ('%$v%') OR company.about LIKE ('%$v%')";
    }
    $searchQuery.=")";
}
if(!empty($_GET['location'])){
    $location = preg_split('/[;,\.]/',mysqli_real_escape_string($con, $_GET['location']));
    $searchQuery .= " AND (1=0";
    foreach ($location as $v){
        $searchQuery .= " OR company.location LIKE('%$v%') OR job.location LIKE('%$v%')";
    }
    $searchQuery .= ")";
}
if(!empty($_GET['minPay']) && !empty($_GET['maxPay']) && !empty($_GET['paytype'])){
    $minPay = intval(mysqli_real_escape_string($con, $_GET['minPay']));
    $maxPay = intval(mysqli_real_escape_string($con, $_GET['maxPay']));
    $payType = $_GET['paytype'];
    $searchQuery.= " AND (job.pay BETWEEN $minPay AND $maxPay ) AND (job.paytype = $payType)";
}
if(!empty($_GET['jobtype']) && $_GET['jobtype'] < 4 ){
    $jobtype = intval(mysqli_real_escape_string($con, $_GET['jobtype']));
    $searchQuery .= " AND jobtype=$jobtype";
}
$searchQueryResult = mysqli_query($con, $searchQuery);
?>

<!doctype html>
<html lang="en">

<!-- search-new41:42-->
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
			<section class="inner-header-title no-br advance-header-title" style="background-image:url(assets/img/banner-10.jpg);">
				<div class="container">
					<h2><span>Work There.</span> Find the dream job</h2>
					<p><span>704</span> new job in the last <span>7</span> days.</p>
				</div>
			</section>
			<div class="clearfix"></div>
			<!-- Title Header End -->
			
			<!-- bottom form section start -->
			<section class="form-search">
					<form method="get" action="" name="searchForm" onsubmit="return vf()">
                        <div class="container">
						<div class="col-md-2 col-sm-6">
							<input type="text" class="form-control" placeholder="Skills, Designations, Keywords" name="q" value="<?php if(isset($_GET['q'])){echo $_GET['q'];}?>">
						</div>
						<div class="col-md-2 col-sm-6">
							<input type="text" class="form-control" placeholder="Location" name="location" value="<?php if(isset($_GET['location'])){echo $_GET['location'];}?>">
						</div>
						<div class="col-md-2 col-sm-6">
							<select class="form-control" name="jobtype">
                                <option <?php if(!isset($_GET['jobtype']) || (isset($_GET['jobtype']) && $_GET['jobtype']==4)){echo "selected";}?> value="4">All Job Types</option>
                                <option <?php if(isset($_GET['jobtype']) && $_GET['jobtype']==JOB_TYPE_FULLTIME){echo "selected";}?> value="<?php echo JOB_TYPE_FULLTIME; ?>">Full Time</option>
                                <option <?php if(isset($_GET['jobtype']) && $_GET['jobtype']==JOB_TYPE_PARTTIME){echo "selected";}?> value="<?php echo JOB_TYPE_PARTTIME; ?>">Part Time</option>
                                <option <?php if(isset($_GET['jobtype']) && $_GET['jobtype']==JOB_TYPE_FREELANCER){echo "selected";}?> value="<?php echo JOB_TYPE_FREELANCER; ?>">Freelance</option>
                                <option <?php if(isset($_GET['jobtype']) && $_GET['jobtype']==JOB_TYPE_INTERNSHIP){echo "selected";}?> value="<?php echo JOB_TYPE_INTERNSHIP; ?>">Internship</option>
							</select>
						</div>

                        <div class="col-md-2 col-sm-6">
                            <input type="number" class="form-control" name="minPay" id="min-pay" placeholder="Min pay (₹)" value="<?php if(isset($_GET['minPay'])){echo $_GET['minPay'];}?>" min="0" step="500">
                        </div>
                        <div class="col-md-2 col-sm-6">
                            <input type="number" class="form-control" name="maxPay" id="max-pay" placeholder="Maximum pay(₹)" value="<?php if(isset($_GET['maxPay'])){echo $_GET['maxPay'];}?>" min="0" step="500">
                        </div>

                        <div class="col-md-2 col-sm-6">
                            <select class="form-control" name="paytype">
                                <option <?php if(isset($_GET['paytype']) && $_GET['paytype']==PAY_PER_YEAR){echo "selected";}?> value="<?php echo PAY_PER_YEAR; ?>">Per Year</option>
                                <option <?php if(isset($_GET['paytype']) && $_GET['paytype']==PAY_PER_MONTH){echo "selected";}?> selected value="<?php echo PAY_PER_MONTH;?>">Per Month</option>
                                <option <?php if(isset($_GET['paytype']) && $_GET['paytype']==PAY_PER_WEEK){echo "selected";}?> value="<?php echo PAY_PER_WEEK;?>">Per Week</option>
                                <option <?php if(isset($_GET['paytype']) && $_GET['paytype']==PAY_PER_DAY){echo "selected";}?> value="<?php echo PAY_PER_DAY;?>">Per Day</option>
                                <option <?php if(isset($_GET['paytype']) && $_GET['paytype']==PAY_PER_HOUR){echo "selected";}?> value="<?php echo PAY_PER_HOUR;?>">Per Hour</option>
                            </select>
                        </div>
                    </div>
                        <br>
                    <div class="container">
                        <div class="col-md-5 d-sm-none"></div>
						<div class="col-md-2 col-sm-6">
							<button type="submit" class="btn btn-primary" id="search-submit">Search Job</button>
						</div>

                        <div class="col-md-5 d-sm-none"></div>
                    </div>
					</form>
			</section>
			<!-- Bottom Search Form Section End -->
			
			<!-- ========== Begin: Brows job Category ===============  -->
			<section class="brows-job-category gray-bg">
				<div class="container">
					<div class="col-12">
						<div class="full-card">
						
							<div class="card-header padd-bot-10 padd-left-10">
                                <h4>Search results</h4>
							</div>
							
							<div class="card-body">
                                <?php
                                if(mysqli_num_rows($searchQueryResult) == 0){
                                    ?>
                                    No results found. Try broadening your search!
                                    <?php
                                }
                                while($job = mysqli_fetch_array($searchQueryResult)) {
                                    ?>
                                    <article class="advance-search-job">
                                        <div class="row no-mrg">
                                            <div class="col-md-5 col-sm-5">
                                                <a href="job-detail.php?jid=<?php echo $job['jid'];?>" title="job Detail">
                                                    <div class="advance-search-img-box">
                                                        <img src="<?php echo $job['cimg'];?>" class="img-responsive" alt="">
                                                    </div>
                                                </a>
                                                <div class="advance-search-caption">
                                                    <a href="job-detail.php?jid=<?php echo $job['jid'];?>" title="Job Dtail"><h4><?php echo $job['title'];?></h4></a>
                                                    <span><?php echo $job['cname'];?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-2">
                                                <div class="advance-search-job-locat">
                                                    <p><i class="fa fa-map-marker"></i><?php echo $job['location'];?></p>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-2">
                                                <div class="advance-search-job-locat">
                                                    <p><i class="fa fa-money"></i><?php echo $job['pay']."/".$payScaleArray[$job['paytype']];?></p>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-3">
                                                <a href="job-detail.php?jid=<?php echo $job['jid'];?>&apply=1" class="btn advance-search" title="view">Apply</a>
                                            </div>
                                        </div>
                                        <!--<span class="tg-themetag tg-featuretag">Premium</span>-->
                                    </article>
                                    <?php
                                }
                                ?>
							</div>
						</div>
						
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
						
						<!-- Ad banner -->
						<!--<div class="row">
							<div class="ad-banner">
								<img src="http://via.placeholder.com/728x90" class="img-responsive" alt="">
							</div>
						</div>-->
					</div>
					
					<!-- Sidebar Start -->
					<!-- Sidebar End -->
					
				</div>
			</section>
			<!-- ========== Begin: Brows job Category End ===============  -->
			
			<!-- Footer Section Start -->
			<?php require('footer.php'); ?>
			<div class="clearfix"></div>
			<!-- Footer Section End -->
			
			<!-- Sign Up Window Code -->
            <?php
            require 'loginModal.php';
            ?>
			<!-- End Sign Up Window -->
			
			<!-- Apply Form Code -->
			<!-- End Apply Form -->
			
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
                function vf(){
                    var minPay = document.forms["searchForm"]["minPay"].value;
                    var maxPay = document.forms["searchForm"]["maxPay"].value;
                    if(minPay != "" && maxPay != ""){
                        if(minPay<=maxPay){
                            return true;
                        }
                        alert('Min pay must be less than max pay');
                        return false;
                    }
                    return true;
                }
            </script>
			
		</div>
	</body>

<!-- search-new41:42-->
</html>