<?php
require('includes/auth.php');
require 'includes/db.php';
require 'includes/constants.php';
if(!isset($_GET['jid']) || authenticateJobManager($con, $_SESSION['uid'], intval($_GET['jid']))) {
    header("location:404.php");
}
$jid = intval($_GET['jid']);
$deleteJobQuery = "DELETE FROM job WHERE jid=$jid";
$deleteJobResult = mysqli_query($con, $deleteJobQuery) or die(mysqli_error($con));
header_remove();
header("location:manage-job-listings.php");