<?php
session_start();
$_SESSION['fw']= "http://localhost".$_SERVER['PHP_SELF'];
if(isset($_COOKIE['email']) && isset($_COOKIE['password'])){
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = md5($_POST['password']);
    $loginQuery = "SELECT * FROM user WHERE email='$email' AND password='$password'";
    $loginResult = mysqli_query($con, $loginQuery);
    if (mysqli_num_rows($loginResult) == 1) {
        if(isset($_POST['remember']) && $_POST['remember']==true){
            setcookie("email",$email,time()+86400*10);
            setcookie("pass", $password, time()+86400*10);
        }
        $loginData = mysqli_fetch_array($loginResult);
        $_SESSION['uid']= $loginData['uid'];
    }
}
if(!isset($_SESSION['uid'])){
    header("location:login.php");
}
/*function getCid($con, $uid){
    $cidQuery = "SELECT cid FROM company WHERE uid=$uid";
    $cidResult = mysqli_query($con,$cidQuery);
    if(mysqli_num_rows($cidResult)==0) {
        return -1;
    }
    $cidRow = mysqli_fetch_array($cidResult);
    return $cidRow['cid'];
}*/

function getCidFromJid($con, $jid){
    $cidQuery = "SELECT cid FROM job WHERE jid=$jid";
    $cidResult = mysqli_query($con,$cidQuery) or die(mysqli_error($con));
    while($cidData = mysqli_fetch_array($cidResult)){
        return $cidData['cid'];
    }
    return 0;
}

/*function getUidFromCid($con,$cid){
    $uidQuery = "SELECT uid FROM company WHERE cid=$cid";
    $uidResult = mysqli_query($con,$uidQuery) or die(mysqli_error($con));
    while($uidData = mysqli_fetch_array($uidResult)){
        return $uidData['uid'];
    }
    return 0;
}*/

function authenticateJobManager($con,$uid,$jid){
    if(getCidFromJid($con,$jid)==$uid){
        return 1;
    } else{
        return 0;
    }
}

function userExists($con,$uid){
    $uidQuery = "SELECT uid FROM user WHERE uid=$uid";
    $uidResult = mysqli_query($con, $uidQuery) or die(mysqli_error($con));
    if (mysqli_num_rows($uidResult) == 0) {
        return 0;
    }
    return 1;
}
?>