<?php
require('includes/auth.php');
require('includes/db.php');
require('includes/constants.php');
require('includes/files.php');
$uid = $_SESSION['uid'];
$message = "";
if(!isset($_GET['user']) || !userExists($con, $_GET['user'])){
    header("location:404.php");
}
$rec = $_GET['user'];
if(isset($_POST['send'])){
    $msg = mysqli_real_escape_string($con, $_POST['msg']);
    $sendQuery = "INSERT INTO companymessage(uids,uidr,msg,sendtime) VALUES($uid,$rec,'$msg',CURRENT_TIMESTAMP)";
    $sendResult = mysqli_query($con, $sendQuery) or die($sendQuery.mysqli_error($con));
}
$msgQuery = "SELECT * FROM companymessage WHERE (uids=$uid AND uidr=$rec) OR (uids=$rec AND uidr=$uid) ORDER BY sendtime ASC";
$msgResult = mysqli_query($con, $msgQuery) or die($msgQuery.mysqli_error($con));
$recName = mysqli_query($con, "SELECT name FROM user WHERE uid=$rec");

$seenQuery = mysqli_query($con,"UPDATE companymessage SET seen=1 WHERE (uids=$rec AND uidr=$uid)");

$nameQuery = "SELECT `name` FROM user WHERE uid=$rec";
$nameResult = mysqli_query($con, $nameQuery) or die($nameQuery.mysqli_error($con));
$nameData = mysqli_fetch_array($nameResult);
$name = $nameData['name'];

$nameQuery = "SELECT `name` FROM user WHERE uid=$uid";
$nameResult = mysqli_query($con, $nameQuery) or die($nameQuery.mysqli_error($con));
$nameData = mysqli_fetch_array($nameResult);
$name = $nameData['name'];

$cnameQuery = "SELECT cimg, `cname` FROM company WHERE cid=$rec";
$cnameResult = mysqli_query($con, $cnameQuery) or die($cnameQuery.mysqli_error($con));
if(mysqli_num_rows($cnameResult)==0){
    header("location:404.php");
}
$cnameData = mysqli_fetch_array($cnameResult);
$cname = $cnameData['cname'];
$cimg = $cnameData['cimg'];
?>
<!doctype html>
<html lang="en">

<!-- create-job41:39-->
<head>
    <!-- Basic Page Needs
    ================================================== -->
    <title>Chat</title>
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
            <h1>Chat with <?php echo $cname;?></h1>
        </div>
    </section>
    <div class="clearfix"></div>
    <!-- Header Title End -->

    <!-- General Detail Start -->
    <div class="detail-desc section">
        <div class="container white-shadow">
            <div class="row mrg-0">
                    <div class="detail-pic">
                    <img src="<?php echo $cimg; ?>" class="img" alt=""/>
                </div>
            </div>
            <div class="row bottom-mrg" style="margin-top: 2rem;">
                <div class="panel">
                    <div class="panel-body" id="chat-body">
                        <?php
                        if(mysqli_num_rows($msgResult)!=0) {
                            while ($msgData = mysqli_fetch_array($msgResult)) {
                                if ($msgData['uids'] == $uid) {
                                    ?>
                                    <div class="msg-sent">
                                        <?php echo htmlspecialchars($msgData['msg']); ?>
                                        <br>
                                        <small>Chatting as: <?php echo $name;?> Send time: <?php echo $msgData['sendtime']; ?></small>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="msg-received">
                                        <?php echo htmlspecialchars($msgData['msg']); ?>
                                        <br>
                                        <small>From Company: <?php echo $cname;?> Send time: <?php echo $msgData['sendtime']; ?></small>
                                    </div>
                                    <?php
                                }
                            }
                        } else{
                            ?>
                            No chats to show
                            <?php
                        }
                        ?>
                    </div>
                    <div class="panel-footer">
                        <form method="post" action="">
                        <div class="input-group">
                            <input id="btn-input" type="text" class="form-control input-sm chat_input" placeholder="Write your message here..."  name="msg"/>
                            <span class="input-group-btn">
                        <button class="btn btn-primary btn-sm" type="submit" name="send" id="btn-chat">Send</button>
                        </span>
                        </div>
                        </form>
                    </div>
                </div>

        </div>
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
    $(document).ready(function () {
        $('html, body').animate({
            scrollTop: $("#chat-body").offset().top
        }, 1000);
        $('#chat-body').scrollTop($('#chat-body')[0].scrollHeight);
    });
</script>


</div>
</body>

<!-- create-job41:40-->
</html>