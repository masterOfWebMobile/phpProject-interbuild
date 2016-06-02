<?php
require_once 'PHPMailer/PHPMailerAutoload.php';
include("include/access.php");

$projectQuery = "Select * from projects";
$projectResult = mysqli_query($cxn, $projectQuery);
$projectRowNum = mysqli_num_rows($projectResult);
for($i = 0; $i < $projectRowNum; $i++)
{
	$projectRow = mysqli_fetch_assoc($projectResult);
	extract($projectRow);
	$pid = $project_id;
	var_dump($pid);
	
}
exit;
//mail($user_email, 'LinkForUserInfo', $_SERVER['SERVER_ADDR'].'createusercompletion.php?userid='.$userid);
// $mail = new PHPMailer();
// $mail->isSMTP(); 
// //$mail->Host = 'server174.web-hosting.com';
// //$mail->Port = 465;
// $mail->Host = 'mail.interbuild.co';
// $mail->Port = 26;
// $mail->SMTPAuth = true;     // turn on SMTP authentication
// $mail->Username = 'welcome@interbuild.co';  // a valid email here
// $mail->Password = '7o4$tz[G,*_]';
// $mail->SMTPSecure = 'tls'; 

// $mail->From = 'welcome@interbuild.co';
// $mail->AddReplyTo('welcome@interbuild.co', 'InterBuild');


// $mail->FromName = 'InterBuild';
// $mail->AddAddress("franky0930@hotmail.com");
// $mail->AddAddress("supertech930@gmail.com");

// $mail->Subject = 'Resetting Password';
// $mail->Body = 'Your Password is changed successfully to '.$randomString; 

// if(!$mail->send()) {
//     echo 'Message could not be sent.';
//     echo 'Mailer Error: ' . $mail->ErrorInfo;
// }
?>