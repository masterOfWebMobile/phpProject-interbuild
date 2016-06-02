<?php
session_start();
$email=$_POST["email"];
$email=strtolower($email);
$pswrd=$_POST["password"];
$pswrd=md5($pswrd);

include("include/access.php");
$pid = $_SESSION['pid'];
$userid = $_SESSION['userid'];

$query = "SELECT * FROM users WHERE user_email='$email' AND user_password='$pswrd'";
$result = mysqli_query($cxn,$query);
if(mysqli_num_rows($result)==0)
{
	$_SESSION['error']="Email or Password are incorrect.";
	header("Location: login.php");
}
else
{
	$row=mysqli_fetch_assoc($result);
	extract($row);
	$_SESSION['userid'] = $user_id;
	$_SESSION['superadmin'] = $user_superadmin;
	if($user_superadmin == "1" || $user_superadmin == 1){
		$pquery = "SELECT * FROM userid_projectid where up_userid = $user_id";
		$pres = mysqli_query($cxn, $pquery);
		$pstr = "";
		while($qrow = mysqli_fetch_assoc($pres)){
			$pstr .= $qrow['up_projectid'].",";
		}
		$_SESSION['managepid'] = $pstr;
	}
	$_SESSION['useremail'] = $user_email;

	header("Location: index.php");

}

?>