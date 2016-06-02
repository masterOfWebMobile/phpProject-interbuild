<?php
session_start();
require_once 'PHPMailer/PHPMailerAutoload.php';
include_once('include/access.php');

$profile_query = "Select * from accounts where account_userid = ".$_SESSION['userid'];
$profile_result = mysqli_query($cxn, $profile_query);
$profile_row = mysqli_fetch_assoc($profile_result);

$pid = $_SESSION['pid'];

$user_firstname = $_POST['userfirstname'];
$user_secondname = $_POST['userlastname'];
$id = $_POST['usergroup'];
$user_role = $_POST['userrole'];
$user_email = $_POST['useremailaddress'];
$roles = array("Administrator", "Collaborate", "Limited");
$k = array_search($user_role, $roles);
$k = $k + 1;

//var_dump("riu".$user_role);
//exit;
$groupquery = "Select * from `intevxyy_interbuild`.`groups` where id = '{$id}';";
$groupresult = mysqli_query($cxn, $groupquery);
$grouprow = mysqli_fetch_assoc($groupresult);
if($grouprow != null)
extract($grouprow);

$emailCheckQuery = "SELECT * from users where user_email = '{$user_email}'";
$emailCheckResult = mysqli_query($cxn, $emailCheckQuery);
$emailCheckRows = mysqli_num_rows($emailCheckResult);

$projectQuery = "Select * from projects where project_id = $pid";
$projectResult = mysqli_query($cxn, $projectQuery);
$projectRow = mysqli_fetch_assoc($projectResult);

$_SESSION['project_action'] = 'user';

$added = false;

if ($emailCheckRows == 0) {
//mail('eriklouis129@hotmail.com', 'this', 'this');
//mail($user_email, 'LinkForUserInfo', $_SERVER['SERVER_ADDR'].'createusercompletion.php?userid='.$userid);
    $gquery = "INSERT INTO `intevxyy_interbuild`.`users` (`user_id`, `user_email`, `user_superadmin`, `level`) VALUES (NULL, '{$user_email}', 0, '{$k}');";
    mysqli_query($cxn, $gquery);
    $user_inserted_id = mysqli_insert_id($cxn);

    for($x = 1; $x < 6; $x++){
        $alertInsertQuery = "INSERT INTO `intevxyy_interbuild`.`alertsetting` (`id`, `projectid`, `userid`, `activityid`, `status`) VALUES (NULL, '{$pid}', '{$user_inserted_id}', '{$x}', 0);";
        mysqli_query($cxn, $alertInsertQuery);
    }


    $uquery = "INSERT INTO `intevxyy_interbuild`.`accounts` (`account_id`,`account_userid`,`account_firstname`, 
        `account_lastname`, `account_organization`, `account_organization_type`, `account_organization_othertype`) VALUES (null, '{$user_inserted_id}', '{$user_firstname}', '{$user_secondname}', 
        '{$name}', '{$type}', '{$otherType}');";
    mysqli_query($cxn, $uquery);

    $tempquery = "Select * from `intevxyy_interbuild`.`accounts` where account_userid = '{$user_inserted_id}';";
    $tempresult = mysqli_query($cxn, $tempquery);
    $temprow = mysqli_fetch_assoc($tempresult);
    if($temprow != null)
    extract($temprow);

    /*$gpquery = "SELECT distinct gu_relation.userid as userid from gp_relation, gu_relation where projectid = $pid and gp_relation.groupid = gu_relation.groupid";
    $gpresult = mysqli_query($cxn, $gpquery);
    $gpnum = mysqli_num_rows($gpresult);
    $users = array();
    for($i=0;$i<$gpnum; $i++){
        $gprow = mysqli_fetch_assoc($gpresult);
        $userid = $gprow['userid'];
        $userquery = "SELECT * from users where user_id = $userid and user_alert_user = 1";
        $userresult = mysqli_query($cxn, $userquery);
        $userrow = mysqli_fetch_assoc($userresult);
        if(mysqli_num_rows($userresult) > 0) {*/
    
    $added = true;

    $guquery = "INSERT INTO `intevxyy_interbuild`.`gu_relation` (`id`,`groupid`,`userid`, `role`) VALUES (null, '{$id}', '{$account_userid}', '{$k}');";
    mysqli_query($cxn, $guquery);
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

    $mail->Subject = "{$profile_row['account_firstname']} {$profile_row['account_lastname']} has invited you to join InterBuild";
    $mail->IsHTML(true);
    $mail->Body = "Congratulations! {$profile_row['account_firstname']} {$profile_row['account_lastname']} has invited you to collaborate with them on InterBuild. They have invited you to Project {$projectRow['project_name']}, Please click here ".' <a href="http://'.$_SERVER['SERVER_NAME'].'/createusercompletion.php?projectid='.$pid.'&userid='.$user_inserted_id.'"> to complete your user information.'.'</a>'; 
 

    if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }
    
    $_SESSION['success']="User created successfully.";

    $uquery = "Select * from accounts where account_userid={$_SESSION['userid']}";
    $ures = mysqli_query($cxn, $uquery);
    $urow = mysqli_fetch_assoc($ures);
    $detail = $urow['account_firstname']." ".$urow['account_lastname']." has created ".$user_firstname." ".$user_secondname;
    $logQuery = "Insert into `logs` (`id`,`projectid`,`detail`,`time`) values (NULL,$pid,'{$detail}','".time()."')";
    mysqli_query($cxn,$logQuery);
}
else{
    $emailCheckRow = mysqli_fetch_assoc($emailCheckResult);
    if($emailCheckRow != null)
    extract($emailCheckRow);

    $guCheckQuery = "SELECT * from gu_relation where userid = '{$user_id}' and groupid = $id";

    $guCheckResult = mysqli_query($cxn, $guCheckQuery);
    $guCheckRows = mysqli_num_rows($guCheckResult);
    if($guCheckRows > 0)
    {
        $_SESSION['success']="User Already Exist In this Group.";
    }
    else {
        $pid = $_SESSION['pid'];
        $pid_with_number = 'pid'.$pid;
        
        $rolequery = "Select * from users,gp_relation,gu_relation where gp_relation.projectid = {$_SESSION['pid']} and gp_relation.groupid=gu_relation.groupid and gu_relation.userid=users.user_id and users.user_id = $user_id";
        $roleresult = mysqli_query($cxn, $rolequery);
        $rolerownum = mysqli_num_rows($roleresult);

        if($rolerownum > 0)
        {
            $_SESSION['success']="User Already Exist In this Project.";
        }
        else {
            $added = true;
            for($x = 1; $x < 6; $x++){
                $alertInsertQuery = "INSERT INTO `intevxyy_interbuild`.`alertsetting` (`id`, `projectid`, `userid`, `activityid`, `status`) VALUES (NULL, '{$pid}', '{$user_id}', '{$x}', 0);";
                mysqli_query($cxn, $alertInsertQuery);
            }
        	$insertUserToGroupQuery = "INSERT INTO `intevxyy_interbuild`.`gu_relation` (`id`,`groupid`,`userid`, `role`) VALUES(null, {$id}, {$user_id}, '{$k}')";
            mysqli_query($cxn, $insertUserToGroupQuery);
            $_SESSION['success']="User Added into this Group Successfully.";
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

            $mail->Subject = "{$profile_row['account_firstname']} {$profile_row['account_lastname']} has added you to {$projectRow['project_name']} project";
            $mail->IsHTML(true);
            $mail->Body = "Welcome! {$profile_row['account_firstname']} {$profile_row['account_lastname']} has added you as a user to {$projectRow['project_name']} Project, you are a member of the {$name} Group. Please click <a href='http://interbuild.co/'>here</a> to sign in"; 
         

            if(!$mail->send()) {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            }
        }
    
    }

    $uquery = "Select * from accounts where account_userid={$_SESSION['userid']}";
    $ures = mysqli_query($cxn, $uquery);
    $urow = mysqli_fetch_assoc($ures);
    $detail = $urow['account_firstname']." ".$urow['account_lastname']." has added ".$user_firstname." ".$user_secondname;
    $logQuery = "Insert into `logs` (`id`,`projectid`,`detail`,`time`) values (NULL,$pid,'{$detail}','".time()."')";
    mysqli_query($cxn,$logQuery);
}

if($added == true){
    $gpquery = "SELECT * from gp_relation, gu_relation, users, alertsetting where gp_relation.projectid = $pid and gp_relation.groupid = gu_relation.groupid and users.user_id = gu_relation.userid and alertsetting.userid = users.user_id and alertsetting.projectid = $pid and alertsetting.activityid = 3 and alertsetting.status = 1";
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
        //$mail->AddAddress("franky0930@hotmail.com");
        $mail->AddAddress($users[$j]);//$userrow['user_email']);

        $mail->Subject = 'Notification from InterBuild';
        $mail->IsHTML(true);
        
        $mail->Body = 'User '.$user_firstname.' '.$user_secondname.' is added to ' . $projectRow['project_name'] . ' successfully!';  

        if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
            
        
    }
}
header("Location: groups.php?projectid=$pid");
?>