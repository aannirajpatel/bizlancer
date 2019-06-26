<?php
require('includes/auth.php');
require('includes/db.php');
require('includes/constants.php');
require('includes/files.php');
$uid = $_SESSION['uid'];
$message = "";

if (!isset($_GET['jid'])) {
    header_remove();
    header("location:404.html");
    die();
}

$jid = $_GET['jid'];

if (!authenticateJobManager($con, $uid, $jid)) {
    header_remove();
    header("location:404.html");
}

$jobTitleQuery = "SELECT title FROM job WHERE jid=$jid";
$jobTitleResult = mysqli_query($con, $jobTitleQuery) or die(mysqli_error($con));
$jobTitleData = mysqli_fetch_array($jobTitleResult);
$jobTitle = $jobTitleData['title'];
?>

<!doctype html>
<html lang="en">

<!-- manage-candidate41:40-->
<head>
    <!-- Basic Page Needs
    ================================================== -->
    <title>Manage Candidates | BizLancer</title>
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
            <h1>Manage Candidate</h1>
            <h3>Job: <?php echo $jobTitle; ?></h3>
        </div>
    </section>
    <div class="clearfix"></div>
    <!-- Title Header End -->

    <!-- Member list start -->

        <div class="container">
            <ul class="nav nav-tabs nav-justified">
                <li class="active"><a data-toggle="tab" href="#t1"><h4>Applicants</h4></a></li>
                <li><a data-toggle="tab" href="#t2"><h4>Shortlists</h4></a></li>
                <li><a data-toggle="tab" href="#t3"><h4>Hired</h4></a></li>
                <li><a data-toggle="tab" href="#t4"><h4>Rejected</h4></a></li>
            </ul>

            <div class="tab-content">
                <div id="t1" class="tab-pane fade in active">
                    <!--<h3>Applicants</h3>-->
                    <div class="container padd-top-10">
                        <?php
                        $candidateQuery = "SELECT * FROM application WHERE jid=$jid AND status=" . CANDIDATE_APPLICANT;
                        $candidateResult = mysqli_query($con, $candidateQuery) or die("Error while running $candidateQuery" . mysqli_error($con));
                        if (mysqli_num_rows($candidateResult) == 0) {
                            ?>
                            <div class="container"><h4>No applicants to show here...</h4></div>
                            <?php
                        }
                        while ($candidateData = mysqli_fetch_array($candidateResult)) {
                            $candidateUid = $candidateData['uid'];
                            $userQuery = "SELECT * FROM user WHERE uid=$candidateUid";
                            $userResult = mysqli_query($con, $userQuery) or die("Error while running $userQuery" . mysqli_error($con));
                            $userData = mysqli_fetch_array($userResult)
                            ?>
                            <div class="item-click">
                                <article>
                                    <div class="brows-resume">
                                        <div class="row no-mrg">
                                            <div class="col-md-2 col-sm-2">
                                                <div class="brows-resume-pic">
                                                    <img src="<?php echo $userData['userimg']; ?>"
                                                         class="img-responsive" alt=""
                                                         style="max-height: 8rem;"/>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4">
                                                <div class="brows-resume-name">
                                                    <h4><?php echo $userData['name']; ?></h4>
                                                    <span class="brows-resume-designation"><?php $userData['designation']; ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4">
                                                <div class="brows-resume-location">
                                                    <ul>
                                                        <li>
                                                            <i class="fa fa-map-marker"></i> <?php echo $userData['location']; ?>
                                                        </li>
                                                        <?php
                                                        $educationQuery = "SELECT qualification, school,`end` FROM education WHERE uid=".$userData['uid']." ORDER BY `end` DESC LIMIT 1";
                                                        $educationResult = mysqli_query($con, $educationQuery) or die(mysqli_error($con));
                                                        if(mysqli_num_rows($educationResult)>0) {
                                                            $eduData = mysqli_fetch_array($educationResult);
                                                            ?>
                                                            <li>
                                                                <i class="fa fa-graduation-cap"></i> <?php echo $eduData['qualification']." from ".$eduData['school']."(".DateTime::createFromFormat('Y-m-d',$eduData['end'])->format('Y').")";?>
                                                            </li>
                                                            <?php
                                                        }
                                                        ?>
                                                    </ul>

                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-2">
                                                <div class="browse-resume-rate">
                                                    <span><i class="fa fa-money"></i><?php echo $userData['minpay'] . "-".$userData['maxpay']."/" . $payScaleArray[$userData['paytype']]; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row extra-mrg row-skill">
                                            <div class="browse-resume-skills">
                                                <div class="col-md-4 col-sm-4">
                                                    <div class="br-resume">
                                                        Top 3 Skills&nbsp;
                                                        <?php
                                                        $skillQuery = "SELECT * FROM skill WHERE uid=".$userData['uid']." LIMIT 3";
                                                        $skillResult = mysqli_query($con,$skillQuery) or die(mysqli_error($con));
                                                        if(mysqli_num_rows($skillResult)>0) {
                                                            while($skillData = mysqli_fetch_array($skillResult)) {
                                                                ?>
                                                                <span><?php echo $skillData['name']; ?></span>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-sm-8">
                                                    <a target="_blank" href="resume-detail.php?uid=<?php echo $candidateUid;?>&jid=<?php echo $jid;?>" class="browse-resume-exp bg-success" style="display: inline;">
                                                        <span class="resume-exp bg-success">View Resume</span>
                                                    </a>
                                                    <a  href="shortlist.php?uid=<?php echo $candidateUid;?>&jid=<?php echo $jid;?>" " class="browse-resume-exp bg-primary" style="display: inline;">
                                                    <span class="resume-exp bg-primary">Shortlist</span>
                                                    </a>
                                                    <a href="chat-with-user.php?user=<?php echo $candidateUid;?>" class="browse-resume-exp bg-warning" style="display: inline">
                                                        <span class="resume-exp bg-warning">Message</span>
                                                    </a>
                                                    <a href="reject.php?uid=<?php echo $candidateUid;?>&jid=<?php echo $jid;?>" class="browse-resume-exp bg-danger" style="display: inline;">
                                                        <span class="resume-exp bg-danger">Reject</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <?php

                        }
                        ?>
                    </div>
                </div>
                <div id="t2" class="tab-pane fade in active">
                    <!--<h3>Applicants</h3>-->
                    <div class="container padd-top-10">
                        <?php
                        $candidateQuery = "SELECT * FROM application WHERE jid=$jid AND status=" . CANDIDATE_SHORTLIST;
                        $candidateResult = mysqli_query($con, $candidateQuery) or die("Error while running $candidateQuery" . mysqli_error($con));
                        if (mysqli_num_rows($candidateResult) == 0) {
                            ?>
                            <div class="container"><h4>No applicants to show here...</h4></div>
                            <?php
                        }
                        while ($candidateData = mysqli_fetch_array($candidateResult)) {
                            $candidateUid = $candidateData['uid'];
                            $userQuery = "SELECT * FROM user WHERE uid=$candidateUid";
                            $userResult = mysqli_query($con, $userQuery) or die("Error while running $userQuery" . mysqli_error($con));
                            $userData = mysqli_fetch_array($userResult)
                            ?>
                            <div class="item-click">
                                <article>
                                    <div class="brows-resume">
                                        <div class="row no-mrg">
                                            <div class="col-md-2 col-sm-2">
                                                <div class="brows-resume-pic">
                                                    <img src="<?php echo $userData['userimg']; ?>"
                                                         class="img-responsive" alt=""
                                                         style="max-height: 8rem;"/>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4">
                                                <div class="brows-resume-name">
                                                    <h4><?php echo $userData['name']; ?></h4>
                                                    <span class="brows-resume-designation"><?php $userData['designation']; ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4">
                                                <div class="brows-resume-location">
                                                    <ul>
                                                        <li>
                                                            <i class="fa fa-map-marker"></i> <?php echo $userData['location']; ?>
                                                        </li>
                                                        <?php
                                                        $educationQuery = "SELECT qualification, school,`end` FROM education WHERE uid=".$userData['uid']." ORDER BY `end` DESC LIMIT 1";
                                                        $educationResult = mysqli_query($con, $educationQuery) or die(mysqli_error($con));
                                                        if(mysqli_num_rows($educationResult)>0) {
                                                            $eduData = mysqli_fetch_array($educationResult);
                                                            ?>
                                                            <li>
                                                                <i class="fa fa-graduation-cap"></i> <?php echo $eduData['qualification']." from ".$eduData['school']."(".DateTime::createFromFormat('Y-m-d',$eduData['end'])->format('Y').")";?>
                                                            </li>
                                                            <?php
                                                        }
                                                        ?>
                                                    </ul>

                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-2">
                                                <div class="browse-resume-rate">
                                                    <span><i class="fa fa-money"></i><?php echo $userData['minpay'] . "-".$userData['maxpay']."/" . $payScaleArray[$userData['paytype']]; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row extra-mrg row-skill">
                                            <div class="browse-resume-skills">
                                                <div class="col-md-4 col-sm-4">
                                                    <div class="br-resume">
                                                        Top 3 Skills&nbsp;
                                                        <?php
                                                        $skillQuery = "SELECT * FROM skill WHERE uid=".$userData['uid']." LIMIT 3";
                                                        $skillResult = mysqli_query($con,$skillQuery) or die(mysqli_error($con));
                                                        if(mysqli_num_rows($skillResult)>0) {
                                                            while($skillData = mysqli_fetch_array($skillResult)) {
                                                                ?>
                                                                <span><?php echo $skillData['name']; ?></span>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-sm-8">
                                                    <a target="_blank" href="resume-detail.php?uid=<?php echo $candidateUid;?>&jid=<?php echo $jid;?>" class="browse-resume-exp bg-success" style="display: inline;">
                                                        <span class="resume-exp bg-success">View Resume</span>
                                                    </a>
                                                    <a  href="hire.php?uid=<?php echo $candidateUid;?>&jid=<?php echo $jid;?>" " class="browse-resume-exp bg-primary" style="display: inline;">
                                                    <span class="resume-exp bg-primary">Hire</span>
                                                    </a>
                                                    <a href="chat-with-user.php?user=<?php echo $candidateUid;?>" class="browse-resume-exp bg-warning" style="display: inline">
                                                        <span class="resume-exp bg-warning">Message</span>
                                                    </a>
                                                    <a href="reject.php?uid=<?php echo $candidateUid;?>&jid=<?php echo $jid;?>" class="browse-resume-exp bg-danger" style="display: inline;">
                                                        <span class="resume-exp bg-danger">Reject</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <?php

                        }
                        ?>
                    </div>
                </div>
                <div id="t3" class="tab-pane fade in active">
                    <!--<h3>Applicants</h3>-->
                    <div class="container padd-top-10">
                        <?php
                        $candidateQuery = "SELECT * FROM application WHERE jid=$jid AND status=" . CANDIDATE_HIRED;
                        $candidateResult = mysqli_query($con, $candidateQuery) or die("Error while running $candidateQuery" . mysqli_error($con));
                        if (mysqli_num_rows($candidateResult) == 0) {
                            ?>
                            <div class="container"><h4>No applicants to show here...</h4></div>
                            <?php
                        }
                        while ($candidateData = mysqli_fetch_array($candidateResult)) {
                            $candidateUid = $candidateData['uid'];
                            $userQuery = "SELECT * FROM user WHERE uid=$candidateUid";
                            $userResult = mysqli_query($con, $userQuery) or die("Error while running $userQuery" . mysqli_error($con));
                            $userData = mysqli_fetch_array($userResult)
                            ?>
                            <div class="item-click">
                                <article>
                                    <div class="brows-resume">
                                        <div class="row no-mrg">
                                            <div class="col-md-2 col-sm-2">
                                                <div class="brows-resume-pic">
                                                    <img src="<?php echo $userData['userimg']; ?>"
                                                         class="img-responsive" alt=""
                                                         style="max-height: 8rem;"/>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4">
                                                <div class="brows-resume-name">
                                                    <h4><?php echo $userData['name']; ?></h4>
                                                    <span class="brows-resume-designation"><?php $userData['designation']; ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4">
                                                <div class="brows-resume-location">
                                                    <ul>
                                                        <li>
                                                            <i class="fa fa-map-marker"></i> <?php echo $userData['location']; ?>
                                                        </li>
                                                        <?php
                                                        $educationQuery = "SELECT qualification, school,`end` FROM education WHERE uid=".$userData['uid']." ORDER BY `end` DESC LIMIT 1";
                                                        $educationResult = mysqli_query($con, $educationQuery) or die(mysqli_error($con));
                                                        if(mysqli_num_rows($educationResult)>0) {
                                                            $eduData = mysqli_fetch_array($educationResult);
                                                            ?>
                                                            <li>
                                                                <i class="fa fa-graduation-cap"></i> <?php echo $eduData['qualification']." from ".$eduData['school']."(".DateTime::createFromFormat('Y-m-d',$eduData['end'])->format('Y').")";?>
                                                            </li>
                                                            <?php
                                                        }
                                                        ?>
                                                    </ul>

                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-2">
                                                <div class="browse-resume-rate">
                                                    <span><i class="fa fa-money"></i><?php echo $userData['minpay'] . "-".$userData['maxpay']."/" . $payScaleArray[$userData['paytype']]; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row extra-mrg row-skill">
                                            <div class="browse-resume-skills">
                                                <div class="col-md-4 col-sm-4">
                                                    <div class="br-resume">
                                                        Top 3 Skills&nbsp;
                                                        <?php
                                                        $skillQuery = "SELECT * FROM skill WHERE uid=".$userData['uid']." LIMIT 3";
                                                        $skillResult = mysqli_query($con,$skillQuery) or die(mysqli_error($con));
                                                        if(mysqli_num_rows($skillResult)>0) {
                                                            while($skillData = mysqli_fetch_array($skillResult)) {
                                                                ?>
                                                                <span><?php echo $skillData['name']; ?></span>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-sm-8">
                                                    <a target="_blank" href="resume-detail.php?uid=<?php echo $candidateUid;?>&jid=<?php echo $jid;?>" class="browse-resume-exp bg-success" style="display: inline;">
                                                        <span class="resume-exp bg-success">View Resume</span>
                                                    </a>
                                                    <a  href="shortlist.php?uid=<?php echo $candidateUid;?>&jid=<?php echo $jid;?>" " class="browse-resume-exp bg-primary" style="display: inline;">
                                                    <span class="resume-exp bg-primary">Shortlist</span>
                                                    </a>
                                                    <a href="chat-with-user.php?user=<?php echo $candidateUid;?>" class="browse-resume-exp bg-warning" style="display: inline">
                                                        <span class="resume-exp bg-warning">Message</span>
                                                    </a>
                                                    <a href="reject.php?uid=<?php echo $candidateUid;?>&jid=<?php echo $jid;?>" class="browse-resume-exp bg-danger" style="display: inline;">
                                                        <span class="resume-exp bg-danger">Reject</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <?php

                        }
                        ?>
                    </div>
                </div>
                <div id="t4" class="tab-pane fade in active">
                    <!--<h3>Applicants</h3>-->
                    <div class="container padd-top-10">
                        <?php
                        $candidateQuery = "SELECT * FROM application WHERE jid=$jid AND status=" . CANDIDATE_REJECTED;
                        $candidateResult = mysqli_query($con, $candidateQuery) or die("Error while running $candidateQuery" . mysqli_error($con));
                        if (mysqli_num_rows($candidateResult) == 0) {
                            ?>
                            <div class="container"><h4>No applicants to show here...</h4></div>
                            <?php
                        }
                        while ($candidateData = mysqli_fetch_array($candidateResult)) {
                            $candidateUid = $candidateData['uid'];
                            $userQuery = "SELECT * FROM user WHERE uid=$candidateUid";
                            $userResult = mysqli_query($con, $userQuery) or die("Error while running $userQuery" . mysqli_error($con));
                            $userData = mysqli_fetch_array($userResult)
                            ?>
                            <div class="item-click">
                                <article>
                                    <div class="brows-resume">
                                        <div class="row no-mrg">
                                            <div class="col-md-2 col-sm-2">
                                                <div class="brows-resume-pic">
                                                    <img src="<?php echo $userData['userimg']; ?>"
                                                         class="img-responsive" alt=""
                                                         style="max-height: 8rem;"/>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4">
                                                <div class="brows-resume-name">
                                                    <h4><?php echo $userData['name']; ?></h4>
                                                    <span class="brows-resume-designation"><?php $userData['designation']; ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4">
                                                <div class="brows-resume-location">
                                                    <ul>
                                                        <li>
                                                            <i class="fa fa-map-marker"></i> <?php echo $userData['location']; ?>
                                                        </li>
                                                        <?php
                                                        $educationQuery = "SELECT qualification, school,`end` FROM education WHERE uid=".$userData['uid']." ORDER BY `end` DESC LIMIT 1";
                                                        $educationResult = mysqli_query($con, $educationQuery) or die(mysqli_error($con));
                                                        if(mysqli_num_rows($educationResult)>0) {
                                                            $eduData = mysqli_fetch_array($educationResult);
                                                            ?>
                                                            <li>
                                                                <i class="fa fa-graduation-cap"></i> <?php echo $eduData['qualification']." from ".$eduData['school']."(".DateTime::createFromFormat('Y-m-d',$eduData['end'])->format('Y').")";?>
                                                            </li>
                                                            <?php
                                                        }
                                                        ?>
                                                    </ul>

                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-2">
                                                <div class="browse-resume-rate">
                                                    <span><i class="fa fa-money"></i><?php echo $userData['minpay'] . "-".$userData['maxpay']."/" . $payScaleArray[$userData['paytype']]; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row extra-mrg row-skill">
                                            <div class="browse-resume-skills">
                                                <div class="col-md-4 col-sm-4">
                                                    <div class="br-resume">
                                                        Top 3 Skills&nbsp;
                                                        <?php
                                                        $skillQuery = "SELECT * FROM skill WHERE uid=".$userData['uid']." LIMIT 3";
                                                        $skillResult = mysqli_query($con,$skillQuery) or die(mysqli_error($con));
                                                        if(mysqli_num_rows($skillResult)>0) {
                                                            while($skillData = mysqli_fetch_array($skillResult)) {
                                                                ?>
                                                                <span><?php echo $skillData['name']; ?></span>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-sm-8">
                                                    <a target="_blank" href="resume-detail.php?uid=<?php echo $candidateUid;?>&jid=<?php echo $jid;?>" class="browse-resume-exp bg-success" style="display: inline;">
                                                        <span class="resume-exp bg-success">View Resume</span>
                                                    </a>
                                                    <a  href="shortlist.php?uid=<?php echo $candidateUid;?>&jid=<?php echo $jid;?>" " class="browse-resume-exp bg-primary" style="display: inline;">
                                                    <span class="resume-exp bg-primary">Shortlist</span>
                                                    </a>
                                                    <a href="chat-with-user.php?user=<?php echo $candidateUid;?>" class="browse-resume-exp bg-warning" style="display: inline">
                                                        <span class="resume-exp bg-warning">Message</span>
                                                    </a>
                                                    <a href="reject.php?uid=<?php echo $candidateUid;?>&jid=<?php echo $jid;?>" class="browse-resume-exp bg-danger" style="display: inline;">
                                                        <span class="resume-exp bg-danger">Reject</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <?php

                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

    <!-- Member List End -->

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
    <script>
        $(document).ready(function(){
            activaTab('t1');
            activaTab('t2');
            activaTab('t1');
        });

        function activaTab(tab){
            $('.nav-tabs a[href="#' + tab + '"]').tab('show');
        };
    </script>
</div>
</body>

<!-- manage-candidate41:40-->
</html>