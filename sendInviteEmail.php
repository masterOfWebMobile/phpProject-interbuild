<?php
session_start();
include_once('include/access.php');
require_once 'PHPMailer/PHPMailerAutoload.php';
$pid = $_SESSION['pid'];
$userid = $_GET['userid'];

$userquery = "SELECT * from users where user_id = $userid";
$userresult = mysqli_query($cxn, $userquery);
$userrow = mysqli_fetch_assoc($userresult);
if($userrow != null)
extract($userrow);

$emailCheckQuery = "SELECT * from users where user_email = '{$user_email}'";
$emailCheckResult = mysqli_query($cxn, $emailCheckQuery);
$emailCheckRows = mysqli_num_rows($emailCheckResult);
$emailCheckRow=mysqli_fetch_assoc($emailCheckResult);
$status = $emailCheckRow;
if ($emailCheckRows == 0 || $status['user_status'] == 0) {
//mail($user_email, 'LinkForUserInfo', $_SERVER['SERVER_ADDR'].'createusercompletion.php?userid='.$userid);
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
$mail->AddAddress($user_email);
//$mail->AddAddress("supertech930@gmail.com");

$mail->Subject = 'Invitation from InterBuild';
$mail->IsHTML(true);
$mail->Body = 'Please visit the following link'.' <a href="http://'.$_SERVER['SERVER_NAME'].'/createusercompletion.php?userid='.$userid.'">Accept Invitation'.'</a>';  


if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}

$_SESSION['success']="User Invitation Sent Successfully.";

}
else{
    if ($status['user_status'] == 1)
    {
    	$_SESSION['success']="User Already Active.";
    }
}

header("Location: groups.php?projectid=$pid");
?>