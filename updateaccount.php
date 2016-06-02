<?php
session_start();
include("include/access.php");

$id = $_POST["id"];

$firstname = $_POST["firstname"];
$firstname = addslashes($firstname);

$lastname = $_POST["lastname"];
$lastname = addslashes($lastname);

$organization = $_POST["organization"];
$organization = addslashes($organization);

$title = $_POST["title"];
$title = addslashes($title);

$workphone = $_POST["workphone"];

$mobilephone = $_POST["mobilephone"];

$action = $_POST["action"];

$userid = $_POST["userid"];


if($action == 'new')
{
  $query = "INSERT INTO `intevxyy_interbuild`.`accounts` (`account_id`, `account_userid`, `account_firstname`, `account_lastname`, `account_organization`, `account_title`, `account_phone`, `account_mobilephone`) VALUES (NULL, '{$userid}', '{$firstname}', '{$lastname}', '{$organization}', '{$title}', '{$workphone}', '{$mobilephone}');"; 

  
}
else
{

  $query = "UPDATE accounts SET account_firstname = '{$firstname}', account_lastname = '{$lastname}', account_organization = '{$organization}', account_title = '{$title}', account_phone = '{$workphone}', account_mobilephone = '{$mobilephone}' WHERE account_userid = $userid"; 
}


//echo $query;


mysqli_query($cxn, $query);

$_SESSION['success']="Account Info has been updated.";
header("Location:myaccount.php");

?>