<?php
session_start();
include_once('include/access.php');
require_once 'PHPMailer/PHPMailerAutoload.php';

$pid = $_SESSION['pid'];
$folders = split(",", $_POST['folderid']);
$gName = $_POST['gName'];
$gType = $_POST['gType'];
$oType = $_POST['otherTName'];
$gquery = "INSERT INTO `intevxyy_interbuild`.`groups` (`id`, `name`, `type`, `otherType`) VALUES (NULL, '{$gName}', '{$gType}', '{$oType}');";
mysqli_query($cxn, $gquery);
$gid = mysqli_insert_id($cxn);
$pid = $_SESSION['pid'];
$rquery = "INSERT INTO `intevxyy_interbuild`.`gp_relation` (`id`,`projectid`,`groupid`) VALUES (NULL, {$pid},{$gid});";
mysqli_query($cxn, $rquery);
$fquery = "INSERT INTO `gf_relation` (`id`,`groupid`,`folderid`) VALUES ";
$fins = "";
for($i=1;$i<count($folders);$i++){
	$fins.="(NULL,$gid,{$folders[$i]}),";
}
if($fins != ""){
	mysqli_query($cxn, $fquery.substr($fins,0,-1));
}
$uquery = "Select * from accounts where account_userid={$_SESSION['userid']}";
$ures = mysqli_query($cxn, $uquery);
$urow = mysqli_fetch_assoc($ures);
$detail = $urow['account_firstname']." ".$urow['account_lastname']." has created ".$gName." group";
$logQuery = "Insert into `logs` (`id`,`projectid`,`detail`,`time`) values (NULL,$pid,'{$detail}','".time()."')";
mysqli_query($cxn,$logQuery);

$userquery = "SELECT distinct users.user_email as user_email from users,gp_relation, gu_relation, alertsetting where gp_relation.projectid = $pid and gp_relation.groupid = gu_relation.groupid and users.user_id = gu_relation.userid and alertsetting.userid = users.user_id and alertsetting.projectid = $pid and alertsetting.activityid = 2 and alertsetting.status = 1";
$userresult = mysqli_query($cxn, $userquery);


$projectQuery = "Select * from projects where project_id = $pid";
$projectResult = mysqli_query($cxn, $projectQuery);
$projectRow = mysqli_fetch_assoc($projectResult);


while ($userrow = mysqli_fetch_assoc($userresult)){
	//var_dump("useremail= ". $userrow['user_email']);
	//exit;
	$mail = new PHPMailer();
	$mail->isSMTP(); 
	//$mail->Host = 'server174.web-hosting.com';
	//$mail->Port = 465;
	$mail->Host = 'mail.interbuild.co';
	$mail->Port = 26;
	$mail->SMTPAuth = true;     // turn on SMTP authentication
	$mail->Username = 'welcome@interbuild.co';  // a valid email here
	$mail->Password = '7o4$tz[G,*_]';
	$mail->SMTPSecure = 'tls'; 

	$mail->From = 'welcome@interbuild.co';
	$mail->AddReplyTo('welcome@interbuild.co', 'InterBuild');


	$mail->FromName = 'InterBuild';
	$mail->AddAddress($userrow['user_email']);
	//$mail->AddAddress("supertech930@gmail.com");

	$mail->Subject = 'Notification from InterBuild';
	$mail->IsHTML(true);

	$mail->Body = 'Group '.$gName.' is added to '. $projectRow['project_name'] .' successfully!';  

	if(!$mail->send()) {
	    echo 'Message could not be sent.';
	    echo 'Mailer Error: ' . $mail->ErrorInfo;
	}
  
}


$_SESSION['success']="Group created successfully.";
header("Location: groups.php?projectid=$pid");
?>