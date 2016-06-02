<?php
include("include/access.php");  
require_once 'PHPMailer/PHPMailerAutoload.php';
//$pid = $_SESSION['pid'];

$projectQuery = "Select * from projects";
$projectResult = mysqli_query($cxn, $projectQuery);
$projectRowNum = mysqli_num_rows($projectResult);
for($i = 0; $i < $projectRowNum; $i++)
{
	$projectRow = mysqli_fetch_assoc($projectResult);
	extract($projectRow);
	$pid = $project_id;
$query = "SELECT * from gp_relation, gu_relation, users, accounts, alertsetting where gp_relation.projectid = $pid and gp_relation.groupid = gu_relation.groupid and users.user_id = gu_relation.userid and users.user_id=accounts.account_userid and alertsetting.userid = users.user_id and alertsetting.projectid = $pid and alertsetting.activityid = 4 and alertsetting.status = 1";//Select * from users,accounts where users.user_id=accounts.account_userid and user_alert_daily=1";
$res = mysqli_query($cxn, $query);
while($row = mysqli_fetch_assoc($res)){
	$sigQuery = "Select * from pendingSig where emails like '%{$row['user_email']}%'";
	$sigRes = mysqli_query($cxn, $sigQuery);
	$docStr = "";
	while($sigRow = mysqli_fetch_assoc($sigRes)){
		$docStr .= $sigRow['docname']." ,";
	}
	if($docStr != ""){
		$docStr = substr($docStr, 0, -1);

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
		$mail->AddAddress($row['user_email']);

		$mail->Subject = 'Daily Notification';
		$mail->IsHTML(true);
		$mail->Body = "Hello {$row['account_firstname']} {$row['account_lastname']}. <br><br>"; 
		$mail->Body .= "You need to sign on {$docStr}.";
		
		if(!$mail->send()) {
		    echo 'Message could not be sent.';
		    echo 'Mailer Error: ' . $mail->ErrorInfo;
		}
		echo "Mail Sent to ".$row['user_email']."<br>";
	}
}

$weekquery = "SELECT * from gp_relation, gu_relation, users, accounts, alertsetting where gp_relation.projectid = $pid and gp_relation.groupid = gu_relation.groupid and users.user_id = gu_relation.userid and users.user_id=accounts.account_userid and alertsetting.userid = users.user_id and alertsetting.projectid = $pid and alertsetting.activityid = 5 and alertsetting.status = 1";//Select * from users,accounts where users.user_id=accounts.account_userid and user_alert_daily=1";
$weekres = mysqli_query($cxn, $weekquery);
while($row = mysqli_fetch_assoc($weekres)){

	$upTime = time() - 3 * 86400;
	$downTime = time() - 4 * 86400;
	$sigQuery = "Select * from pendingSig where emails like '%{$row['user_email']}%' and requesttime > $downTime and requesttime < $upTime";
	$sigRes = mysqli_query($cxn, $sigQuery);
	$docStr = "";
	while($sigRow = mysqli_fetch_assoc($sigRes)){
		$docStr .= $sigRow['docname']." ,";
	}
	if($docStr != ""){
		$docStr = substr($docStr, 0, -1);

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
		$mail->AddAddress($row['user_email']);

		$mail->Subject = 'Awaiting your signature';
		$mail->IsHTML(true);
		$mail->Body = "Hello {$row['account_firstname']} {$row['account_lastname']}. <br><br>"; 
		$mail->Body .= "3 days passed since you receive signature request for {$docStr}. <br>";
		$mail->Body .= "Please review them and sign.";
		
		if(!$mail->send()) {
		    echo 'Message could not be sent.';
		    echo 'Mailer Error: ' . $mail->ErrorInfo;
		}
		echo "Mail Sent to ".$row['user_email']."<br>";
	}

	$upTime = time() - 7 * 86400;
	$downTime = time() - 8 * 86400;
	$sigQuery = "Select * from pendingSig where emails like '%{$row['user_email']}%' and requesttime > $downTime and requesttime < $upTime";
	$sigRes = mysqli_query($cxn, $sigQuery);
	$docStr = "";
	while($sigRow = mysqli_fetch_assoc($sigRes)){
		$docStr .= $sigRow['docname']." ,";
	}
	if($docStr != ""){
		$docStr = substr($docStr, 0, -1);

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
		$mail->AddAddress($row['user_email']);

		$mail->Subject = 'Awaiting your signature';
		$mail->IsHTML(true);
		$mail->Body = "Hello {$row['account_firstname']} {$row['account_lastname']}. <br><br>"; 
		$mail->Body .= "7 days passed since you receive signature request for {$docStr}. <br>";
		$mail->Body .= "Please review them and sign.";
		
		if(!$mail->send()) {
		    echo 'Message could not be sent.';
		    echo 'Mailer Error: ' . $mail->ErrorInfo;
		}
		echo "Mail Sent to ".$row['user_email']."<br>";
	}
}
}

//Schedule

$scheduleQuery = "Select distinct * from schedules, users, accounts, projects where schedules.user_id = users.user_id and schedules.user_id = accounts.account_userid and (schedules.reminders7check = 1 or schedules.reminders30check = 1) and schedules.project_id = projects.project_id";
$scheduleResult = mysqli_query($cxn, $scheduleQuery);
$scheduleRowNum = mysqli_num_rows($scheduleResult);
date_default_timezone_set('Europe/London');
for($i = 0; $i < $scheduleRowNum; $i++)
{
	$scheduleRow = mysqli_fetch_assoc($scheduleResult);
	extract($scheduleRow);

	if($reminders7check == 1 && $revised_date != '') {
		
		$from = strtotime($revised_date);
		$today = time();
		$difference = floor(($from - $today) / (60 * 60 * 24));

		if ($difference == 7) {
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
			$mail->AddAddress($user_email);

			$mail->Subject = 'Reminder! 7 Days from an event in Project {$project_name}';
			$mail->IsHTML(true);
			$mail->Body = "Dear {$account_firstname} {$account_lastname}. <br><br>"; 
			$mail->Body .= "This is an automated reminder to inform you that {$event} is now 7 days away from the due date. Please visit <a href='http://interbuild.co'>InterBuild</a> in order to check the progress of your project or make changes.<br>";
						
			if(!$mail->send()) {
			    echo 'Message could not be sent.';
			    echo 'Mailer Error: ' . $mail->ErrorInfo;
			}
			echo "Mail Sent to ".$user_email."<br>";
		}
	}
	if($reminders30check == 1 && $revised_date != '') {
		$from = strtotime($revised_date);
		$today = time();
		$difference = floor(($from - $today) / (60 * 60 * 24));
		if ($difference == 30) {
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
			$mail->AddAddress($user_email);

			$mail->Subject = 'Reminder! 30 Days from an event in Project {$project_name}';
			$mail->IsHTML(true);
			$mail->Body = "Dear {$account_firstname} {$account_lastname}. <br><br>"; 
			$mail->Body .= "This is an automated reminder to inform you that {$event} is now 30 days away from the due date. Please visit <a href='http://interbuild.co'>InterBuild</a> in order to check the progress of your project or make changes.<br>";
			
			if(!$mail->send()) {
			    echo 'Message could not be sent.';
			    echo 'Mailer Error: ' . $mail->ErrorInfo;
			}
			echo "Mail Sent to ".$user_email."<br>";
		}
	}
}
?>