<?php
session_start();
include_once('include/access.php');
$gid = $_GET['gid'];
$pid = $_SESSION['pid'];
//var_dump("group".$gid."pid".$pid);
//exit;
$gquery = "Select * from groups where id = $gid";
$gres = mysqli_query($cxn, $gquery);
$grow = mysqli_fetch_assoc($gres);
$query = "delete from `intevxyy_interbuild`.`groups` where id={$gid}";
mysqli_query($cxn,$query);
$uquery = "Select * from accounts where account_userid={$_SESSION['userid']}";
$ures = mysqli_query($cxn, $uquery);
$urow = mysqli_fetch_assoc($ures);
$detail = $urow['account_firstname']." ".$urow['account_lastname']." has deleted ".$grow['name']." group";
$logQuery = "Insert into `logs` (`id`,`projectid`,`detail`,`time`) values (NULL,$pid,'{$detail}','".time()."')";
mysqli_query($cxn,$logQuery);
header("Location: groups.php?projectid=$pid");
?>