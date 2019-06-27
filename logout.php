<?php
session_start();
session_unset();
session_destroy();
setcookie("email","",time()-1);
setcookie("pass","",time()-1);
header("location:index.php");