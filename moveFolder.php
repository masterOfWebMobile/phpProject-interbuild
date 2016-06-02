<?php
session_start();
include_once('include/access.php');
$pid = $_SESSION['pid'];
$docid = $_GET['docid'];
$folid = $_GET['folid'];
$deluq = "Update documents set folderid=$folid where document_id=$docid";
$dures = mysqli_query($cxn, $deluq);

$uquery = "Select * from accounts where account_userid={$_SESSION['userid']}";
$ures = mysqli_query($cxn, $uquery);
$urow = mysqli_fetch_assoc($ures);
$detail = $urow['account_firstname']." ".$urow['account_lastname']." has moved Document". $durow['document_name'];
$logQuery = "Insert into `logs` (`id`,`projectid`,`detail`,`time`) values (NULL,$pid,'{$detail}','".time()."')";
mysqli_query($cxn,$logQuery);

$_SESSION['success']="Document Moved Successfully.";
header("Location: documents.php?projectid=$pid");
?>