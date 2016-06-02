<?php
session_start();
include_once('include/access.php');
$user_firstname = $_POST['firstname'];
$user_secondname = $_POST['lastname'];
$user_group = $_POST['organization'];
$user_title = $_POST['title'];
$user_phoneoffice = $_POST['phoneoffice'];
$user_phonemobile = $_POST['phonemobile'];
$user_fax = $_POST['fax'];
$user_address = $_POST['address'];
$user_zip = $_POST['zip'];
$user_email = $_POST['emailaddress'];
$user_password = $_POST['password'];

$pass = md5($user_password);

$gquery = "INSERT INTO `intevxyy_interbuild`.`users` (`user_id`, `user_email`, `user_password`, `user_superadmin`, `user_status`) VALUES (null, '{$user_email}', '{$pass}', 1, 1);";
mysqli_query($cxn, $gquery);
$user_id = mysqli_insert_id($cxn);

$uquery = "INSERT INTO `intevxyy_interbuild`.`accounts` (`account_id`,`account_userid`,`account_firstname`, `account_lastname`, `account_organization`, `account_organization_type`, `account_organization_othertype`, `account_title`, `account_other_title`, `account_phone`, `account_mobilephone`, `account_location`, `account_zip`, `account_fax`) VALUES (null, '{$user_id}', '{$user_firstname}', '{$user_secondname}', '{$user_group}', '', '', '{$user_title}', '', '{$user_phoneoffice}', '{$user_phonemobile}', '{$user_address}', '{$user_zip}', '{$user_fax}');";
mysqli_query($cxn, $uquery);
session_unset();
header("Location: login.php");
?>