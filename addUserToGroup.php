<?php
session_start();
include_once('include/access.php');
$pid = $_SESSION['pid'];
$group = $_POST['groups'];
$user = $_POST['users'];


$userquery = "SELECT * from gu_relation where userid = $user and groupid = $group";
$userresult = mysqli_query($cxn, $userquery);
$rows = mysqli_num_rows($userresult);

if ($rows == 0) {
	$insertquery = "INSERT INTO gu_relation (`id`, `groupid`, `userid`) VALUES (null, '{$group}', '{$user}')";
	mysqli_query($cxn, $insertquery);
}

$_SESSION['success']="Add User To Group Successfully.";
header("Location: groups.php?projectid=$pid");
?>