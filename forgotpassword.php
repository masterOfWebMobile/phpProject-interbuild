<?php
session_start();
require_once 'PHPMailer/PHPMailerAutoload.php';
include_once('include/access.php');
$email = $_POST['email'];
$length = 10;

$randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);

$userpassword = md5($randomString);
$gquery = "UPDATE `intevxyy_interbuild`.`users` SET  user_password = '{$userpassword}' where user_email = '$email'";
$gresult = mysqli_query($cxn, $gquery);

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
//$mail->AddAddress("franky0930@hotmail.com");
$mail->AddAddress($email);

$mail->Subject = 'Resetting Password';
$mail->Body = 'Your Password is changed successfully to '.$randomString; 

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}

$_SESSION['success']="User Password Changed Successfully.";
header("Location: index.php");
?>