<?php
session_start();
include("include/access.php"); 
require_once 'vendor/autoload.php';
require_once 'PHPMailer/PHPMailerAutoload.php';
$pid = $_SESSION['pid']; 
$query = "Select * from pendingSig where projectid = ".$_SESSION['pid'];
$qresult = mysqli_query($cxn, $query);
while($row = mysqli_fetch_array($qresult)){
	$client = new HelloSign\Client($apikey);
	$signature_request = $client->getSignatureRequest($row['requestid']);
	if($signature_request->is_complete){
		
		$time = time();
		$client->getFiles($row['requestid'], $_SERVER['DOCUMENT_ROOT']."/signed/".$row['docname'], HelloSign\SignatureRequest::FILE_TYPE_PDF);
		$dquery = "INSERT INTO `intevxyy_interbuild`.`documents` (`document_id`, `document_undertype`, `document_underid`, `document_name`, `document_location`, `projectid`,`folderid`,`doctype`, `cdate`,`document_signed`) VALUES (NULL, '','', '{$row['docname']}', '"."signed/".$row['docname']."', '{$row['projectid']}','{$row['doctype']}', 0, $time, 1)";
		mysqli_query($cxn, $dquery);
		$did = mysqli_insert_id($cxn);
		$atquery = "update `attachments` set documentid=$did where pendingid={$row['id']}";
		mysqli_query($cxn,$atquery);
		$dquery = "delete from pendingSig where id={$row['id']}";		
		mysqli_query($cxn, $dquery);

		$detail = "Document ".$row['docname']." has been signed";
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

				$mail->Subject = 'Document Signed';
				$mail->IsHTML(true);
				$mail->Body = 'Document '.$row['docname'] .' is signed successfully!'; 

				if(!$mail->send()) {
				    echo 'Message could not be sent.';
				    echo 'Mailer Error: ' . $mail->ErrorInfo;
				}
			  	
			
		}

		unlink($_SERVER['DOCUMENT_ROOT']."/files/".$row['docname']);
	} else {
		$signatures = $signature_request->getSignatures();
		$emails = $row['emails'];
		$temp = $emails;
        foreach ($signatures as $key => $signature) {
        	
          if($signature->getStatusCode()=="signed"){
            $temp = str_replace($signature->signer_email_address, '', $emails);
          }
        }
        if($temp != $emails){
        	$query = "update pendingSig set emails='{$temp}' where id = {$row['id']}";
        	mysqli_query($cxn, $query);
        }
	}
}
echo "Success";
?>
