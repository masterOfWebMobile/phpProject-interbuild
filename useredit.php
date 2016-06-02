<?php
session_start();
include_once('include/access.php');
$pid = $_SESSION['pid'];
$user_firstname = $_POST['firstname'];
$user_secondname = $_POST['lastname'];
$user_group = $_POST['organization'];
$user_title = $_POST['title'];
$user_role = $_POST['userrole'];
$user_phoneoffice = $_POST['phoneoffice'];
$user_phonemobile = $_POST['phonemobile'];
$user_fax = $_POST['fax'];
$user_address = $_POST['address'];
$user_zip = $_POST['zip'];
$useremail = $_POST['emailaddress'];
$userpassword = $_POST['password'];
$roles = array("Administrator", "Collaborate", "Limited");
$k = array_search($user_role, $roles);
$k = $k + 1;
$userid = $_SESSION['userid'];
$pass = md5($user_password);
$gquery = "UPDATE `intevxyy_interbuild`.`users` SET user_password = '{$pass}' where user_email = '{$useremail}';";
$gresult = mysqli_query($cxn, $gquery);

$rolequery = "Select distinct gu_relation.groupid as groupid from users,gp_relation,gu_relation where gp_relation.projectid = {$_SESSION['pid']} and gp_relation.groupid=gu_relation.groupid and gu_relation.userid=users.user_id and users.user_id = $userid";
$roleresult = mysqli_query($cxn, $rolequery);
$rolerow = mysqli_fetch_assoc($roleresult);
extract($rolerow);

$guquery = "UPDATE `intevxyy_interbuild`.`gu_relation` SET role = $k where groupid = $groupid and userid = $userid;";
$guresult = mysqli_query($cxn, $guquery);

$kquery = "Select * from `intevxyy_interbuild`.`users` where user_email = '{$useremail}';";
$kresult = mysqli_query($cxn, $kquery);
$krow = mysqli_fetch_assoc($kresult);
extract($krow);

$groupQuery = "Select * from groups where id = $user_group";
$groupResult = mysqli_query($cxn, $groupquery);
$groupRow = mysqli_fetch_assoc($groupresult);
extract($groupRow)

$uquery = "UPDATE `intevxyy_interbuild`.`accounts` SET account_firstname = '{$user_firstname}', account_lastname = '{$user_secondname}', account_organization = '{$name}', account_title = '{$user_title}', account_phone = '{$user_phoneoffice}', account_mobilephone = '{$user_phonemobile}', account_location = '{$user_address}', account_zip = '{$user_zip}', account_fax = '{$user_fax}' where account_userid = {$user_id};";
mysqli_query($cxn, $uquery);
// echo "perfect";
// echo $user_email;
// echo $level;
// echo $user_id;
// exit;
$_SESSION['success']="User Info Edit successfully.";
header("Location: groups.php?projectid=$pid");
?>