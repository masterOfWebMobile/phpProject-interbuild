<?php
session_start();
include_once('include/access.php');
$pid = $_SESSION['pid'];
$userid = $_POST['userid'];
$password = $_POST['password'];

$userpassword = md5($password);
$gquery = "UPDATE `intevxyy_interbuild`.`users` SET  user_password = '{$userpassword}' where user_id = '{$userid}';";
$gresult = mysqli_query($cxn, $gquery);

echo 'success';

$_SESSION['success']="User Password Changed Successfully.";
header("Location: groups.php?projectid=$pid");
?>