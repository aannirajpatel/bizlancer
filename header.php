<?php
if(isset($_COOKIE['email']) && isset($_COOKIE['password']) && isset($con)){
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = md5($_POST['password']);
    $loginQuery = "SELECT * FROM user WHERE email='$email' AND password='$password'";
    $loginResult = mysqli_query($con, $loginQuery);
    if (mysqli_num_rows($loginResult) == 1) {
        if(isset($_POST['remember']) && $_POST['remember']=='Yes'){
            setcookie("email",$email,time()+86400*10);
            setcookie("pass", $password, time()+86400*10);
        }
        $loginData = mysqli_fetch_array($loginResult);
        $_SESSION['uid']= $loginData['uid'];
    }
}
if (!isset($_SESSION['uid'])) {
    ?>

    <nav class="navbar navbar-default navbar-fixed navbar-light white bootsnav">

        <div class="container">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                <i class="fa fa-bars"></i>
            </button>
            <!-- Start Header Navigation -->
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">
                    <img src="assets/img/logo.png" class="logo logo-scrolled" alt="">
                </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-menu">
                <ul class="nav navbar-nav navbar-left" data-in="fadeInDown" data-out="fadeOutUp">
                    <li class="active" id="searchForm">
                        <form class="search-form form-inline" method="" action="search.php">
                            <input type="text" class="form-control" placeholder="Find from 700+ freelancers">
                            <button class="btn btn-default" style="margin-bottom: 1rem;" type="button"><span
                                        class="fa fa-search"></span></button>
                        </form>
                    </li>
                    <li id="searchButton"><a href="search.php"><span class="fa fa-search"></span> Search on
                            BizLancer</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
                    <!--<li><a href="blog.html">Blog</a></li>-->
                    <li><a href="index.php">Home</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="help.php">Help</a></li>
                    <li class="left-br" id="loginModalToggle"><a href="#" data-toggle="modal" data-target="#signup"
                                                                 class="signin">Log In/Sign Up</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div>
    </nav>

    <?php
} else {
    if(getUserTypeFromTable($con,$_SESSION['uid']) == USER_CANDIDATE) {
        $newMessagesQuery = "SELECT count(*) AS totalnew FROM companymessage WHERE uidr=".$_SESSION['uid']." AND seen=0";
        $newMessagesResult = mysqli_query($con, $newMessagesQuery) or die(mysqli_error($con));
        $newMessagesData = mysqli_fetch_array($newMessagesResult);
        $newMessages = $newMessagesData['totalnew'];
        ?>
        <nav class="navbar navbar-default navbar-fixed navbar-light white bootsnav">

            <div class="container">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                    <i class="fa fa-bars"></i>
                </button>
                <!-- Start Header Navigation -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php">
                        <img src="assets/img/logo.png" class="logo logo-scrolled" alt="">
                    </a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-menu">
                    <ul class="nav navbar-nav navbar-left" data-in="fadeInDown" data-out="fadeOutUp">
                        <!--<li class="active" id="searchForm">
                            <form class="search-form form-inline" method="" action="search.php">
                                <input type="text" class="form-control" placeholder="Find from 700+ freelancers">
                                <button class="btn btn-default" style="margin-bottom: 1rem;" type="button"><span
                                            class="fa fa-search"></span></button>
                            </form>
                        </li>-->
                        <li id="searchButton"><a href="search.php"><span class="fa fa-search"></span> Search on
                                BizLancer</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
                        <!--<li><a href="blog.html">Blog</a></li>-->
                        <li><a href="manage-profile.php">Manage Profile</a></li>
                        <li><a href="user-messages.php">Messages <?php if($newMessages>0){?><span class="badge bg-danger"><?php echo $newMessages;?></span> <?php } ?></a></li>
                        <li><a href="search-job.php">Find Jobs</a></li>
                        <li><a href="manage-applications.php">Manage Applications</a></li>
                        <li><a href="help.php">Help</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div>
        </nav>
        <?php
    } else{
        $newMessagesQuery = "SELECT count(*) AS totalnew FROM companymessage WHERE uidr=".$_SESSION['uid']." AND seen=0";
        $newMessagesResult = mysqli_query($con, $newMessagesQuery) or die(mysqli_error($con));
        $newMessagesData = mysqli_fetch_array($newMessagesResult);
        $newMessages = $newMessagesData['totalnew'];
        ?>
        <nav class="navbar navbar-default navbar-fixed navbar-light white bootsnav">

            <div class="container">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                    <i class="fa fa-bars"></i>
                </button>
                <!-- Start Header Navigation -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php">
                        <img src="assets/img/logo.png" class="logo logo-scrolled" alt="">
                    </a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-menu">
                    <ul class="nav navbar-nav navbar-left" data-in="fadeInDown" data-out="fadeOutUp">
                        <li class="active" id="searchForm">
                            <form class="search-form form-inline" method="" action="search-freelancer.php">
                                <input type="text" class="form-control" placeholder="Find from 700+ freelancers" name="q">
                                <button class="btn btn-default" style="margin-bottom: 1rem;" type="button"><span
                                            class="fa fa-search"></span></button>
                            </form>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
                        <!--<li><a href="blog.html">Blog</a></li>-->
                        <li><a href="create-job.php">Add Job Listing</a></li>
                        <li><a href="company-messages.php">Messages <?php if($newMessages>0){?><span class="badge bg-danger"><?php echo $newMessages;?></span> <?php } ?></a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle"
                               data-toggle="dropdown">Tools</a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="manage-job-listings.php">Manage Job Listings</a></li>
                                <li><a href="manage-company-profile.php">Company Profile</a></li>
                                <li><a href="manage-profile.php">Profile and Settings</a></li>
                                <li><a href="search-freelancer.php">Find Freelancers</a></li>
                                <li><a href="help.php">Help</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="logout.php">Logout</a>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div>
        </nav>
        <?php
    }
        ?>
    <?php
}
?>