<?php 
session_start();
include("include/access.php");  
require_once 'PHPMailer/PHPMailerAutoload.php';
 $pid = $_SESSION['pid'];
$undertype = $_POST['undertype']; 
$project= $_POST['project']; 
$folder = $_POST['folder'];  


$gpquery = "SELECT * from gp_relation, gu_relation, users, alertsetting where gp_relation.projectid = $pid and gp_relation.groupid = gu_relation.groupid and users.user_id = gu_relation.userid and alertsetting.userid = users.user_id and alertsetting.projectid = $pid and alertsetting.activityid = 1 and alertsetting.status = 1";
$gpresult = mysqli_query($cxn, $gpquery);
$gpnum = mysqli_num_rows($gpresult);
$users = array();
for($j=0;$j<$gpnum; $j++){
	$gprow = mysqli_fetch_assoc($gpresult);
	$users[$j] = $gprow['user_email'];
}
for($i=0; $i<count($_FILES['upload']['name']); $i++){
	
    $file_name = $_FILES['upload']['name'][$i];
    $file_name = str_replace(' ', '_', $file_name);
    $file_tmp =$_FILES['upload']['tmp_name'][$i];
	
	$newfile_name = $file_name;

	move_uploaded_file($file_tmp,"signed/".$newfile_name);

	$time = time();

	$upquery = "INSERT INTO `documents` ( `document_undertype`, `document_underid`, `document_name`, `document_location`, `projectid`, `folderid`, `doctype`, `cdate`) VALUES ('', '', '$newfile_name', 'signed/$newfile_name','$project','$folder',2,$time);"; 
	mysqli_query($cxn, $upquery);

	$uquery = "Select * from accounts where account_userid={$_SESSION['userid']}";
	$ures = mysqli_query($cxn, $uquery);
	$urow = mysqli_fetch_assoc($ures);
	$detail = $urow['account_firstname']." ".$urow['account_lastname']." has added ".$newfile_name." document";
	$logQuery = "Insert into `logs` (`id`,`projectid`,`detail`,`time`) values (NULL,$pid,'{$detail}','".time()."')";
	mysqli_query($cxn,$logQuery);
	
	/*$gpquery = "SELECT * from gp_relation, gu_relation where projectid = $pid and gp_relation.groupid = gu_relation.groupid";
	$gpresult = mysqli_query($cxn, $gpquery);
	$gpnum = mysqli_num_rows($gpresult);
	$users = array();
	for($i=0;$i<$gpnum; $i++){
	  	$gprow = mysqli_fetch_assoc($gpresult);
	  	$userid = $gprow['userid'];
	  	$userquery = "SELECT * from users where user_id = $userid and user_alert_doc = 1";
	  	$userresult = mysqli_query($cxn, $userquery);
	  	$userrow = mysqli_fetch_assoc($userresult);*/
	  	//if(mysqli_num_rows($userresult) > 0) {
	  	$projectQuery = "Select * from projects where project_id = $pid";
		$projectResult = mysqli_query($cxn, $projectQuery);
		$projectRow = mysqli_fetch_assoc($projectResult);

	  	for($k=0;$k<$gpnum; $k++){
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
			//$mail->AddAddress("franky0930@hotmail.com");
			$mail->AddAddress($users[$k]);//$userrow['user_email']);

			$mail->Subject = 'Notification from InterBuild';
			$mail->IsHTML(true);

			

			$mail->Body = 'Document '.$newfile_name.' is added to '. $projectRow['project_name'] .' successfully!';  
			
			if(!$mail->send()) {
			    echo 'Message could not be sent.';
			    echo 'Mailer Error: ' . $mail->ErrorInfo;
			}
		  	
		
	}
}
$_SESSION['success']="File has been uploaded.";
header("Location: documents.php?projectid=$project");

?>

