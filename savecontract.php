<?php 
session_start();
include("include/access.php");  
require_once 'PHPMailer/PHPMailerAutoload.php';
$project = $_SESSION['pid'];
$time = time();
$pid = $_SESSION['pid'];
$projectname = $_POST['projectname'];  
$doc_type = $_POST['doctype'];
$type = array("", "contractstatus", "contractchangeorder", "dailyobservations", "fdot");
$searchString = str_replace(" ", "", $projectname) . '_' . $type[$doc_type] . '_';
$docNumForPDF = 1;
$docNumForSign = 1;
$getdocumentquery="SELECT * FROM documents where folderid = $doc_type and projectid = {$_SESSION['pid']} and document_name like '%".$searchString."%' order by LENGTH(document_name) desc, document_name desc";
$getdocumentresult = mysqli_query($cxn,$getdocumentquery);
$getdocumentrow=mysqli_fetch_assoc($getdocumentresult);
if($getdocumentrow != null)
extract($getdocumentrow);

if($document_name == '') {
	$docNumForPDF = 1;
  	//$docname = $projectname . "_" . $type[$doc_type] . "_1.pdf";
}
else
{
	$lastdocumentfirst_pos = strpos($document_name, '_');
	$lastdocumentsecond_pos = strpos($document_name, '_', $lastdocumentfirst_pos + 1);
	$lastdocumentnumber = substr($document_name, $lastdocumentsecond_pos + 1);
	$lastdocumentnumber = intval($lastdocumentnumber);
	$docNumForPDF = $lastdocumentnumber + 1;
	//$documentname = $projectname . '_' . $type[$doc_type] . '_' . $last . '.pdf';
}
$getsigndocumentquery="SELECT * FROM pendingSig where doctype = $doc_type and projectid = {$_SESSION['pid']} and docname like '%".$searchString."%' order by LENGTH(docname) desc, docname desc";
$getsigndocumentresult = mysqli_query($cxn,$getsigndocumentquery);
$getsigndocumentrow=mysqli_fetch_assoc($getsigndocumentresult);
if($getsigndocumentrow != null)
extract($getsigndocumentrow);

if($docname == '') {
	$docNumForSign = 1;
  	//$docname = $projectname . "_" . $type[$doc_type] . "_1.pdf";
}
else
{
	$lastdocumentfirst_pos = strpos($docname, '_');
	$lastdocumentsecond_pos = strpos($docname, '_', $lastdocumentfirst_pos + 1);
	$lastdocumentnumber = substr($docname, $lastdocumentsecond_pos + 1);
	$lastdocumentnumber = intval($lastdocumentnumber);
	$docNumForSign = $lastdocumentnumber + 1;
	//$docname = $projectname . '_' . $type[$doc_type] . '_' . $lastdocumentnumber . '.pdf';
}

if($docNumForPDF > $docNumForSign)
{

	$documentname = str_replace(" ", "", $projectname) . '_' . $type[$doc_type] . '_' . $docNumForPDF . '.pdf';
}
else {
	$documentname = str_replace(" ", "", $projectname) . '_' . $type[$doc_type] . '_' . $docNumForSign . '.pdf';
}




$upquery = "INSERT INTO `documents` ( `document_undertype`, `document_underid`, `document_name`, `document_location`, `projectid`, `folderid`, `doctype`, `cdate`) VALUES ('', '', '$documentname', 'files/$documentname','$project','$doc_type',1, $time);"; 
mysqli_query($cxn, $upquery);

$uquery = "Select * from accounts where account_userid={$_SESSION['userid']}";
$ures = mysqli_query($cxn, $uquery);
$urow = mysqli_fetch_assoc($ures);
$detail = $urow['account_firstname']." ".$urow['account_lastname']." has added ".$documentname." document";
$logQuery = "Insert into `logs` (`id`,`projectid`,`detail`,`time`) values (NULL,$project,'{$detail}','".time()."')";
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
		  	$userrow = mysqli_fetch_assoc($userresult);
		  	if(mysqli_num_rows($userresult) > 0) {*/
	$gpquery = "SELECT * from gp_relation, gu_relation, users, alertsetting where gp_relation.projectid = $pid and gp_relation.groupid = gu_relation.groupid and users.user_id = gu_relation.userid and alertsetting.userid = users.user_id and alertsetting.projectid = $pid and alertsetting.activityid = 1 and alertsetting.status = 1";
	$gpresult = mysqli_query($cxn, $gpquery);
	$gpnum = mysqli_num_rows($gpresult);
	
	$users = array();
	for($j=0;$j<$gpnum; $j++){
	$gprow = mysqli_fetch_assoc($gpresult);
	$users[$j] = $gprow['user_email'];

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
				$mail->AddAddress($users[$j]);//$userrow['user_email']);
				//$mail->AddAddress("supertech930@gmail.com");

				$mail->Subject = 'Notification from InterBuild';
				$mail->IsHTML(true);

				$projectQuery = "Select * from projects where project_id = $pid";
	            $projectResult = mysqli_query($cxn, $projectQuery);
	            $projectRow = mysqli_fetch_assoc($projectResult);
				$mail->Body = 'Document '.$documentname. ' is added to '. $projectRow['project_name'] .' successfully!'; 

				if(!$mail->send()) {
				    echo 'Message could not be sent.';
				    echo 'Mailer Error: ' . $mail->ErrorInfo;
				}
			  
			
		}

$_SESSION['success']="File save successfully.";
echo "success"
?>
