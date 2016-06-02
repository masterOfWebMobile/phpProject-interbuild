<?php
session_start();
include_once('include/access.php');
$pid = $_SESSION['pid'];
$docid = $_GET['docid'];
$docname = $_GET['docname'];
$docquery = "Select * from documents where document_id=$docid";
$docres = mysqli_query($cxn, $docquery);
$docrow = mysqli_fetch_assoc($docres);
$documenttemploc = str_replace($docrow['document_name'], $docname, $docrow['document_location']);
if (file_exists($documenttemploc)) {
	
}
else {
        rename($docrow['document_location'], $documenttemploc);
       
}
$deluq = "Update documents set document_name='$docname', document_location='$documenttemploc' where document_id=$docid";
$dures = mysqli_query($cxn, $deluq);

$uquery = "Select * from accounts where account_userid={$_SESSION['userid']}";
$ures = mysqli_query($cxn, $uquery);
$urow = mysqli_fetch_assoc($ures);
$detail = $urow['account_firstname']." ".$urow['account_lastname']." has changed Name of Document". $durow['document_name'];
$logQuery = "Insert into `logs` (`id`,`projectid`,`detail`,`time`) values (NULL,$pid,'{$detail}','".time()."')";
mysqli_query($cxn,$logQuery);

$_SESSION['success']="Document Name Has Been Changed Successfully.";
header("Location: documents.php?projectid=$pid");
?>