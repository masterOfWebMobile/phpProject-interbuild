<?php
session_start();
include("include/access.php");  
$fname = $_POST['foldername'];
$pid = $_POST['pid'];
$gstr = "";
$garr = array();
foreach($_POST as $key => $value){
	if(strpos($key, "g_") === 0){
		if($key == "g_all"){
			$gstr.="0,";
		} else {
			array_push($garr, substr($key,2));
		}
	}
}
$gstr = substr($gstr, 0, -1);
$fquery = "Insert into folders (folder_id, folder_projectid, folder_name, groups) VALUES (NULL, '{$pid}', '{$fname}', '{$gstr}')";
$fresult = mysqli_query($cxn,$fquery);
$fid = mysqli_insert_id($cxn);
$gfquery = "Insert into gf_relation (groupid, folderid) VALUES ";
for($i=0;$i<count($garr);$i++){
	$gfqins .= "({$garr[$i]},$fid),";
}
if($gfqins != ""){
	mysqli_query($cxn, $gfquery.substr($gfqins,0, -1));	
}

$_SESSION['success']="Folder Created.";
header("Location: documents.php?projectid=$pid");
?>