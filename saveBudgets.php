<?php 
	session_start();
	include("include/access.php");  
	$pid = $_SESSION['pid'];
	$userid = $_SESSION['userid'];
	$deleteSourceIDs = $_POST['deleteSourceIDs'];
	$deleteSourceIDs = implode($deleteSourceIDs, ', ');
	$updateSourceIDs = $_POST['updateSourceIDs'];
	$updateSourceDatas = $_POST['updateSourceDatas'];
	$addSourceIDs = $_POST['addSourceIDs'];
	$addSourceDatas = $_POST['addSourceDatas'];

	$deleteUseIDs = $_POST['deleteUseIDs'];
	$deleteUseIDs = implode($deleteUseIDs, ', ');
	$updateUseIDs = $_POST['updateUseIDs'];
	$updateUseDatas = $_POST['updateUseDatas'];
	$addUseIDs = $_POST['addUseIDs'];
	$addUseDatas = $_POST['addUseDatas'];
    
    $budgetTotal = $_POST['budgetTotal'];

    $budgetTotalQuery = "Select * from budgets where project_id = $pid and user_id = $userid and budget_type = 2";
  	$budgetTotalResult = mysqli_query($cxn, $budgetTotalQuery);
  	$budgetTotalRow = mysqli_fetch_assoc($budgetTotalResult);
  	if($budgetTotalRow != null)
  	{  
	    $updateTotal = "Update budgets set project_id = {$pid}, user_id = {$userid}, budget_name = '', budget_amount = {$budgetTotal} where budget_type = 2";
		mysqli_query($cxn, $updateTotal);
  	}
 	else {
    	$addTotal = "Insert into budgets (`budget_id`, `project_id`, `user_id`,`budget_name`, `budget_amount`, `budget_type`) values (null, '{$pid}', '{$userid}', '0', '{$budgetTotal}', '2')";
		mysqli_query($cxn, $addTotal);
  	}


	foreach ($addSourceIDs as $i)
	{
		// var_dump($addDatas[$i][0]);
		// exit;

		$addSourceQuery = "Insert into budgets (`budget_id`, `project_id`, `user_id`,`budget_name`, `budget_amount`, `budget_type`) values (null, '{$pid}', '{$userid}', '{$addSourceDatas[$i][0]}', '{$addSourceDatas[$i][1]}', '0')";
		mysqli_query($cxn, $addSourceQuery);
	}

	foreach ($updateSourceIDs as $i)
	{	
		// var_dump($updateIDs);
		
		$x = intval($i);
		
		$y = intval($updateSourceDatas[$i][1]);
		$updateSourceQuery = "Update budgets set project_id = {$pid}, user_id = {$userid}, budget_name = '{$updateSourceDatas[$i][0]}', budget_amount = {$y} , budget_type = 0 where budget_id = {$x}";
		mysqli_query($cxn, $updateSourceQuery);
	}
	
	$deleteSourceQuery = "delete from budgets where budget_id in ($deleteSourceIDs)";
	mysqli_query($cxn, $deleteSourceQuery);


	foreach ($addUseIDs as $i)
	{
		// var_dump($addDatas[$i][0]);
		// exit;

		$addUseQuery = "Insert into budgets (`budget_id`, `project_id`, `user_id`,`budget_name`, `budget_amount`, `budget_type`) values (null, '{$pid}', '{$userid}', '{$addUseDatas[$i][0]}', '{$addUseDatas[$i][1]}', '1')";
		mysqli_query($cxn, $addUseQuery);
	}

	foreach ($updateUseIDs as $i)
	{	
		// var_dump($updateIDs);
		// var_dump($updateDatas);
		// exit;
		$x = intval($i);
		
		$y = intval($updateUseDatas[$i][1]);
		$updateUseQuery = "Update budgets set project_id = {$pid}, user_id = {$userid}, budget_name = '{$updateUseDatas[$i][0]}', budget_amount = {$y} , budget_type = 1 where budget_id = {$x}";
		mysqli_query($cxn, $updateUseQuery);
	}

	$deleteUseQuery = "delete from budgets where budget_id in ($deleteUseIDs)";
	mysqli_query($cxn, $deleteUseQuery);
?>