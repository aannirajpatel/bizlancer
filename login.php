<?php
session_start();
require 'includes/db.php';
$message = "";
if (isset($_POST['signup'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $type = mysqli_real_escape_string($con, $_POST['type']);
    $password = md5($_POST['password']);
    $checkUserQuery = "SELECT * FROM user WHERE email='$email'";
    $checkUserResult = mysqli_query($con, $checkUserQuery);
    if (mysqli_num_rows($checkUserResult) > 0) {
        $message = "User already exists";
    } else {
        $startTransaction = mysqli_query($con, "START TRANSACTION") or die(mysqli_error($con));
        $signUpQuery = "INSERT INTO user(`name`, email, phone, `type`, password, dateofjoin,userimg) VALUES ('$name','$email','$phone',$type,'$password',CURRENT_TIMESTAMP,'assets/img/user/user.jpg')";
        $signUpResult = mysqli_query($con, $signUpQuery) or die(mysqli_error($con));
        $getUidQuery = "SELECT uid FROM user WHERE email='$email'";
        $getUidResult = mysqli_query($con, $getUidQuery) or die(mysqli_error($con));
        $getUidData = mysqli_fetch_array($getUidResult);
        $uid = $getUidData['uid'];
        $_SESSION['uid'] = $uid;
        if (isset($_SESSION['fw'])) {
            $fw = $_SESSION['fw'];
            unset($_SESSION['fw']);
            header_remove();
            header("location:" . $fw);
            die();
        } else {
            header_remove();
            header("location:index.php");
            die();
        }
    }
}
if (isset($_COOKIE['email']) && isset($_COOKIE['password'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = md5($_POST['password']);
    $loginQuery = "SELECT * FROM user WHERE email='$email' AND password='$password'";
    $loginResult = mysqli_query($con, $loginQuery);
    if (mysqli_num_rows($loginResult) == 1) {
        setcookie("email", $email, time() + 86400 * 10);
        setcookie("pass", $password, time() + 86400 * 10);
        $loginData = mysqli_fetch_array($loginResult);
        $_SESSION['uid'] = $loginData['uid'];
        if (isset($_SESSION['fw'])) {
            $fw = $_SESSION['fw'];
            unset($_SESSION['fw']);
            header_remove();
            header("location:" . $fw);
            die();
        } else {
            header_remove();
            header("location:index.php");
            die();
        }
    } else {
        $message = "Invalid login. Please check email or password.";
    }
}
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = md5($_POST['password']);
    $loginQuery = "SELECT * FROM user WHERE email='$email' AND password='$password'";
    $loginResult = mysqli_query($con, $loginQuery);
    if (mysqli_num_rows($loginResult) == 1) {
        if (isset($_POST['remember']) && $_POST['remember'] == 'Yes') {
            setcookie("email", $email, time() + 86400 * 10);
            setcookie("pass", $password, time() + 86400 * 10);
        } else{
            setcookie("email","",time()-1);
            setcookie("pass","",time()-1);
        }
        $loginData = mysqli_fetch_array($loginResult);
        $_SESSION['uid'] = $loginData['uid'];
        if (isset($_SESSION['fw'])) {
            $fw = $_SESSION['fw'];
            unset($_SESSION['fw']);
            header_remove();
            header("location:" . $fw);
            die();
        } else {
            header_remove();
            header("location:index.php");
            die();
        }
    } else {
        $message = "Invalid login. Please check email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<!-- new-login-signup41:49-->
<head>
    <!-- Basic Page Needs ================================================== -->
    <title>BizLancer</title>
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
    <section class="inner-header-title gray-bg">
        <div class="container">
            <h2 class="cl-default">Enter into BizLancer</h2>
        </div>
    </section>
    <div class="clearfix"></div>
    <!-- Title Header End -->

    <!-- Accordion Design Start -->
    <section class="accordion">
        <div class="container">

            <?php if ($message != "") { ?>
                <div class="row">
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <?php echo $message; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            <?php } ?>

            <div class="row">

                <!-- Billing Address -->
                <div class="col-md-6 col-sm-6">
                    <div class="sidebar-wrapper">

                        <div class="sidebar-box-header bb-1">
                            <h4>Create An Account</h4>
                        </div>

                        <form method="post" action="">
                            <div class="row">
                                <div class="col-xs-12">
                                    <label>Full Name</label>
                                    <input type="text" class="form-control" required="" placeholder="Your Full Name*"
                                           name="name"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <label>Email</label>
                                    <input type="email" class="form-control" required="" placeholder="Your Email*"
                                           name="email"/>
                                </div>
                                <div class="col-xs-6">
                                    <label>Phone</label>
                                    <input type="tel" class="form-control" placeholder="Your Phone Number"
                                           name="phone" autocomplete="off"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <label>Password</label>
                                    <input type="password" class="form-control" required=""
                                           placeholder="Set a password*" name="password"/>
                                </div>
                                <div class="col-xs-6">
                                    <label>Confirm Password</label>
                                    <input type="password" class="form-control" required=""
                                           placeholder="Re-type your password*" name="confirm"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 text-center">
                                    <select name="type" class="form-control" required="">
                                        <option value="0">Register for a Candidate Account</option>
                                        <option value="1">Register for a Company Account</option>
                                    </select>
                                    <!--<a href="#" class="btn btn-default">Cancel</a>-->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
										<span class="custom-checkbox">
											<input type="checkbox" id="1">
											<label for="1"></label>
										</span> I give my consent to BizLancer to collect my data with GDPR
                                    regulation.</a>
                                </div>
                            </div>
                            <div class="row mrg-top-30">
                                <div class="col-md-12 text-center">
                                    <button class="btn btn-success" name="signup">SignUp</button>
                                    <!--<a href="#" class="btn btn-default">Cancel</a>-->
                                </div>
                            </div>
                        </form>

                    </div>
                </div>

                <!-- Payment Detail -->
                <div class="col-md-6 col-sm-6">
                    <div class="sidebar-wrapper">

                        <div class="sidebar-box-header bb-1">
                            <h4>LogIn Your Account</h4>
                        </div>

                        <form class="billing-form" method="post" action="">
                            <div class="row">
                                <div class="col-xs-12">
                                    <label>Email</label>
                                    <input type="email" class="form-control" required="" placeholder="Your Email*"
                                           name="email"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <label>Password</label>
                                    <input type="password" class="form-control" required=""
                                           placeholder="Your Password*" name="password"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 mrg-top-5">
										<span class="custom-checkbox">
											<input type="checkbox" id="1" name="remember" value="Yes">
											<label for="1">Remember Me</label>
										</span> Forgot Password? <a href="lost-password.php" class="cl-success">Click
                                        Here</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center mrg-top-25">
                                    <button class="btn btn-success" type="submit" name="login">LogIn</button>
                                    <!--<a href="#" class="btn btn-default">Cancel</a>-->
                                </div>
                            </div>
                        </form>

                    </div>
                </div>

            </div>

        </div>
    </section>
    <!-- Accordion Design End -->

    <!-- Footer Section Start -->
    <?php require 'footer.php'; ?>
    <div class="clearfix"></div>
    <!-- Footer Section End -->

    <!-- Sign Up Window Code -->
    <?php require('loginModal.php'); ?>
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

<!-- new-login-signup41:50-->
</html>