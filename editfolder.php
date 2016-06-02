<?php
session_start();
include_once("include/access.php");
$fid = $_POST['fid'];
$fname = $_POST['fname'];
$fquery = "Update folders set folder_name='{$fname}' where folder_id=$fid";
mysqli_query($cxn, $fquery);
$gdelquery = "delete from gf_relation where folderid=$fid";
mysqli_query($cxn, $gdelquery);
$inquery = "Insert into gf_relation (groupid, folderid) VALUES ";
$inatt = "";
foreach($_POST as $key => $value){
	if(strpos($key, "g_") === 0){
		$gid = substr($key,2);
		$inatt .= "($gid, $fid),";
	}
}
if($inatt != ""){
	$inquery .= substr($inatt,0,-1);
	mysqli_query($cxn, $inquery);
}
header("Location: documents.php?projectid={$_SESSION['pid']}")
?>