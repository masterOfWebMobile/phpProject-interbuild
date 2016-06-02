<?php
session_start();
include("include/access.php"); 
require_once 'vendor/autoload.php';
require_once 'PHPMailer/PHPMailerAutoload.php';
$req = $_POST['reqid'];

$query = "Select * from pendingSig where requestid='$req'";

$result = mysqli_query($cxn, $query);
$row = mysqli_fetch_assoc($result);

$client = new HelloSign\Client($apikey);
$signature_request = $client->getSignatureRequest($req);

$signatures = $signature_request->getSignatures();
for($i=0; $i<count($signatures); $i++){
	if($signatures[$i]->getStatusCode() == "awaiting_signature")
	{
		$email = $signatures[$i]->getSignerEmail();


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
		$mail->AddAddress($email);

		$mail->Subject = 'Awaiting for your Signature';
		$mail->IsHTML(true);
		$mail->Body = 'You need to sign on Document '.$row['docname'];  
		
		if(!$mail->send()) {
		    echo 'Message could not be sent.';
		    echo 'Mailer Error: ' . $mail->ErrorInfo;
		}
	}
	
	
}
echo "Success";

?>