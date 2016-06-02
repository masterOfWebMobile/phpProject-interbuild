<?php
session_start();
include("include/access.php");
$query = "Select * from folders where folder_id={$_POST['did']}";
$qresult = mysqli_query($cxn, $query);
$row = mysqli_fetch_assoc($qresult);
//unlink($_SERVER['DOCUMENT_ROOT']."/signed/".$row['document_name']);
//$query = "delete from documents where document_id={$_POST['did']}";
$query = "update folders set folder_deleted = 1 where folder_id={$_POST['did']}";
mysqli_query($cxn, $query);
$query = "update documents set document_deleted = 1 where folderid={$_POST['did']}";
mysqli_query($cxn, $query);

$uquery = "Select * from accounts where account_userid={$_SESSION['userid']}";
$ures = mysqli_query($cxn, $uquery);
$urow = mysqli_fetch_assoc($ures);
$detail = $urow['account_firstname']." ".$urow['account_lastname']." has deleted ".$row['folder_name']." folder";
$logQuery = "Insert into `logs` (`id`,`projectid`,`detail`,`time`) values (NULL,$pid,'{$detail}','".time()."')";
mysqli_query($cxn,$logQuery);

echo "Success";
?>