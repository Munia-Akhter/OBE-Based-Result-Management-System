<?php

session_start();
unset($_SESSION['username']);
session_destroy();
setcookie('user_id',$user_id,time()-1);
setcookie('pass',$password,time()-1);
header("location:login.php");
?>