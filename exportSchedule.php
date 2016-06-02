<?php
	session_start();
	include("include/access.php");
	$project = $_SESSION['pid'];
	$projectname = $_POST['projectname']; 
	$documentname = $projectname."_schedule.pdf";
	if(!empty($_POST['data'])){
		$data = base64_decode($_POST['data']);
		// print_r($data);
		if (file_exists("files/$documentname") && is_writeable("files/$documentname"))
			unlink("files/$documentname");
		if(is_writeable("files/$documentname"))
		{
			file_put_contents( "files/$documentname", $data );
			$_SESSION['success']="File save successfully.";
		}
		echo $documentname;
	} else {
		echo "No Data Sent";
	}
	
	exit;
?>