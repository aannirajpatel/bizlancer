<?php
require 'includes/db.php';
$message = "";
$resetUrl = "";
$resetShow = 0;
if (isset($_POST['forgot'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $existQuery = "SELECT * FROM user WHERE email = '$email'";
    $existResult = mysqli_query($con, $existQuery) or die($existQuery . mysqli_error($con));
    if (mysqli_num_rows($existResult) == 0) {
        $message = "Such an email does not exist. Please enter the correct email for password reset. <br><b>Note:</b> someone with a password can also change the account email address. In such case, please inform us through <a href='contact.php#contact-form'>here</a>";
    } else {
        $existData = mysqli_fetch_array($existResult);
        $resetUrl = "lost-password.php?u=" . $existData['email'] . "&p=" . $existData['password'];
        $mailHeader = "MIME-Version: 1.0" . "\r\n";
        $mailHeader .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $mailHeader .= "From: support@bizlancer.com\r\n";
        $msg = "Please use the following link to reset your password:<a href='$resetUrl'>".$resetUrl."</a>";
        mail($email,"BizLancer: Password Reset link", $msg, $mailHeader);
        $message = "Password reset link has been sent to your email address";
    }
}
if (isset($_GET['u']) && isset($_GET['p'])) {
    $email = mysqli_real_escape_string($con, $_GET['u']);
    $phash = mysqli_real_escape_string($con, $_GET['p']);
    $existQuery = "SELECT * FROM user WHERE email = '$email' AND password = '$phash'";
    $existResult = mysqli_query($con, $existQuery) or die($existQuery . mysqli_error($con));
    if (mysqli_num_rows($existResult) == 0) {
        $message = "Such a reset link does not exist. Reset links could not work if the password or e-mail has been changed after issuing the reset link. If you think your access has been compromised, please inform us by clicking <a href='contact.php#contact-form'>here</a>";
    } else {
        $resetShow = 1;
    }
}
if(isset($_POST['reset'])){
    $email = mysqli_real_escape_string($con, $_POST['u']);
    $phash = mysqli_real_escape_string($con, $_POST['p']);
    $newphash = md5(mysqli_real_escape_string($con, $_POST['password']));
    $existQuery = "SELECT * FROM user WHERE email = '$email' AND password = '$phash'";
    $existResult = mysqli_query($con, $existQuery) or die($existQuery . mysqli_error($con));
    if (mysqli_num_rows($existResult) == 0) {
        $message = "This reset link didn't work. Reset links could not work if the password or e-mail has been changed after issuing the reset link. If you think your access has been compromised, please inform us by clicking <a href='contact.php#contact-form'>here</a>";
        $message.=$existQuery;
    } else {
        $updatePasswordQuery = "UPDATE `user` SET password = '$newphash' WHERE email = '$email' AND password = '$phash'";
        $updatePasswordResult = mysqli_query($con, $updatePasswordQuery) or die($updatePasswordQuery . mysqli_error($con));
        $message = "Password has been reset. Click <a href='login.php'>here</a> to go to the login page.";
        $resetShow = 2;
    }
}
?>

<!doctype html>
<html lang="en">

<!-- lost-password42:17-->
<head>
    <!-- Basic Page Needs
    ================================================== -->
    <title>Forgot Password | BizLancer</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSS
    ================================================== -->
    <link rel="stylesheet" href="assets/plugins/css/plugins.css">

    <!-- Custom style -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" id="jssDefault" href="assets/css/colors/green-style.css">

</head>
<body class="simple-bg-screen" style="background-image:url(assets/img/banner-10.jpg);">
<div class="Loader"></div>
<div class="wrapper">

    <section class="lost-ps-screen-sec">
        <!-- Title Header Start -->
        <?php if ($message != "") { ?>
            <div class="container lost-msg">
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        <?php } ?>
        <div class="container">
            <div class="lost-ps-screen">
                <a href="index-2.html"><img src="assets/img/logo.png" class="img-responsive" alt=""></a>
                <?php
                if ($resetShow == 0) {
                    ?>
                    <form method="post" action="">
                        <input type="email" class="form-control" placeholder="Enter your Email" name="email">
                        <button class="btn btn-login" type="submit" name="forgot">Submit</button>
                    </form>
                    <?php
                }
                if ($resetShow == 1) {
                    ?>
                    <form method="post" action="">
                        <input type="password" class="form-control" placeholder="Enter your new password" name="password">
                        <input type="password" class="form-control" placeholder="Confirm your new password" name="confirm-password">
                        <input type="hidden" name="p" value="<?php echo $phash;?>">
                        <input type="hidden" name="u" value="<?php echo $email;?>">
                        <button class="btn btn-login" type="submit" name="reset">Submit</button>
                    </form>
                    <?php
                }
                ?>
            </div>
        </div>
    </section>


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

<!-- lost-password42:17-->
</html>