<?php
session_start();
include("include/access.php");

$id = $_SESSION['pid'];

$userid = $_SESSION['userid'];
$idarr = split(",", $_POST['idstr']);
$setstr = "";
$resetstr = "";
for($i=0; $i<5; $i++){
	if(isset($_POST['id_'.$idarr[$i]]) && $_POST['id_'.$idarr[$i]] == "1"){
		$setstr .= $idarr[$i].",";
	} else {
		$resetstr .= $idarr[$i].",";
	}
}
if($setstr != ""){
	$setstr = substr($setstr, 0, -1);
	$query = "UPDATE alertsetting SET status = 1 where id in (".$setstr.")"; 
	mysqli_query($cxn, $query);
}
if($resetstr != ""){
	$resetstr = substr($resetstr, 0, -1);
	$query = "UPDATE alertsetting SET status = 0 where id in (".$resetstr.")"; 
	mysqli_query($cxn, $query);
}
//echo $query;

$_SESSION['success']="Setting has been updated.";
header("Location:settings.php?projectid=$id");

?>