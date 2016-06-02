<?php
session_start();
include("include/access.php");

$id = $_POST["id"];

$projectname = $_POST["projectname"];
$projectname = addslashes($projectname);

$projectnumber = $_POST["projectnumber"];
$projectnumber = addslashes($projectnumber);

$status = $_POST["status"];

$type = $_POST["type"];
$fundingsources = $_POST["fundingsources"];

$district = $_POST["district"];
$district = addslashes($district);

$fiscalyear = $_POST["fiscalyear"];
$fiscalyear = addslashes($fiscalyear);

$workforce = $_POST["workforce"];
$workforce = addslashes($workforce);

$projectobjective = $_POST["projectobjective"];
$projectobjective = addslashes($projectobjective);

$specialconditions = $_POST["specialconditions"];
$specialconditions = addslashes($specialconditions);

$location = $_POST["location"];
$location = addslashes($location);

$description = $_POST["description"];
$description = addslashes($description);

$action = $_POST["action"];

$userid = $_SESSION['userid'];

$dt = new DateTime();
$updatetime = $dt->format('Y-m-d H:i:s');
$_SESSION['project_action'] = $action;

if($action == 'new')
{
  $query = "INSERT INTO projects (`project_mostrecentactivity`,`project_name`, `project_number`, `project_location`, `project_desc`, `project_status`, `project_type`, `project_fundingsources`, `project_district`, `project_fiscalyear`, `project_workforce`, `project_objective`, `project_specialconditions`) VALUES ('$updatetime','$projectname', '$projectnumber', '$location', '$description', '$status', '$type', '$fundingsources', '$district', '$fiscalyear', '$workforce', '$projectobjective', '$specialconditions');"; 
  
mysqli_query($cxn, $query);  
  
$getprojectidquery="SELECT MAX(project_id) AS maxprojectid FROM projects";
$getprojectidresult = mysqli_query($cxn,$getprojectidquery);
$getprojectidrow=mysqli_fetch_assoc($getprojectidresult);
if($getprojectidrow != null)
extract($getprojectidrow);
$id = $maxprojectid;

$upquery = "INSERT INTO userid_projectid (up_userid, up_projectid) VALUES ($userid, $id);"; 

mysqli_query($cxn, $upquery);

$userquery = "Select * from users,accounts where users.user_id=$userid and users.user_id=accounts.account_userid";
$userresult = mysqli_query($cxn, $userquery);
$userrow = mysqli_fetch_assoc($userresult);

$gquery = "INSERT INTO groups (`name`, `type`, `otherType`) VALUES ('{$userrow['account_organization']}','{$userrow['account_organization_type']}','{$userrow['account_organization_othertype']}')";
mysqli_query($cxn, $gquery);
$gid = mysqli_insert_id($cxn);

$guquery = "INSERT INTO gu_relation (`groupid`,`userid`, `role`) VALUES ($gid, $userid, 1)";
mysqli_query($cxn, $guquery);

for($x = 1; $x < 6; $x++){
    $alertInsertQuery = "INSERT INTO `intevxyy_interbuild`.`alertsetting` (`id`, `projectid`, `userid`, `activityid`, `status`) VALUES (NULL, '{$id}', '{$userid}', '{$x}', 0);";
    mysqli_query($cxn, $alertInsertQuery);
}

$gpquery = "INSERT INTO gp_relation (`projectid`,`groupid`) VALUES ($id, $gid)";
mysqli_query($cxn, $gpquery);

$gfquery = "INSERT INTO gf_relation (`groupid`,`folderid`) VALUES ($gid, 1)";
mysqli_query($cxn, $gfquery);

$gfquery = "INSERT INTO gf_relation (`groupid`,`folderid`) VALUES ($gid, 2)";
mysqli_query($cxn, $gfquery);

$gfquery = "INSERT INTO gf_relation (`groupid`,`folderid`) VALUES ($gid, 3)";
mysqli_query($cxn, $gfquery);

$gfquery = "INSERT INTO gf_relation (`groupid`,`folderid`) VALUES ($gid, 4)";
mysqli_query($cxn, $gfquery);
}
elseif ($action == 'update') {
  $query = "UPDATE projects SET project_mostrecentactivity = '$updatetime', project_name = '$projectname', project_number = '$projectnumber', project_location = '$location', project_desc = '$description', project_status = '$status', project_type = '$type', project_fundingsources = '$fundingsources', project_district = '$district', project_fiscalyear = '$fiscalyear', project_workforce = '$workforce', project_objective = '$projectobjective', project_specialconditions = '$specialconditions' WHERE project_id = $id"; 
  
  mysqli_query($cxn, $query);
}
else
{
  $query = "UPDATE projects SET account_firstname = '$firstname', account_lastname = '$lastname', account_organization = '$organization', account_title = '$title', account_workphone = '$workphone', account_mobilephone = '$mobilephone' WHERE account_id = $id"; 
  
  mysqli_query($cxn, $query);
}


//echo $query;




$_SESSION['success']=$projectname;
header("Location:project.php?projectid=$id");

?>