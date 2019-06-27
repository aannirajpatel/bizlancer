<?php
require('includes/db.php');
require 'includes/files.php';
require 'includes/constants.php';
session_start();
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Basic Page Needs==================================================-->
    <title>BizLancer | The Ultimate Freelance and Job Finding Site</title>
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
    <?php require('header.php'); ?>
    <div class="clearfix"></div>
    <div class="banner" style="background-image:url(assets/img/banner-9.jpg);">
        <div class="container">
            <div class="banner-caption">
                <div class="col-md-12 col-sm-12 banner-text">
                    <?php
                    if(isset($_SESSION['uid']) && getUserTypeFromTable($con,$_SESSION['uid']) == USER_COMPANY) {
                        ?>
                        <h1>Browse 7,000+ Freelancers</h1>
                        <form class="form-horizontal" method="get" action="find-freelancer.php">
                            <div class="col-md-9 no-padd">
                                <div class="input-group">
                                    <input type="text" class="form-control right-bor" id="joblist" placeholder="Search for skills and designations in freelancers and candidates" name="q">
                                </div>
                            </div>
                            <div class="col-md-3 no-padd">
                                <div class="input-group">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </form>
                        <?php
                    } else {
                        ?>
                        <h1>Browse 7,000+ Jobs</h1>
                        <form class="form-horizontal" id="search-job-form" name="searchJobForm" method="get" action="search-job.php" onsubmit="return verifyJobSearch();">
                            <div class="col-md-4 no-padd">
                                <div class="input-group">
                                    <input type="text" class="form-control right-bor" id="joblist"
                                           placeholder="Skills, Designations, Companies" name="q">
                                </div>
                            </div>
                            <div class="col-md-3 no-padd">
                                <div class="input-group">
                                    <input type="text"  class="form-control" name="location" placeholder="Pick a location">
                                </div>
                            </div>
                            <div class="col-md-3 no-padd">
                                <div class="input-group">
                                    <select id="choose-job-type" class="form-control" name="jobtype">
                                        <option value="" selected disabled>Choose Job Type</option>
                                        <option value="<?php echo JOB_TYPE_INTERNSHIP;?>">Internship</option>
                                        <option value="<?php echo JOB_TYPE_FREELANCER;?>">Freelance</option>
                                        <option value="<?php echo JOB_TYPE_FULLTIME;?>">Full Time</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 no-padd">
                                <div class="input-group">
                                    <button type="submit" class="btn btn-primary">Search Job</button>
                                </div>
                            </div>
                        </form>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="company-brand" id="companyCarousel">
            <div class="container">
                <div id="company-brands" class="owl-carousel">
                    <div class="brand-img"><img src="assets/img/microsoft-home.png" class="img-responsive" alt=""/>
                    </div>
                    <div class="brand-img"><img src="assets/img/img-home.png" class="img-responsive" alt=""/></div>
                    <div class="brand-img"><img src="assets/img/mothercare-home.png" class="img-responsive" alt=""/>
                    </div>
                    <div class="brand-img"><img src="assets/img/paypal-home.png" class="img-responsive" alt=""/>
                    </div>
                    <div class="brand-img"><img src="assets/img/serv-home.png" class="img-responsive" alt=""/></div>
                    <div class="brand-img"><img src="assets/img/xerox-home.png" class="img-responsive" alt=""/>
                    </div>
                    <div class="brand-img"><img src="assets/img/yahoo-home.png" class="img-responsive" alt=""/>
                    </div>
                    <div class="brand-img"><img src="assets/img/mothercare-home.png" class="img-responsive" alt=""/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <section>
        <div class="container">
            <div class="row">
                <div class="main-heading">
                    <p>200 New Jobs</p>

                    <h2>New & Random <span>Jobs</span></h2>
                </div>
            </div>
            <div class="row extra-mrg">
                <?php
                $jobQuery = "SELECT company.cimg, job.jid, job.title, job.jobtype, job.location, job.pay, job.paytype FROM job, company WHERE job.cid = company.cid ORDER BY startdate DESC LIMIT 8";
                $jobResult = mysqli_query($con, $jobQuery) or die(mysqli_error($con));
                while($jobData = mysqli_fetch_array($jobResult)){
                ?>
                <div class="col-md-3 col-sm-6">
                    <div class="grid-view brows-job-list">
                        <div class="brows-job-company-img"><img src="<?php echo $jobData['cimg'];?>" class="img-responsive"
                                                                alt=""/></div>
                        <div class="brows-job-position">
                            <h3><a href="job-detail.php?jid=<?php echo $jobData['jid'];?>"><?php echo $jobData['title'];?></a></h3>

                            <p><span>Google</span></p>
                        </div>
                        <div class="brows-job-type"><span class="<?php echo $jobTypeDesignArray[$jobData['jobtype']];?>"><?php echo $jobTypeArray[$jobData['jobtype']];?></span></div>
                        <ul class="grid-view-caption">
                            <li>
                                <div class="brows-job-location">
                                    <p><i class="fa fa-map-marker"></i><?php echo $jobData['location'];?></p>
                                </div>
                            </li>
                            <li>
                                <p><span class="brows-job-sallery"><i class="fa fa-money"></i>₹<?php echo $jobData['pay'];?>/<?php echo $payScaleArray[$jobData['paytype']];?></span></p>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </section>
    <div class="clearfix"></div>
    <section class="video-sec dark" id="video" style="background-image:url(assets/img/banner-10.jpg);">
        <div class="container">
            <div class="row">
                <div class="main-heading">
                    <p>Best For Your Projects</p>

                    <h2>Watch Our <span>video</span></h2>
                </div>
            </div>
            <div class="video-part"><a href="#" data-toggle="modal" data-target="#my-video" class="video-btn"><i
                            class="fa fa-play"></i></a></div>
        </div>
    </section>
    <div class="clearfix"></div>
    <section class="how-it-works">
        <div class="container">
            <div class="row" data-aos="fade-up">
                <div class="col-md-12">
                    <div class="main-heading">
                        <p>Working Process</p>

                        <h2>How It <span>Works</span></h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-4">
                    <div class="working-process">
                                <span class="process-img"><img src="assets/img/step-1.png" class="img-responsive"
                                                               alt=""/><span
                                            class="process-num">01</span></span>
                        <h4>Create An Account</h4>

                        <p>Post a job to tell us about your project. We'll quickly match you with the right freelancers
                            find place best.</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="working-process">
                                <span class="process-img"><img src="assets/img/step-2.png" class="img-responsive"
                                                               alt=""/><span
                                            class="process-num">02</span></span>
                        <h4>Search Jobs</h4>

                        <p>Post a job to tell us about your project. We'll quickly match you with the right freelancers
                            find place best.</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="working-process">
                                <span class="process-img"><img src="assets/img/step-3.png" class="img-responsive"
                                                               alt=""/><span
                                            class="process-num">03</span></span>
                        <h4>Save & Apply</h4>

                        <p>Post a job to tell us about your project. We'll quickly match you with the right freelancers
                            find place best.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="clearfix"></div>
    <section class="testimonial" id="testimonial">
        <div class="container">
            <div class="row">
                <div class="main-heading">
                    <p>What Say Our Client</p>

                    <h2>Our Success <span>Stories</span></h2>
                </div>
            </div>
            <div class="row">
                <div id="client-testimonial-slider" class="owl-carousel">
                    <div class="client-testimonial">
                        <div class="pic"><img src="assets/img/client-1.jpg" alt=""></div>
                        <p class="client-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                            eiusmod tempor et dolore magna aliqua.</p>

                        <h3 class="client-testimonial-title">Lacky Mole</h3>
                        <ul class="client-testimonial-rating">
                            <li class="fa fa-star-o"></li>
                            <li class="fa fa-star-o"></li>
                            <li class="fa fa-star"></li>
                        </ul>
                    </div>
                    <div class="client-testimonial">
                        <div class="pic"><img src="assets/img/client-2.jpg" alt=""></div>
                        <p class="client-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                            eiusmod tempor et dolore magna aliqua.</p>

                        <h3 class="client-testimonial-title">Karan Wessi</h3>
                        <ul class="client-testimonial-rating">
                            <li class="fa fa-star-o"></li>
                            <li class="fa fa-star"></li>
                            <li class="fa fa-star"></li>
                        </ul>
                    </div>
                    <div class="client-testimonial">
                        <div class="pic"><img src="assets/img/client-3.jpg" alt=""></div>
                        <p class="client-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                            eiusmod tempor et dolore magna aliqua.</p>

                        <h3 class="client-testimonial-title">Roul Pinchai</h3>
                        <ul class="client-testimonial-rating">
                            <li class="fa fa-star-o"></li>
                            <li class="fa fa-star-o"></li>
                            <li class="fa fa-star"></li>
                        </ul>
                    </div>
                    <div class="client-testimonial">
                        <div class="pic"><img src="assets/img/client-1.jpg" alt=""></div>
                        <p class="client-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                            eiusmod tempor et dolore magna aliqua.</p>

                        <h3 class="client-testimonial-title">Adam Jinna</h3>
                        <ul class="client-testimonial-rating">
                            <li class="fa fa-star-o"></li>
                            <li class="fa fa-star-o"></li>
                            <li class="fa fa-star"></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="pricing">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-heading">
                        <p>Top Freelancer</p>

                        <h2>Hire Expert <span>Freelancer</span></h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="freelance-container style-2">
                        <div class="freelance-box">
                            <span class="freelance-status">Available</span>
                            <h4 class="flc-rate">$17/hr</h4>

                            <div class="freelance-inner-box">
                                <div class="freelance-box-thumb"><img src="assets/img/can-5.jpg"
                                                                      class="img-responsive img-circle" alt=""/></div>
                                <div class="freelance-box-detail">
                                    <h4>Agustin L. Smith</h4>
                                    <span class="location">Australia</span>
                                </div>
                                <div class="rattings"><i class="fa fa-star fill"></i><i class="fa fa-star fill"></i><i
                                            class="fa fa-star fill"></i><i class="fa fa-star-half fill"></i><i
                                            class="fa fa-star"></i></div>
                            </div>
                            <div class="freelance-box-extra">
                                <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui.</p>
                                <ul>
                                    <li>Php</li>
                                    <li>Android</li>
                                    <li>Html</li>
                                    <li class="more-skill bg-primary">+3</li>
                                </ul>
                            </div>
                            <a href="freelancer-detail.html" class="btn btn-freelance-two bg-default">View Detail</a><a
                                    href="freelancer-detail.html" class="btn btn-freelance-two bg-info">View Detail</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="freelance-container style-2">
                        <div class="freelance-box">
                            <span class="freelance-status bg-warning">At Work</span>
                            <h4 class="flc-rate">$22/hr</h4>

                            <div class="freelance-inner-box">
                                <div class="freelance-box-thumb"><img src="assets/img/can-5.jpg"
                                                                      class="img-responsive img-circle" alt=""/></div>
                                <div class="freelance-box-detail">
                                    <h4>Delores R. Williams</h4>
                                    <span class="location">United States</span>
                                </div>
                                <div class="rattings"><i class="fa fa-star fill"></i><i class="fa fa-star fill"></i><i
                                            class="fa fa-star fill"></i><i class="fa fa-star-half fill"></i><i
                                            class="fa fa-star"></i></div>
                            </div>
                            <div class="freelance-box-extra">
                                <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui.</p>
                                <ul>
                                    <li>Php</li>
                                    <li>Android</li>
                                    <li>Html</li>
                                    <li class="more-skill bg-primary">+3</li>
                                </ul>
                            </div>
                            <a href="freelancer-detail.html" class="btn btn-freelance-two bg-default">View Detail</a><a
                                    href="freelancer-detail.html" class="btn btn-freelance-two bg-info">View Detail</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="freelance-container style-2">
                        <div class="freelance-box">
                            <span class="freelance-status">Available</span>
                            <h4 class="flc-rate">$19/hr</h4>

                            <div class="freelance-inner-box">
                                <div class="freelance-box-thumb"><img src="assets/img/can-5.jpg"
                                                                      class="img-responsive img-circle" alt=""/></div>
                                <div class="freelance-box-detail">
                                    <h4>Daniel Disroyer</h4>
                                    <span class="location">Bangladesh</span>
                                </div>
                                <div class="rattings"><i class="fa fa-star fill"></i><i class="fa fa-star fill"></i><i
                                            class="fa fa-star fill"></i><i class="fa fa-star-half fill"></i><i
                                            class="fa fa-star"></i></div>
                            </div>
                            <div class="freelance-box-extra">
                                <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui.</p>
                                <ul>
                                    <li>Php</li>
                                    <li>Android</li>
                                    <li>Html</li>
                                    <li class="more-skill bg-primary">+3</li>
                                </ul>
                            </div>
                            <a href="freelancer-detail.html" class="btn btn-freelance-two bg-default">View Detail</a><a
                                    href="freelancer-detail.html" class="btn btn-freelance-two bg-info">View Detail</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="text-center"><a href="freelancers-2.html" class="btn btn-primary">Load More</a></div>
                </div>
            </div>
        </div>
    </section>
    <div class="clearfix"></div>
    <?php require('footer.php'); ?>
    <div class="clearfix"></div>
    <!--<button class="w3-button w3-teal w3-xlarge w3-right" onclick="openRightMenu()"><i class="spin fa fa-cog"
                                                                                      aria-hidden="true"></i></button>
    <div class="w3-sidebar w3-bar-block w3-card-2 w3-animate-right" style="display:none;right:0;" id="rightMenu">
        <button onclick="closeRightMenu()" class="w3-bar-item w3-button w3-large">Close &times;</button>
        <ul id="styleOptions" title="switch styling">
            <li>
                <a href="javascript: void(0)" class="cl-box blue" data-theme="colors/blue-style"></a>
            </li>
            <li>
                <a href="javascript: void(0)" class="cl-box red" data-theme="colors/red-style"></a>
            </li>
            <li>
                <a href="javascript: void(0)" class="cl-box purple" data-theme="colors/purple-style"></a>
            </li>
            <li>
                <a href="javascript: void(0)" class="cl-box green" data-theme="colors/green-style"></a>
            </li>
            <li>
                <a href="javascript: void(0)" class="cl-box dark-red" data-theme="colors/dark-red-style"></a>
            </li>
            <li>
                <a href="javascript: void(0)" class="cl-box orange" data-theme="colors/orange-style"></a>
            </li>
            <li>
                <a href="javascript: void(0)" class="cl-box sea-blue" data-theme="colors/sea-blue-style "></a>
            </li>
            <li>
                <a href="javascript: void(0)" class="cl-box pink" data-theme="colors/pink-style"></a>
            </li>
        </ul>
    </div>-->
    <!-- Scripts==================================================-->
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
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/jQuery.style.switcher.js"></script>
    <!--<script type="text/javascript">
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
    </script>-->
    <script>
        function verifyJobSearch(){
            if(document.forms['searchJobForm']['jobtype'].value == "-1"){
                return 0;
            }
            return 1;
        }
    </script>
</div>
<?php require('loginModal.php'); ?>
</body>

</html>