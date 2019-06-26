<?php
require('includes/auth.php');
require('includes/db.php');
require('includes/constants.php');
require('includes/files.php');
$uid = $_SESSION['uid'];
if(isset($_GET['uid'])){
    $candidateUid = $_GET['uid'];
} else{
    $candidateUid = $uid;
}
$userInfo = mysqli_query($con, "SELECT * FROM user WHERE uid=$candidateUid");
$userInfo = mysqli_fetch_array($userInfo);
$userImg = $userInfo['userimg'];
$name = $userInfo['name'];
//contact info
$brief = $userInfo['brief'];
$resume = $userInfo['resume'];
$category = $userInfo['category'];
$designation = $userInfo['designation'];
$totalexp = $userInfo['experience'];
$email = $userInfo['email'];
$phone = $userInfo['phone'];
$location = $userInfo['location'];
$website = $userInfo['website'];
$birthdate = $userInfo['birthdate'];
$birthdate = DateTime::createFromFormat('Y-m-d', $birthdate);
$birthdate = $birthdate->format('m/d/Y');
$country = $userInfo['country'];
//Socials
$fb = $userInfo['facebook'];
$gp = $userInfo['gplus'];
$tw = $userInfo['twitter'];
$insta = $userInfo['instagram'];
$lin = $userInfo['linkedin'];
$drib = $userInfo['dribble'];
//Freelance info
$freelancer = $userInfo['freelancer'];
$minPay = $userInfo['minpay'];
$maxPay = $userInfo['maxpay'];
$paytype = $userInfo['paytype'];
$payscale = $payScaleArray[$paytype];
//Education: eduid, uid,school, qualification, start, end, notes
$edu = mysqli_query($con, "SELECT * FROM education WHERE uid=$candidateUid") or die(mysqli_error($con));
//Experience: expid, uid,employer,position,start,end, notes
$exp = mysqli_query($con, "SELECT * FROM experience WHERE uid=$candidateUid") or die(mysqli_error($con));
//Skill: skillid,name,strength
$skill = mysqli_query($con, "SELECT * FROM skill WHERE uid=$candidateUid") or die(mysqli_error($con));
?>
<!doctype html>
<html lang="en">

<!-- resume-detail41:26-->
<head>
    <!-- Basic Page Needs
    ================================================== -->
    <title>View Resume | BizLancer</title>
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
            <h1>Resume Detail</h1>
        </div>
    </section>
    <div class="clearfix"></div>
    <!-- Title Header End -->

    <!-- Resume Detail Start -->
    <section class="detail-desc">
        <div class="container white-shadow">
            <div class="row mrg-0">
                <div class="detail-pic">
                    <img src="<?php echo $userImg; ?>" class="img" alt=""/>
                    <?php if($uid==$candidateUid){?>
                    <a href="manage-profile.php" class="detail-edit" title="edit"><i class="fa fa-pencil"></i></a>
                    <?php } ?>
                </div>
                <!--
                <div class="detail-status">
                    <span>7 Hour Days Ago</span>
                </div>-->
            </div>
            <div class="row bottom-mrg mrg-0">
                <div class="col-md-8 col-sm-8">
                    <div class="detail-desc-caption">
                        <h4><?php echo $name;?></h4>
                        <span class="designation"><?php echo $designation;?></span>
                        <p style="text-transform: none;"><?php echo $brief;?></p>
                    </div>
                    <div class="detail-desc-skill">
                        <?php while($skilldata = mysqli_fetch_array($skill)) {
                            ?>
                            <span><?php echo $skilldata['name'];?></span>
                            <?php
                        }
                        $skill = mysqli_query($con,"SELECT * FROM skill WHERE uid=$candidateUid") or die("Error in skill fetcher".mysqli_error($con));
                        ?>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="get-touch">
                        <h4>Get in Touch</h4>
                        <ul>
                            <li><i class="fa fa-map-marker"></i><span><?php echo $location; ?></span></li>
                            <li><i class="fa fa-envelope"></i><span><?php echo $email; ?></span></li>
                            <li><i class="fa fa-phone"></i><span><?php echo $phone; ?></span></li>
                            <?php if ($freelancer == 1) { ?>
                                <li>
                                    <i class="fa fa-money"></i><span><?php echo "₹" . $maxPay . " to " . $minPay . "/" . $payscale ?></span>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row no-padd mrg-0">
                <div class="detail pannel-footer">
                    <div class="col-md-5 col-sm-5">
                        <ul class="detail-footer-social">
                            <li><a href="<?php echo $fb; ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="<?php echo $gp; ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                            <li><a href="<?php echo $tw; ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="<?php echo $lin; ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="<?php echo $insta; ?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
                            <li><a href="<?php echo $drib; ?>" target="_blank"><i class="fa fa-dribbble"></i></a></li>
                        </ul>
                    </div>
                    <div class="col-md-7 col-sm-7">
                        <div class="detail-pannel-footer-btn pull-right">
                            <?php if($candidateUid!=$uid){?>
                            <a href="chat-with-user.php?uid=<?php echo $candidateUid;?>" class="footer-btn grn-btn" title="">Message to Hire</a>
                            <?php } ?>
                            <?php if($candidateUid==$uid){?>
                            <a href="manage-profile.php" class="footer-btn blu-btn" title="">Edit</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Resume Detail End -->

    <section class="full-detail-description full-detail">
        <div class="container">

            <div class="row row-bottom mrg-0">
                <h2 class="detail-title">About Resume</h2>
                <p><?php echo $userInfo['resume']; ?></p>
            </div>

            <div class="row row-bottom mrg-0">
                <h2 class="detail-title">Education</h2>
                <!--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                    et dolore magna aliqua.</p>-->
                <ul class="detail-list">
                    <?php
                    while ($edudata = mysqli_fetch_array($edu)) {
                        $start = DateTime::createFromFormat('Y-m-d', $edudata['start']);
                        $start = $start->format('M d, Y');
                        $end = DateTime::createFromFormat('Y-m-d', $edudata['end']);
                        $end = $end->format('M d, Y');
                        ?>
                        <li><?php echo $edudata['qualification']; ?> from <?php echo $edudata['school']; ?>
                            (<?php echo $start; ?> to <?php echo $end; ?>)
                        </li>
                        <p><?php echo $edudata['notes']; ?></p>
                        <?php
                    }
                    ?>
                </ul>
            </div>
            <div class="row row-bottom mrg-0">
                <h2 class="detail-title">Work Experience</h2>
                <!--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                    et dolore magna aliqua.</p>-->
                <ul class="detail-list">
                    <?php
                    while ($expdata = mysqli_fetch_array($exp)) {
                        $start = DateTime::createFromFormat('Y-m-d', $expdata['start']);
                        $start = $start->format('M d, Y');
                        $end = DateTime::createFromFormat('Y-m-d', $expdata['end']);
                        $end = $end->format('M d, Y');
                        ?>
                        <li><?php echo $expdata['position']; ?> at <?php echo $expdata['employer']; ?>
                            (<?php echo $start; ?> to <?php echo $end; ?>)
                        </li>
                        <p><?php echo $expdata['notes']; ?></p>
                        <?php
                    }
                    ?>

                </ul>
            </div>

            <div class="row row-bottom mrg-0">
                <h2 class="detail-title">Skills</h2>
                <!--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>-->
                <div class="ext-mrg row third-progress">
                    <?php
                    while ($skilldata = mysqli_fetch_array($skill)) {
                        ?>
                        <div class="col-md-6 col-sm-6">
                            <div class="panel-body">
                                <h3 class="progressbar-title"><?php echo $skilldata['name']; ?></h3>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 90%; background: #07b107;">
                                        <span class="progress-icon fa fa-plus"
                                              style="border-color:#07b107; color:#07b107;"></span>
                                        <div class="progress-value"><?php echo $skilldata['strength']; ?>%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>

        </div>
    </section>

    <!-- Footer Section Start -->
    <?php
    require 'footer.php';
    ?>
    <div class="clearfix"></div>
    <!-- Footer Section End -->


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
    <script src="assets/js/jQuery.style.switcher.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#styleOptions').styleSwitcher();
        });
    </script>
    <script>
        function openRightMenu() {
            document.getElementById("rightMenu").style.display = "block";
        }

        function closeRightMenu() {
            document.getElementById("rightMenu").style.display = "none";
        }
    </script>
</div>
</body>

<!-- resume-detail41:26-->
</html>