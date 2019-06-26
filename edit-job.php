<?php
require('includes/auth.php');
require('includes/db.php');
require('includes/constants.php');
require('includes/files.php');
$uid = $_SESSION['uid'];
$message = "";
if(!isset($_GET['jid'])){
    header_remove();
    header("location:404.php");
}
$jid = intval(mysqli_real_escape_string($con, $_GET['jid']));
$cidQuery = "SELECT cid FROM company WHERE cid=$uid";
$cidResult = mysqli_query($con, $cidQuery) or die(mysqli_error($con));
$jobData = array();
if(mysqli_num_rows($cidResult)==0){
    $message = "Please create your company profile from <a href='manage-company-profile.php'>here</a> first, in order to add a job listing";
} else {
    $cidData = mysqli_fetch_array($cidResult);
    $cid = $cidData['cid'];
    $jobQuery = "SELECT * FROM job WHERE jid=$jid AND cid=$cid";
    $jobResult = mysqli_query($con, $jobQuery) or die(mysqli_error($con));
    $title = ""; $pay = ""; $selectedPayType = PAY_PER_MONTH; $selectedJobType = -1;
    $location  =""; $requirements = "";$startdate = ""; $enddate = "";
    if(mysqli_num_rows($jobResult)==0){
        $message="Unable to find the job for editing.";
    } else{
        $jobData = mysqli_fetch_array($jobResult);
        $title = $jobData['title']; $pay = $jobData['pay']; $selectedPayType = $jobData['paytype']; $selectedJobType = $jobData['jobtype'];
        $location  =$jobData['location']; $requirements = $jobData['requirements'];$startdate = $jobData['startdate']; $enddate = $jobData['enddate'];
    }
}
if(isset($_POST['addJob']) && $message==""){
    $cidQuery = "SELECT cid FROM company WHERE cid=$uid";
    $cidResult = mysqli_query($con, $cidQuery) or die(mysqli_error($con));
    if(mysqli_num_rows($cidResult)==0){
        $message = "Please create your company profile from <a href='manage-company-profile.php'>here</a> first, in order to add a job listing";
    } else {
        $cidData = mysqli_fetch_array($cidResult);
        $cid = $cidData['cid'];
        $title = mysqli_real_escape_string($con, $_POST['title']);
        $pay = mysqli_real_escape_string($con, $_POST['pay']);
        $paytype = mysqli_real_escape_string($con, $_POST['paytype']);
        $jobtype = mysqli_real_escape_string($con, $_POST['jobtype']);
        $location = mysqli_real_escape_string($con, $_POST['location']);
        $requirements = mysqli_real_escape_string($con, $_POST['requirements']);
        $startdate = mysqli_real_escape_string($con, $_POST['startdate']);
        $enddate = mysqli_real_escape_string($con, $_POST['enddate']);
        $newJobQuery = "UPDATE job SET cid=$cid,title='$title',pay=$pay,paytype=$paytype,jobtype=$jobtype,location='$location',requirements='$requirements',startdate='$startdate',enddate='$enddate' WHERE jid=$jid";
        $newJobResult = mysqli_query($con, $newJobQuery) or die(mysqli_error($con));
        header("location:manage-job-listings.php");
    }
}

?>
<!doctype html>
<html lang="en">

<!-- create-job41:39-->
<head>
    <!-- Basic Page Needs
    ================================================== -->
    <title>Edit Job Listing</title>
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

    <!-- Header Title Start -->
    <section class="inner-header-title blank">
        <?php
        if($message!=""){
            ?>
            <div class="alert alert-dismissible alert-warning"><?php echo $message;?></div>
            <?php
        }
        ?>
        <div class="container">
            <h1>Edit Job Listing</h1>
        </div>
    </section>
    <div class="clearfix"></div>
    <!-- Header Title End -->

    <!-- General Detail Start -->
    <div class="detail-desc section">
        <div class="container white-shadow">

            <!--<div class="row">
                <div class="detail-pic js">
                    <div class="box">
                        <input type="file" name="upload-pic[]" id="upload-pic" class="inputfile" />
                        <label for="upload-pic"><i class="fa fa-upload" aria-hidden="true"></i><span></span></label>
                    </div>
                </div>
            </div>-->
            <?php
            if($message=="") {
                ?>
                <div class="row bottom-mrg" style="margin-top: 2rem;">
                    <form class="add-feild" method="post" action="">
                        <div class="col-md-6 col-sm-6">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Job Title" name="title" value="<?php echo $title;?>">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <input type="number" class="form-control" placeholder="Payment Amount (₹)" name="pay" value="<?php echo $pay;?>">
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <select class="form-control" name="paytype">
                                <option <?php if($selectedPayType==PAY_PER_YEAR){ echo "selected";}?> value="<?php echo PAY_PER_YEAR; ?>" <?php ?>>Per Year</option>
                                <option <?php if($selectedPayType==PAY_PER_MONTH){ echo "selected";}?> value="<?php echo PAY_PER_MONTH; ?>" <?php ?>>Per Month (Recommended for FT, PT
                                    & Intern)
                                </option>
                                <option <?php if($selectedPayType==PAY_PER_WEEK){ echo "selected";}?> value="<?php echo PAY_PER_WEEK; ?>">Per Week</option>
                                <option <?php if($selectedPayType==PAY_PER_DAY){ echo "selected";}?> value="<?php echo PAY_PER_DAY; ?>">Per Day (Recommended for Hiring
                                    Freelancers)
                                </option>
                                <option <?php if($selectedPayType==PAY_PER_HOUR){ echo "selected";}?> value="<?php echo PAY_PER_HOUR; ?>">Per Hour</option>
                            </select>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="input-group">
                                <select class="form-control input-lg" name="jobtype">
                                    <option <?php if($selectedJobType==-1){ echo "selected";}?> disabled>Job Type</option>
                                    <option <?php if($selectedJobType==JOB_TYPE_FULLTIME){ echo "selected";}?> value="<?php echo JOB_TYPE_FULLTIME; ?>">Full Time</option>
                                    <option <?php if($selectedJobType==JOB_TYPE_PARTTIME){ echo "selected";}?> value="<?php echo JOB_TYPE_PARTTIME; ?>">Part Time</option>
                                    <option <?php if($selectedJobType==JOB_TYPE_FREELANCER){ echo "selected";}?> value="<?php echo JOB_TYPE_FREELANCER; ?>">Freelancer</option>
                                    <option <?php if($selectedJobType==JOB_TYPE_INTERNSHIP){ echo "selected";}?> value="<?php echo JOB_TYPE_INTERNSHIP; ?>">Internship</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Location, e.g. Mumbai"
                                       name="location" value="<?php echo $location;?>">
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="input-group">
                                <label for="startdate">Listing enable date</label>
                                <input type="date" id="startdate" class="form-control" name="startdate" value="<?php echo $startdate;?>">
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="input-group">
                                <label for="enddate">Listing expiry date</label>
                                <input type="date" id="enddate" class="form-control" name="enddate" value="<?php echo $enddate;?>">
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12">
                            <textarea class="form-control textarea" placeholder="Job Requirements"
                                      name="requirements"><?php echo $requirements;?></textarea>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <button class="btn btn-success btn-primary small-btn" type="submit" name="addJob">Publish
                                Job Listing
                            </button>
                        </div>

                    </form>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <!-- General Detail End -->

    <!-- Footer Section Start -->
    <?php
    require 'footer.php';
    ?>
    <div class="clearfix"></div>
    <!-- Footer Section End -->

    <!-- Sign Up Window Code -->
    <div class="modal fade" id="signup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="tab" role="tabpanel">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#login" role="tab" data-toggle="tab">Sign
                                    In</a></li>
                            <li role="presentation"><a href="#register" role="tab" data-toggle="tab">Sign Up</a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content" id="myModalLabel2">
                            <div role="tabpanel" class="tab-pane fade in active" id="login">
                                <img src="assets/img/logo.png" class="img-responsive" alt=""/>
                                <div class="subscribe wow fadeInUp">
                                    <form class="form-inline" method="post">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <input type="email" name="email" class="form-control"
                                                       placeholder="Username" required="">
                                                <input type="password" name="password" class="form-control"
                                                       placeholder="Password" required="">
                                                <div class="center">
                                                    <button type="submit" id="login-btn" class="submit-btn"> Login
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="register">
                                <img src="assets/img/logo.png" class="img-responsive" alt=""/>
                                <form class="form-inline" method="post">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <input type="text" name="email" class="form-control" placeholder="Your Name"
                                                   required="">
                                            <input type="email" name="email" class="form-control"
                                                   placeholder="Your Email" required="">
                                            <input type="email" name="email" class="form-control" placeholder="Username"
                                                   required="">
                                            <input type="password" name="password" class="form-control"
                                                   placeholder="Password" required="">
                                            <div class="center">
                                                <button type="submit" id="subscribe" class="submit-btn"> Create
                                                    Account
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    <!--<script type="text/javascript" src="assets/plugins/js/datedropper.min.js"></script>-->
    <script type="text/javascript" src="assets/plugins/js/dropzone.js"></script>
    <script type="text/javascript" src="assets/plugins/js/loader.js"></script>
    <script type="text/javascript" src="assets/plugins/js/owl.carousel.min.js"></script>
    <script type="text/javascript" src="assets/plugins/js/slick.min.js"></script>
    <script type="text/javascript" src="assets/plugins/js/gmap3.min.js"></script>
    <script type="text/javascript" src="assets/plugins/js/jquery.easy-autocomplete.min.js"></script>
    <!-- Date dropper js-->
    <script>/*
        function getFormattedDate(date) {
            var year = date.getFullYear();

            var month = (1 + date.getMonth()).toString();
            month = month.length > 1 ? month : '0' + month;

            var day = date.getDate().toString();
            day = day.length > 1 ? day : '0' + day;

            return month + '/' + day + '/' + year;
        }
        var now = new Date();
        var onemonthlater = new Date(now.setMonth(now.getMonth()+1));
        document.getElementById('startdate').setAttribute('data-dd-default-date', getFormattedDate(now));
        document.getElementById('enddate').setAttribute('data-dd-default-date', getFormattedDate(onemonthlater));*/
    </script>
    <!-- Custom Js -->
    <script src="assets/js/custom.js"></script>



</div>
</body>

<!-- create-job41:40-->
</html>