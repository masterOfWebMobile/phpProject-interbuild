<?php 
	session_start();
	include("include/access.php");  
	$pid = $_SESSION['pid'];
	$userid = $_SESSION['userid'];
	$deleteIDs = $_POST['deleteIDs'];
	$deleteIDs = implode($deleteIDs, ', ');
	$updateIDs = $_POST['updateIDs'];
	$updateDatas = $_POST['updateDatas'];
	$addIDs = $_POST['addIDs'];
	$addDatas = $_POST['addDatas'];
    //var_dump("herephp = ".$addIDs.count());
 //    var_dump($addDatas[0][0]);
	// exit;

	foreach ($addIDs as $i)
	{
		// var_dump($addDatas[$i][0]);
		// exit;

		$addQuery = "Insert into schedules (`schedule_id`, `project_id`, `user_id`,`scheduled_date`, `revised_date`, `difference`, `event`, `responsible_parties_groups`, `responsible_parties_users`, `notes`, `status`, `reminders7check`, `reminders30check`) values (null, '{$pid}', '{$userid}', '{$addDatas[$i][0]}', '{$addDatas[$i][1]}', '{$addDatas[$i][2]}', '{$addDatas[$i][3]}', '{$addDatas[$i][4]}', '{$addDatas[$i][5]}', '{$addDatas[$i][6]}', '{$addDatas[$i][7]}', '{$addDatas[$i][8]}', '{$addDatas[$i][9]}' )";
		mysqli_query($cxn, $addQuery);
	}

	foreach ($updateIDs as $i)
	{	
		// var_dump($updateIDs);
		// var_dump($updateDatas);
		// exit;
		$x = intval($i);
		var_dump($x);
		$updateQuery = "Update schedules set project_id = '{$pid}', user_id = '{$userid}', scheduled_date = '{$updateDatas[$i][0]}', revised_date = '{$updateDatas[$i][1]}' , difference = '{$updateDatas[$i][2]}', event = '{$updateDatas[$i][3]}', responsible_parties_groups = '{$updateDatas[$i][4]}', responsible_parties_users = '{$updateDatas[$i][5]}', notes = '{$updateDatas[$i][6]}', status = '{$updateDatas[$i][7]}', reminders7check = '{$updateDatas[$i][8]}', reminders30check = '{$updateDatas[$i][9]}' where schedule_id = {$x}";
		mysqli_query($cxn, $updateQuery);
	}

	$deleteQuery = "delete from schedules where schedule_id in ($deleteIDs)";
	mysqli_query($cxn, $deleteQuery);
?>