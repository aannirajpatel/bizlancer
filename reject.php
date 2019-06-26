<?php
require('includes/auth.php');
require('includes/db.php');
require('includes/constants.php');

if(isset($_GET['jid']) && isset($_GET['uid'])){
    $jid = $_GET['jid'];
    $uid = $_GET['uid'];
    $checkJobAuth = "SELECT company.cid FROM job,company,`user` WHERE job.cid=company.cid AND company.cid=user.uid AND job.jid=$jid AND user.uid=".$_SESSION['uid'];
    $checkJobAuthResult = mysqli_query($con, $checkJobAuth) or die(mysqli_error($con));
    if(mysqli_num_rows($checkJobAuthResult) == 0){
        //Auth fails
        header_remove();
        header("location:404.php");
    }
    $rejectQuery = mysqli_query($con, "UPDATE application SET status=".CANDIDATE_REJECTED." WHERE uid=$uid AND jid=$jid") or die(mysqli_error($con));
    header_remove();
    header("location:manage-candidate.php?jid=$jid");
} else{
    header_remove();
    header("location:404.php");
}