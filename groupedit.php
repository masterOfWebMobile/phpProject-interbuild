<?php
session_start();
include_once('include/access.php');
$folders = split(",", $_POST['folderid']);
$gid = $_POST['gid'];
$gName = $_POST['gName'];
$gType = $_POST['gType'];
$oType = $_POST['otherTName'];
$gquery = "update `intevxyy_interbuild`.`groups` set name='{$gName}', type='{$gType}', otherType='{$oType}' where id={$gid}";
mysqli_query($cxn, $gquery);

$pid = $_SESSION['pid'];
$gf_delquery = "Delete from `gf_relation` where groupid=$gid";
mysqli_query($cxn, $gf_delquery);

$fquery = "INSERT INTO `gf_relation` (`id`,`groupid`,`folderid`) VALUES ";
$fins = "";
for($i=1;$i<count($folders);$i++){
	$fins.="(NULL,$gid,{$folders[$i]}),";
}
if($fins != ""){
	mysqli_query($cxn, $fquery.substr($fins,0,-1));
}

$_SESSION['success']="Group edited successfully.";
header("Location: groups.php?projectid=$pid");
?>	