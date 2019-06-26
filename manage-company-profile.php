<?php
require('includes/auth.php');
require('includes/db.php');
require('includes/constants.php');
require('includes/files.php');
$uid = $_SESSION['uid'];
if (isset($_POST['addCompany'])) {

    $name = mysqli_real_escape_string($con, $_POST['name']);
    $tagline = mysqli_real_escape_string($con, $_POST['tagline']);
    $type = intval(mysqli_real_escape_string($con, $_POST['type']));
    $ceo = mysqli_real_escape_string($con, $_POST['ceo']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $website = mysqli_real_escape_string($con, $_POST['website']);
    $location = mysqli_real_escape_string($con, $_POST['location']);
    $dateofbirth = mysqli_real_escape_string($con, $_POST['cdob']);
    $strength = mysqli_real_escape_string($con, $_POST['strength']);
    if ($strength == "") {
        $strength = 1;
    }
    $facebook = mysqli_real_escape_string($con, $_POST['facebook']);
    $gplus = mysqli_real_escape_string($con, $_POST['gplus']);
    $twitter = mysqli_real_escape_string($con, $_POST['twitter']);
    $instagram = mysqli_real_escape_string($con, $_POST['instagram']);
    $linkedin = mysqli_real_escape_string($con, $_POST['linkedin']);
    $dribble = mysqli_real_escape_string($con, $_POST['dribble']);
    $about = mysqli_real_escape_string($con, $_POST['about']);
    $startTransaction = mysqli_query($con, "START TRANSACTION") or die(mysqli_error($con));
    if(!isset($_SESSION['existingFileName'])){
        $destination=COMPANY_IMAGE_FOLDER."company.png";
    } else{
        $destination = $_SESSION['existingFileName'];
    }
    if ($_FILES['pic']['error'] == 0) {
        if (isset($_SESSION['existingFileName'])) {
            $fileName = $_SESSION['existingFileName'];
            unset($_SESSION['existingFileName']);
            unlink($fileName);
        }
        $fileNameArray = preg_split("/\./", $_FILES['pic']['name'], 2);
        if (count($fileNameArray) >= 2) {
            $extension = "." . $fileNameArray[1];
        } else {
            //Default extension is JPG to handle case of a file without extension
            $extension = ".jpg";
        }
        $destination = COMPANY_IMAGE_FOLDER . $uid . $extension;
        move_uploaded_file($_FILES['pic']['tmp_name'], $destination);
    }
    $companyValues = "($uid,'$name','$tagline',$type,'$ceo','$description','$email','$phone','$website','$location','$dateofbirth',$strength,'$facebook','$gplus','$twitter','$instagram','$linkedin','$dribble','$about','$destination')";
    $updateValues = "cname='$name',tagline='$tagline',type=$type,ceo='$ceo',cdesc='$description',email='$email',phone='$phone',website='$website',location='$location',dob='$dateofbirth',strength=$strength,facebook='$facebook',gplus='$gplus',twitter='$twitter',instagram='$instagram',linkedin='$linkedin',dribble='$dribble',about='$about',cimg='$destination'";
    $insertCompanyQuery = "INSERT INTO company(uid,cname,tagline,`type`,ceo, cdesc, email, phone, website, location, dob, strength, facebook, gplus, twitter, instagram, linkedin, dribble,about, cimg) VALUES" . $companyValues . " ON DUPLICATE KEY UPDATE " . $updateValues;
    $insertCompanyResult = mysqli_query($con, $insertCompanyQuery);
    $commit = mysqli_query($con, "COMMIT") or die(mysqli_error($con));
}
$companyDetailsData = array();
$companyDetailsQuery = "SELECT * FROM company WHERE cid=$uid";
$companyDetailsResult = mysqli_query($con, $companyDetailsQuery) or die(mysqli_error($con));
$companyExists = mysqli_num_rows($companyDetailsResult);
if ($companyExists != 0) {
    $companyDetailsData = mysqli_fetch_array($companyDetailsResult);
    $_SESSION['existingFileName'] = $companyDetailsData['cimg'];
}

function fillInForm($existingData, $key)
{
    if (isset($existingData[$key])) {
        echo $existingData[$key];
    } else {
        echo "";
    }
}

?>
<!doctype html>
<html lang="en">

<!-- create-company41:40-->
<head>
    <!-- Basic Page Needs
    ================================================== -->
    <title>Manage Company Profile | BizLancer</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

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
    <form method="post" action="" enctype="multipart/form-data">
        <!-- Header Title Start -->
        <section class="inner-header-title blank">
            <div class="container">
                <h1>Company Profile Builder</h1>
            </div>
        </section>
        <div class="clearfix"></div>
        <!-- Header Title End -->

        <!-- General Detail Start -->
        <div class="detail-desc section">
            <div class="container white-shadow">
                <div class="row">
                    <div class="detail-pic js">
                        <div class="box">
                            <input type="file" id="upload-pic" class="inputfile" name="pic" accept="image/*"/>
                            <label for="upload-pic">
                                <?php if (isset($_SESSION['existingFileName'])) {
                                    echo "<img src='" . $_SESSION['existingFileName'] . "' class='img-fluid'>";
                                } else { ?>
                                    <i class="fa fa-upload" aria-hidden="true"></i>
                                    <?php
                                }
                                ?>
                            </label>
                            <span class="help-block">
                                Click on logo to upload new logo
                            </span>
                        </div>
                    </div>
                </div>

                <div class="row bottom-mrg" style="margin-top: 1rem;">
                    <div class="add-feild">

                        <div class="col-md-6 col-sm-6">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Company Name" name="name"
                                       value="<?php fillInForm($companyDetailsData, 'cname'); ?>">
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Tagline" name="tagline"
                                       value="<?php fillInForm($companyDetailsData, 'tagline'); ?>">
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="input-group">
                                <?php
                                if (isset($companyDetailsData['type'])) {
                                    $typeVal = $companyDetailsData['type'];
                                    ?>

                                    <select class="form-control input-lg" name="type">
                                        <option disabled="">All Categories</option>
                                        <option value="<?php echo COMPANY_SOFTWARE; ?>" <?php if ($typeVal == COMPANY_SOFTWARE) {
                                            echo "selected=''";
                                        } ?>>Software
                                        </option>
                                        <option value="<?php echo COMPANY_HARDWARE; ?>" <?php if ($typeVal == COMPANY_HARDWARE) {
                                            echo "selected=''";
                                        } ?>>Hardware
                                        </option>
                                        <option value="<?php echo COMPANY_MECHANICAL; ?> <?php if ($typeVal == COMPANY_MECHANICAL) {
                                            echo "selected=''";
                                        } ?>">Mechanical
                                        </option>
                                        <option value="<?php echo COMPANY_HR_MANAGEMENT; ?>" <?php if ($typeVal == COMPANY_HR_MANAGEMENT) {
                                            echo "selected=''";
                                        } ?>>HR/Management
                                        </option>
                                        <option value="<?php echo COMPANY_OTHER; ?>" <?php if ($typeVal == COMPANY_OTHER) {
                                            echo "selected=''";
                                        } ?>>Other
                                        </option>
                                    </select>

                                    <?php
                                } else {
                                    ?>
                                    <select class="form-control input-lg" name="type">
                                        <option selected="" disabled="">All Categories</option>
                                        <option value="<?php echo COMPANY_SOFTWARE; ?>">Software</option>
                                        <option value="<?php echo COMPANY_HARDWARE; ?>">Hardware</option>
                                        <option value="<?php echo COMPANY_MECHANICAL; ?>">Mechanical</option>
                                        <option value="<?php echo COMPANY_HR_MANAGEMENT; ?>">HR/Management</option>
                                        <option value="<?php echo COMPANY_OTHER; ?>">Other</option>
                                    </select>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Company CEO Name" name="ceo"
                                       value="<?php fillInForm($companyDetailsData, 'ceo'); ?>">
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <textarea class="form-control" placeholder="Company Description"
                                      name="description"><?php fillInForm($companyDetailsData, 'cdesc'); ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="row no-padd">
                    <div class="detail pannel-footer">
                        <div class="col-md-12 col-sm-12">
                            <div class="detail-pannel-footer-btn pull-right">
                                <a href="#" class="footer-btn choose-cover">Upload company logo</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- General Detail End -->

        <!-- Basic Full Detail Form Start -->
        <section class="full-detail">
            <div class="container">
                <div class="row bottom-mrg extra-mrg">
                    <div>
                        <h2 class="detail-title">Work Experience</h2>
                        <div class="col-md-6 col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input type="text" class="form-control" placeholder="Email Address" name="email"
                                       value="<?php fillInForm($companyDetailsData, 'email'); ?>">
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                <input type="tel" class="form-control" placeholder="Phone Number" name="phone"
                                       value="<?php fillInForm($companyDetailsData, 'phone'); ?>">
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                                <input type="text" class="form-control" placeholder="Website Address" name="website"
                                       value="<?php fillInForm($companyDetailsData, 'website'); ?>">
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                <input type="text" class="form-control" placeholder="Local E.g. It Park New"
                                       name="location" value="<?php fillInForm($companyDetailsData, 'location'); ?>">
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-birthday-cake"></i></span>
                                <input type="date" id="company-dob" class="form-control" name="cdob" value="<?php fillInForm($companyDetailsData, 'dob'); ?>">
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                                <input type="text" class="form-control" placeholder="Strength E.g. 100-2500"
                                       name="strength" value="<?php fillInForm($companyDetailsData, 'strength'); ?>">
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row bottom-mrg extra-mrg">

                    <h2 class="detail-title">Social Profile</h2>
                    <div class="col-md-6 col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-facebook"></i></span>
                            <input type="text" class="form-control" placeholder="Facebook Link" name="facebook"
                                   value="<?php fillInForm($companyDetailsData, 'facebook'); ?>">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-google-plus"></i></span>
                            <input type="text" class="form-control" placeholder="Profile Link" name="gplus"
                                   value="<?php fillInForm($companyDetailsData, 'gplus'); ?>">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-twitter"></i></span>
                            <input type="text" class="form-control" placeholder="Profile Link" name="twitter"
                                   value="<?php fillInForm($companyDetailsData, 'twitter'); ?>">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-instagram"></i></span>
                            <input type="text" class="form-control" placeholder="Profile Link" name="instagram"
                                   value="<?php fillInForm($companyDetailsData, 'instagram'); ?>">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-linkedin"></i></span>
                            <input type="text" class="form-control" placeholder="Profile Link" name="linkedin"
                                   value="<?php fillInForm($companyDetailsData, 'linkedin'); ?>">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-dribbble"></i></span>
                            <input type="text" class="form-control" placeholder="Profile Link" name="dribble"
                                   value="<?php fillInForm($companyDetailsData, 'dribble'); ?>">
                        </div>
                    </div>


                </div>

                <div class="row bottom-mrg extra-mrg">
                    <div>
                        <h2 class="detail-title">About Company</h2>
                        <div class="col-md-12 col-sm-12">
                            <textarea class="form-control textarea" placeholder="About Company"
                                      name="about"><?php fillInForm($companyDetailsData, 'about'); ?></textarea>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <button class="btn btn-success btn-primary small-btn" type="submit" name="addCompany">Submit
                                your company
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Basic Full Detail Form End -->

        <!-- Footer Section Start -->
        <?php require('footer.php'); ?>
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
        <!-- Date dropper js-->
        <script src="#"></script>

        <!-- Custom Js -->
        <script src="assets/js/custom.js"></script>
</div>
</form>
</body>

<!-- create-company41:40-->
</html>