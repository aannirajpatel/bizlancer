<?php
require('includes/auth.php');
require('includes/db.php');
require('includes/constants.php');
require('includes/files.php');
$uid = $_SESSION['uid'];
if (isset($_POST['updateProfile'])) {
    $startTransaction = mysqli_query($con, "START TRANSACTION") or die("Error in initiating Transaction [update profile failed], mysqli_error:".mysqli_error($con));
    $deleteExp = mysqli_query($con, "DELETE FROM experience WHERE uid=$uid");
    $deleteSkill = mysqli_query($con, "DELETE FROM skill WHERE uid=$uid");
    $deleteEdu = mysqli_query($con, "DELETE FROM education WHERE uid=$uid");

    if(isset($_POST['edu-school'])) {
        $eduSchool = $_POST['edu-school'];
        $eduQualification = $_POST['edu-qualification'];
        $eduStart = $_POST['edu-start'];
        $eduEnd = $_POST['edu-end'];
        $eduNotes = $_POST['edu-notes'];
    }
    if(isset($_POST['exp-employer'])) {
        $expEmployer = $_POST['exp-employer'];
        $expPosition = $_POST['exp-position'];
        $expStart = $_POST['exp-start'];
        $expEnd = $_POST['exp-end'];
        $expNotes = $_POST['exp-notes'];
    }
    if(isset($_POST['skill-name'])){
        $skillNames = $_POST['skill-name'];
        $skillStrengths = $_POST['skill-strength'];
    }

    //Take in and change contact info
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $totalexp = mysqli_real_escape_string($con, $_POST['exp-total']);
    $designation = mysqli_real_escape_string($con, $_POST['designation']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $location = mysqli_real_escape_string($con, $_POST['location']);
    $website = mysqli_real_escape_string($con, $_POST['website']);
    $birthdate = mysqli_real_escape_string($con,$_POST['birthdate']);
    $country = mysqli_real_escape_string($con, $_POST['country']);
    $category= mysqli_real_escape_string($con,$_POST['category']);
    $resume = mysqli_real_escape_string($con,$_POST['resume']);
    $brief = mysqli_real_escape_string($con, $_POST['brief']);
    if($country !='India' && $country!='United Kingdom' && $country!='United States'){
        $country = 'Other';
    }
    $updateContact = mysqli_query($con, "UPDATE user SET brief='$brief',category=$category,designation='$designation',email='$email',phone='$phone',location='$location',website='$website',birthdate='$birthdate', country='$country',experience=$totalexp,resume='$resume' WHERE uid=$uid") or die("Contact Information Updater Query Error: ".mysqli_error($con));
    //Take in and change the password if it is required
    if ($_POST['password'] != "" && $_POST['password'] == $_POST['confirm-password']) {
        $updatePassword = mysqli_query($con, "UPDATE user SET password='" . md5(mysqli_real_escape_string($con, $_POST['password'])) . "' WHERE uid=$uid") or die("Password Updater Query Error: ".mysqli_error($con));
    }

    //Take in the Socials
    $fb = mysqli_real_escape_string($con, $_POST['facebook']);
    $gp = mysqli_real_escape_string($con, $_POST['gplus']);
    $tw = mysqli_real_escape_string($con, $_POST['twitter']);
    $insta = mysqli_real_escape_string($con, $_POST['instagram']);
    $lin = mysqli_real_escape_string($con, $_POST['linkedin']);
    $drib = mysqli_real_escape_string($con, $_POST['dribble']);
    $updateSocial = mysqli_query($con, "UPDATE user SET facebook='$fb',gplus='$gp',twitter='$tw',instagram='$insta',linkedin='$lin',dribble='$drib' WHERE uid=$uid") or die("Social Information Updater Query Error: ".mysqli_error($con));

    if (isset($_POST['freelance-enable'])) {
        $freelancer = 1;
        $minPay = mysqli_real_escape_string($con, $_POST['minpay']);
        $maxPay = mysqli_real_escape_string($con, $_POST['maxpay']);
        $paytype = mysqli_real_escape_string($con, $_POST['paytype']);
    } else {
        $freelancer = 0;
        $minPay = 0;
        $maxPay = 0;
        $paytype = PAY_PER_YEAR;
    }
    $updateFreelance = mysqli_query($con, "UPDATE user SET minpay=$minPay, maxpay=$maxPay,paytype=$paytype,freelancer=$freelancer WHERE uid=$uid");

    if(isset($_POST['edu-school'])) {
        foreach ($eduSchool as $k => $v) {
            if ($v == "") {
                continue;
            }
            $school = mysqli_real_escape_string($con, $v);
            $qualification = mysqli_real_escape_string($con, $eduQualification[$k]);
            $start = mysqli_real_escape_string($con, $eduStart[$k]);
            $end = mysqli_real_escape_string($con, $eduEnd[$k]);
            $notes = mysqli_real_escape_string($con, $eduNotes[$k]);
            $addEdu = mysqli_query($con, "INSERT INTO education(uid,school,qualification,start,`end`,notes) VALUES($uid,'$school','$qualification','$start','$end','$notes')");
        }
    }
    if(isset($_POST['exp-employer'])) {
        foreach ($expEmployer as $k => $v) {
            if ($v == "") {
                continue;
            }
            $employer = mysqli_real_escape_string($con, $v);
            $position = mysqli_real_escape_string($con, $expPosition[$k]);
            $start = $expStart[$k];
            $end = $expEnd[$k];
            $notes = mysqli_real_escape_string($con, $expNotes[$k]);
            $addExp = mysqli_query($con, "INSERT INTO experience(uid,employer,`position`,start,`end`,notes) VALUES($uid,'$employer','$position','$start','$end','$notes')");
        }
    }

    if(isset($_POST['skill-name'])) {
        foreach ($skillNames as $k => $v) {
            if ($v == "") {
                continue;
            }
            $skill = mysqli_real_escape_string($con, $v);
            $strength = mysqli_real_escape_string($con, $skillStrengths[$k]);
            $addSkill = mysqli_query($con, "INSERT INTO skill(uid,name,strength) VALUES($uid,'$skill','$strength')");
        }
    }
    if($_FILES['pic']['error']==0){
        $fileQuery = mysqli_query($con, "SELECT userimg FROM user WHERE uid=$uid");
        $fileData = mysqli_fetch_array($fileQuery);
        $file = $fileData['userimg'];
        if(file_exists($file)){
            unlink($file);
        }
            $ext = preg_split('/\./',$_FILES['pic']['name'],2);
            if(count($ext)>1){
                $ext = $ext[1];
            } else{
                $ext=".png";
            }
            //The assets/img/user folder MUST BE THERE AT ALL TIMES
            $userImg = "assets/img/user/$uid.$ext";
            $updateUserimg = "UPDATE user SET userimg='$userImg' WHERE uid=$uid";
            mysqli_query($con,$updateUserimg) or die($updateUserimg.mysqli_error($con));
            move_uploaded_file($_FILES['pic']['tmp_name'],$userImg);
    }
    $commit = mysqli_query($con, "COMMIT") or die("Error committing [failed to update profile]: ".mysqli_error($con));
}
$userInfo = mysqli_query($con,"SELECT * FROM user WHERE uid=$uid");
$userInfo = mysqli_fetch_array($userInfo);
$userImg = $userInfo['userimg'];
$name = $userInfo['name'];
//contact info
$brief = $userInfo['brief'];
$resume = $userInfo['resume'];
$category = $userInfo['category'];
$designation=$userInfo['designation'];
$totalexp = $userInfo['experience'];
$email = $userInfo['email'];
$phone = $userInfo['phone'];
$location = $userInfo['location'];
$website = $userInfo['website'];
$birthdate = $userInfo['birthdate'];
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

//Education: eduid, uid,school, qualification, start, end, notes
$edu = mysqli_query($con,"SELECT * FROM education WHERE uid=$uid") or die(mysqli_error($con));
//Experience: expid, uid,employer,position,start,end, notes
$exp = mysqli_query($con, "SELECT * FROM experience WHERE uid=$uid") or die(mysqli_error($con));
//Skill: skillid,name,strength
$skill = mysqli_query($con,"SELECT * FROM skill WHERE uid=$uid") or die(mysqli_error($con));
?>
<!doctype html>
<html lang="en">

<!-- create-resume41:12-->
<head>
    <!-- Basic Page Needs
    ================================================== -->
    <title>Update Profile | BizLancer</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSS
    ================================================== -->
    <link rel="stylesheet" href="assets/plugins/css/plugins.css">

    <!-- Custom style -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" id="jssDefault" href="assets/css/colors/green-style.css">

</head>

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
        <div class="container">
            <h1>Manage Profile</h1>
        </div>
    </section>
    <div class="clearfix"></div>
    <!-- Header Title End -->

    <!-- General Detail Start -->
    <form method="post" action="" enctype="multipart/form-data">
        <div class="section detail-desc">
            <div class="container white-shadow">

                <div class="row">
                    <div class="detail-pic js">
                        <div class="box">
                            <input type="file" name="pic" id="upload-pic" class="inputfile"/>

                            <label for="upload-pic">
                                <?php
                                if($userImg!="assets/img/user.png"){
                                    ?>
                                    <img src="<?php echo $userImg;?>" data-toggle="tooltip" title="Click to upload new profile image" class="img-fluid">
                                    <?php
                                } else{
                                    ?>
                                    <i class="fa fa-upload uploadicon" aria-hidden="true" data-toggle="tooltip" title="Click to upload a profile image"></i><span></span>
                                    <?php
                                }
                                ?>
                            </label>
                            <a href="#" class="detail-edit" title="edit" onclick="$('#upload-pic').trigger('click');"><i class="fa fa-upload"></i></a>
                        </div>
                    </div>
                </div>

                <div class="row bottom-mrg">
                    <div class="col-xs-12 text-center">
                        <h2>Click <a href="resume-detail.php">here</a> to view your profile</h2>
                    </div>
                    <div class="col-md-10 col-sm-10">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Full Name" value="<?php echo $name;?>" name="name">
                        </div>
                    </div>

                    <div class="col-md-2 col-sm-2">
                        <div class="form-group">
                            <input type="number" class="form-control" placeholder="Total work experience (in years)" min="0" max="100" value="<?php echo $totalexp;?>" name="exp-total">
                        </div>
                    </div>


                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Professional Title (Designation)"
                                   name="designation" value="<?php echo $designation;?>">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <select class="form-control input-lg" name="category">
                                <option disabled>All Categories<?php echo $category;?></option>
                                <option value="<?php echo COMPANY_SOFTWARE; if($category==COMPANY_SOFTWARE){echo "\" selected=\"";} ?>">Software</option>
                                <option value="<?php echo COMPANY_HARDWARE; if($category==COMPANY_HARDWARE){echo "\" selected=\"";} ?>">Hardware</option>
                                <option value="<?php echo COMPANY_MECHANICAL; if($category==COMPANY_MECHANICAL){echo "\" selected=\"";} ?>">Mechanical</option>
                                <option value="<?php echo COMPANY_HR_MANAGEMENT; if($category==COMPANY_HR_MANAGEMENT){echo "\" selected=\"";} ?>">HR/Management</option>
                                <option value="<?php echo COMPANY_OTHER; if($category==COMPANY_OTHER){echo "\" selected=\"";} ?>">Other</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row bottom-mrg">
                    <div class="col-md-3 col-sm-3">
                        <div class="form-group checkbox">
                            <label><input type="checkbox" id="freelance-enable" name="freelance-enable" <?php if($freelancer==1) echo "checked";?>/>I want to freelance</label>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-3">
                        <div class="form-group">
                            <input class="form-control" type="number" name="minpay" id="minpay"
                                   placeholder="Min freelance pay (₹)">
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-3">
                        <div class="form-group">
                            <input class="form-control" type="number" name="maxpay" id="maxpay"
                                   placeholder="Max freelance pay (₹)">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <div class="form-group">
                            <select class="form-control" name="paytype" id="paytype">
                                <option value="<?php echo PAY_PER_HOUR; if($paytype==PAY_PER_HOUR){echo "\" selected=\"";} ?>">Hourly</option>
                                <option value="<?php echo PAY_PER_DAY; if($paytype==PAY_PER_DAY){echo "\" selected=\"";} ?>">Daily</option>
                                <option value="<?php echo PAY_PER_WEEK; if($paytype==PAY_PER_WEEK){echo "\" selected=\"";} ?>">Weekly</option>
                                <option value="<?php echo PAY_PER_MONTH; if($paytype==PAY_PER_MONTH){echo "\" selected=\"";} ?>">Monthly</option>
                                <option value="<?php echo PAY_PER_YEAR; if($paytype==PAY_PER_YEAR){echo "\" selected=\"";} ?>">Yearly</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row bottom-mrg">
                    <div class="col-md-12 col-sm-12">
                        <textarea class="form-control" placeholder="A brief introduction of yourself" name="brief"><?php echo $brief;?></textarea>
                    </div>
                </div>


                <div class="row no-padd">
                    <div class="detail pannel-footer">
                        <div class="col-md-12 col-sm-12">
                            <div class="detail-pannel-footer-btn pull-right">
                                <a href="#" class="footer-btn choose-cover">Change profile image</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- General Detail End -->

        <!-- full detail SetionStart-->
        <section class="full-detail">
            <div class="container">

                <div class="row bottom-mrg extra-mrg">

                    <h2 class="detail-title">Resume Content</h2>
                    <div class="col-md-12 col-sm-12">
                        <textarea class="form-control textarea" placeholder="Put your resume here" name="resume"><?php echo $resume; ?></textarea>
                    </div>


                </div>

                <div class="row bottom-mrg extra-mrg">

                    <h2 class="detail-title">General Information</h2>

                    <div class="col-md-6 col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                            <input type="text" class="form-control"
                                   placeholder="Update Email Address (login will change)" name="email" value="<?php echo $email;?>">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                            <input type="text" class="form-control" placeholder="Update Phone Number" name="phone" value="<?php echo $phone;?>">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-key"></i></span>
                            <input type="text" class="form-control" placeholder="Update Password" name="password">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-key"></i></span>
                            <input type="text" class="form-control" placeholder="Confirm Password" name="confirmPassword">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                            <input type="text" class="form-control" placeholder="Website Address" name="website" value="<?php echo $website;?>">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                            <input type="text" class="form-control" placeholder="Location: e.g., Mumbai"
                                   name="location" value="<?php echo $location;?>">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-birthday-cake"></i></span>
                            <input type="date" class="form-control" name="birthdate" value="<?php echo $birthdate; ?>">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-flag"></i></span>
                            <select class="form-control input-lg" name="country">
                                <option disabled>Select Country</option>
                                <option <?php if($country=='United Kingdom'){ echo "selected";}?>>United Kingdom</option>
                                <option <?php if($country=='United States'){ echo "selected";}?>>United States</option>
                                <option <?php if($country=='India'){ echo "selected";}?>>India</option>
                                <option <?php if($country=='Other'){ echo "selected";}?>>Other</option>
                            </select>
                        </div>
                    </div>


                </div>

                <div class="row bottom-mrg extra-mrg">

                    <h2 class="detail-title">Social Profile</h2>

                    <div class="col-md-6 col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-facebook"></i></span>
                            <input type="text" class="form-control" placeholder="Facebook profile link" name="facebook" value="<?php echo $fb;?>">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-google-plus"></i></span>
                            <input type="text" class="form-control" placeholder="Google Plus profile link" name="gplus" value="<?php echo $gp;?>">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-twitter"></i></span>
                            <input type="text" class="form-control" placeholder="Twitter profile link" name="twitter" value="<?php echo $tw;?>">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-instagram"></i></span>
                            <input type="text" class="form-control" placeholder="Instagram profile link" name="instagram" value="<?php echo $insta;?>">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-linkedin"></i></span>
                            <input type="text" class="form-control" placeholder="LinkedIn profile link" name="linkedin" value="<?php echo $lin;?>">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-dribbble"></i></span>
                            <input type="text" class="form-control" placeholder="Dribble profile link" name="dribble" value="<?php echo $drib;?>">
                        </div>
                    </div>


                </div>

                <div class="row bottom-mrg extra-mrg">

                    <h2 class="detail-title">Add Education</h2>
                    <?php
                    $n = mysqli_num_rows($edu);
                    while($edudata = mysqli_fetch_array($edu)){
                        $start = $edudata['start'];
                        $end = $edudata['end']
                        ?>
                        <div class="extra-field-box">
                            <div class="multi-box">
                                <div class="dublicat-box">
                                    <div class="col-md-12 col-sm-12">
                                        <input type="text" class="form-control"
                                               placeholder="School Name"
                                               name="edu-school[]" value="<?php echo $edudata['school'];?>">
                                    </div>

                                    <div class="col-md-12 col-sm-12">
                                        <input type="text" class="form-control"
                                               placeholder="Qualification" name="edu-qualification[]" value="<?php echo $edudata['qualification'];?>">
                                    </div>

                                    <div class="col-md-6 col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">Date From</span>
                                            <input type="date" class="form-control" name="edu-start[]" value="<?php echo $start;?>">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">Date To</span>
                                            <input type="date" class="form-control" name="edu-end[]" value="<?php echo $end;?>">
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                    <textarea class="form-control textarea"
                                              placeholder="Notes about this education (Hint: Put things here that make you stand out from the rest)"
                                              name="edu-notes[]"><?php echo $edudata['notes'];?></textarea>
                                    </div>

                                    <button type="button" class="btn remove-field">Remove</button>
                                </div>
                            </div>
                            <button type="button" class="add-field">Add field</button>
                        </div>
                        <?php
                    } if($n==0) {
                        ?>
                        <div class="extra-field-box">
                            <div class="multi-box">
                                <div class="dublicat-box">
                                    <div class="col-md-12 col-sm-12">
                                        <input type="text" class="form-control"
                                               placeholder="School Name"
                                               name="edu-school[]">
                                    </div>

                                    <div class="col-md-12 col-sm-12">
                                        <input type="text" class="form-control"
                                               placeholder="Qualification"
                                               name="edu-qualification[]">
                                    </div>

                                    <div class="col-md-6 col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">Date From</span>
                                            <input type="date" class="form-control" name="edu-start[]">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">Date To</span>
                                            <input type="date" class="form-control" name="edu-end[]">
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                    <textarea class="form-control textarea"
                                              placeholder="Notes about this education (Hint: Put things here that make you stand out from the rest)"
                                              name="edu-notes[]"></textarea>
                                    </div>

                                    <button type="button" class="btn remove-field">Remove</button>
                                </div>
                            </div>
                            <button type="button" class="add-field">Add field</button>
                        </div>
                        <?php
                    }
                    ?>
                </div>

                <div class="row bottom-mrg extra-mrg">

                    <h2 class="detail-title">Add Experience</h2>
                    <?php
                    $n = mysqli_num_rows($exp);
                    while($expdata = mysqli_fetch_array($exp)) {
                        $start = $expdata['start'];
                        $end = $expdata['end'];
                        ?>
                        <div class="extra-field-box">
                            <div class="multi-box">
                                <div class="dublicat-box">
                                    <div class="col-md-12 col-sm-12">
                                        <input type="text" class="form-control" placeholder="Employer"
                                               name="exp-employer[]" value="<?php echo $expdata['employer'];?>">
                                    </div>

                                    <div class="col-md-12 col-sm-12">
                                        <input type="text" class="form-control"
                                               placeholder="Position"
                                               name="exp-position[]" value="<?php echo $expdata['position'];?>">
                                    </div>

                                    <div class="col-md-6 col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">Date From</span>
                                            <input type="date" class="form-control" name="exp-start[]" value="<?php echo $start;?>">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">Date To</span>
                                            <input type="date" class="form-control" name="exp-end[]" value="<?php echo $end;?>">
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12">
                                    <textarea class="form-control textarea"
                                              placeholder="Notes about this experience (Hint: Put things here that make you stand out from the rest)"
                                              name="exp-notes[]"><?php echo $expdata['notes'];?></textarea>
                                    </div>

                                    <button type="button" class="btn remove-field">Remove</button>
                                </div>
                            </div>
                            <button type="button" class="add-field">Add field</button>
                        </div>
                        <?php
                    } if($n==0) {
                        ?>
                        <div class="extra-field-box">
                            <div class="multi-box">
                                <div class="dublicat-box">
                                    <div class="col-md-12 col-sm-12">
                                        <input type="text" class="form-control" placeholder="Employer"
                                               name="exp-employer[]">
                                    </div>

                                    <div class="col-md-12 col-sm-12">
                                        <input type="text" class="form-control"
                                               placeholder="Position"
                                               name="exp-position[]">
                                    </div>

                                    <div class="col-md-6 col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">Date From</span>
                                            <input type="date" class="form-control" name="exp-start[]">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">Date To</span>
                                            <input type="date" class="form-control" name="exp-end[]">
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12">
                                    <textarea class="form-control textarea"
                                              placeholder="Notes about this experience (Hint: Put things here that make you stand out from the rest)"
                                              name="exp-notes[]"></textarea>
                                    </div>

                                    <button type="button" class="btn remove-field">Remove</button>
                                </div>
                            </div>
                            <button type="button" class="add-field">Add field</button>
                        </div>
                        <?php
                    }
                    ?>
                </div>

                <div class="row bottom-mrg extra-mrg">

                    <h2 class="detail-title">Add Skills</h2>
                    <?php
                    $n = mysqli_num_rows($skill);
                    while($skilldata=mysqli_fetch_array($skill)) {
                        ?>
                        <div class="extra-field-box">
                            <div class="multi-box">
                                <div class="dublicat-box">
                                    <div class="col-md-12 col-sm-12">
                                        <input type="text" class="form-control" placeholder="Skills"
                                               name="skill-name[]" value="<?php echo $skilldata['name'];?>">
                                    </div>

                                    <div class="col-md-12 col-sm-12">
                                        <div class="input-group">
                                            <span class="input-group-addon">%</span>
                                            <input type="number" max="100" min="1" class="form-control"
                                                   placeholder="85%"
                                                   name="skill-strength[]" value="<?php echo $skilldata['strength'];?>">
                                        </div>
                                    </div>

                                    <button type="button" class="btn remove-field">Remove</button>
                                </div>
                            </div>
                            <button type="button" class="add-field">Add field</button>
                        </div>
                        <?php
                    } if($n==0){
                    ?>
                        <div class="extra-field-box">
                        <div class="multi-box">
                            <div class="dublicat-box">
                                <div class="col-md-12 col-sm-12">
                                    <input type="text" class="form-control" placeholder="Skills"
                                           name="skill-name[]">
                                </div>

                                <div class="col-md-12 col-sm-12">
                                    <div class="input-group">
                                        <span class="input-group-addon">%</span>
                                        <input type="number" max="100" min="1" class="form-control" placeholder="85%"
                                               name="skill-strength[]">
                                    </div>
                                </div>

                                <button type="button" class="btn remove-field">Remove</button>
                            </div>
                        </div>
                        <button type="button" class="add-field">Add field</button>
                    </div>
                    <?php } ?>

                </div>
                <div class="row bottom-mrg extra-mrg">

                    <div class="col-md-12">
                        <button class="btn btn-success btn-primary small-btn" type="submit" name="updateProfile">Update Profile</button>
                    </div>

                </div>
            </div>
        </section>
        <!-- full detail SetionStart-->

    </form>
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
    <!--<script type="text/javascript" src="assets/plugins/js/datedropper.min.js"></script>-->
    <script type="text/javascript" src="assets/plugins/js/dropzone.js"></script>
    <script type="text/javascript" src="assets/plugins/js/loader.js"></script>
    <script type="text/javascript" src="assets/plugins/js/owl.carousel.min.js"></script>
    <script type="text/javascript" src="assets/plugins/js/slick.min.js"></script>
    <script type="text/javascript" src="assets/plugins/js/gmap3.min.js"></script>
    <script type="text/javascript" src="assets/plugins/js/jquery.easy-autocomplete.min.js"></script>

    <!-- Custom Js -->
    <script src="assets/js/custom.js"></script>

    <script>
        $(document).ready(function () {
            if(document.getElementById('freelance-enable').checked == false){
                document.getElementById('minpay').disabled = true;
                document.getElementById('maxpay').disabled = true;
                document.getElementById('paytype').disabled = true;
            }
            document.getElementById('freelance-enable').onchange = function () {
                document.getElementById('minpay').disabled = !this.checked;
                document.getElementById('maxpay').disabled = !this.checked;
                document.getElementById('paytype').disabled = !this.checked;
            };
        });
    </script>
</div>
</body>

<!-- create-resume41:26-->
</html>