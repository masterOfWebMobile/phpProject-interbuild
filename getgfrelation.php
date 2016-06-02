<?php
include_once("include/access.php");
$pid = $_POST['pid'];
$fid = $_POST['fid'];
$query = "Select gp_relation.groupid as id from gp_relation, gf_relation where gp_relation.groupid=gf_relation.groupid and gp_relation.projectid=$pid and gf_relation.folderid=$fid";
$qresult = mysqli_query($cxn, $query);
$res = array();
while($row=mysqli_fetch_assoc($qresult)){
	array_push($res, $row);
}
echo json_encode($res);
?>