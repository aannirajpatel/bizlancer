<?php
require('includes/auth.php');
require('includes/db.php');
require('includes/constants.php');
require('includes/files.php');
$message = "";
$uid = $_SESSION['uid'];
$getMessengerQuery = "SELECT cid,cname FROM company,companymessage WHERE (companymessage.uidr=company.cid AND companymessage.uids=$uid) OR (companymessage.uidr=$uid AND companymessage.uids=company.cid) GROUP BY cid ORDER BY companymessage.sendtime DESC;";
$getMessengerResult = mysqli_query($con, $getMessengerQuery) or die($getMessengerQuery.mysqli_error($con));
if(mysqli_num_rows($getMessengerResult)<0){
    $message="No company messages to show.";
}
?>
<!doctype html>
<html lang="en">

<!-- create-job41:39-->
<head>
    <!-- Basic Page Needs
    ================================================== -->
    <title>Messages</title>
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
            <h1 class="page-heading">Communicate with Companies</h1>
        </div>
    </section>
    <div class="clearfix"></div>
    <!-- Header Title End -->
<?php if($message=="") { ?>
    <!-- General Detail Start -->
    <div class="detail-desc section">
        <div class="container white-shadow">
            <div class="row mrg-0">
                <div class="detail-pic">
                    <img src="<?php echo COMPANY_IMAGE_FOLDER . DEFAULT_USER_IMAGE; ?>" class="img" alt=""/>
                </div>
            </div>
            <div class="row bottom-mrg" style="margin-top: 2rem;">
                <div class="panel">
                    <div class="panel-body">
                        <ul class="list-group">
                            <h3>Showing messages from companies</h3>
                            <?php
                            while($companyMessengerData = mysqli_fetch_array($getMessengerResult)) {
                                $uids = $companyMessengerData['cid'];
                                $countNotSeenQuery = "SELECT count(*) AS totalnew FROM companymessage WHERE uids=".$companyMessengerData['cid']." AND uidr=$uid AND seen=0";
                                $countNotSeenResult = mysqli_query($con, $countNotSeenQuery) or die(mysqli_error($con));
                                $countNotSeenData = mysqli_fetch_array($countNotSeenResult);
                                $countNotSeen = $countNotSeenData['totalnew'];
                                ?>
                                <a href="chat-with-company.php?user=<?php echo $companyMessengerData['cid'];?>" class="list-group-item"> <?php echo $companyMessengerData['cname']." "; if($countNotSeen>0){?><span class="badge"><?php echo $countNotSeen; ?></span><?php } ?></a>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- General Detail End -->
    <?php
}
    ?>
    <!-- Footer Section Start -->
    <?php
    require 'footer.php';
    ?>
    <div class="clearfix"></div>
    <!-- Footer Section End -->

    <!-- Sign Up Window Code -->
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
    <!-- Date dropper js-->
    <!-- Custom Js -->
    <script src="assets/js/custom.js"></script>
    <script>
        /*$(document).ready(function () {
            $('html, body').animate({
                scrollTop: $("#chat-body").offset().top
            }, 1000);
        });*/
    </script>


</div>
</body>

<!-- create-job41:40-->
</html>
