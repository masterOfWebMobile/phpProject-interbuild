<?php
session_start();
include("include/access.php");
$req = $_POST['reqid'];
$projectid = $_POST['pid'];
$filename = $_POST['filename'];  
$doc_type = $_POST['doctype'];
$attids = $_POST['attids'];
$emails = $_POST['emails'];
$query = "INSERT INTO `intevxyy_interbuild`.`pendingSig` (`id`, `projectid`, `requestid`, `docname`, `path`, `doctype`, `emails`, `requesttime`) VALUES (NULL, '{$projectid}', '{$req}', '{$filename}', '','{$doc_type}','{$emails}',".time().")";

mysqli_query($cxn, $query);
$pid = mysqli_insert_id($cxn);
if($attids != ""){
	$atquery = "update `attachments` set pendingid=$pid where id in ($attids)";
	mysqli_query($cxn,$atquery);
}
$detail = "Document ".$filename." has been submitted for sign";
$logQuery = "Insert into `logs` (`id`,`projectid`,`detail`,`time`) values (NULL,$projectid,'{$detail}','".time()."')";
mysqli_query($cxn,$logQuery);
echo "success";
?>