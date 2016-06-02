<?php
session_start();
include_once('include/access.php');
$pid = $_SESSION['pid'];
$userid = $_GET['userid'];
$groupid = $_GET['groupid'];

$deluq = "Select * from accounts where account_userid=$userid";
$dures = mysqli_query($cxn, $deluq);
$durow = mysqli_fetch_assoc($dures);
$userquery = "DELETE from gu_relation where userid = $userid and groupid = $groupid";
$userresult = mysqli_query($cxn, $userquery);

$uquery = "Select * from accounts where account_userid={$_SESSION['userid']}";
$ures = mysqli_query($cxn, $uquery);
$urow = mysqli_fetch_assoc($ures);
$detail = $urow['account_firstname']." ".$urow['account_lastname']." has removed ".$durow['account_firstname']." ".$durow['account_lastname'];
$logQuery = "Insert into `logs` (`id`,`projectid`,`detail`,`time`) values (NULL,$pid,'{$detail}','".time()."')";
mysqli_query($cxn,$logQuery);

$_SESSION['success']="User Deleted Successfully.";
header("Location: groups.php?projectid=$pid");
?>