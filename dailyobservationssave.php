<?php
session_start();
include("include/access.php");
$pid = $_SESSION['pid'];
$pid_with_number = 'pid'.$pid;
$_SESSION[$pid_with_number]['daily_sel_con'] = $_POST['daily_sel_con'];
$_SESSION[$pid_with_number]['daily_sel_eng'] = $_POST['daily_sel_eng'];
$_SESSION[$pid_with_number]['daily_sel_own'] = $_POST['daily_sel_own'];
$_SESSION[$pid_with_number]['weather'] = $_POST['weather'];
$_SESSION[$pid_with_number]['temperature'] = $_POST['temperature'];
$_SESSION[$pid_with_number]['time'] = $_POST['time'];
$_SESSION[$pid_with_number]['temperaturetime'] = $_POST['temperaturetime'];
$_SESSION[$pid_with_number]['raingaugereading'] = $_POST['raingaugereading'];
$_SESSION[$pid_with_number]['date'] = $_POST['date'];
$_SESSION[$pid_with_number]['contractday'] = $_POST['contractday'];
$_SESSION[$pid_with_number]['hoursonsite'] = $_POST['hoursonsite'];
$_SESSION[$pid_with_number]['contractor'] = $_POST['contractor'];
$_SESSION[$pid_with_number]['workforce'] = $_POST['workforce'];
$_SESSION[$pid_with_number]['equipment'] = $_POST['equipment'];
$_SESSION[$pid_with_number]['workactivities'] = $_POST['workactivities'];
$_SESSION[$pid_with_number]['testsperformed'] = $_POST['testsperformed'];
$_SESSION[$pid_with_number]['materialsdelivered'] = $_POST['materialsdelivered'];
$_SESSION[$pid_with_number]['visitors'] = $_POST['visitors'];
$_SESSION[$pid_with_number]['defectiveworktobecorrected'] = $_POST['defectiveworktobecorrected'];


//$query = "UPDATE `contractstatus` SET `cs_bidrecieved` = '$bidsreceiveddate', `cs_contractdate` = '$contractdate', `cs_noticetoproceed` = '$noticetoproceed', `cs_calendardaystocomplete` = '$daystocomplete ', `cs_originalsubstantial` = '$originalsubstcompletedate', `cs_originalcompletion` = '$originalcompletedate', `cs_daysextension` = '$daysextension', `cs_newcompletion` = '$newcompletedate', `cs_originalcontract` = '$originalcontractamt', `cs_revisedcontract` = '$revisedcontractamt', `cs_adjustmentdate` = '$adjtodate', `cs_percentcomplete` = '$percentcompl', `cs_totalwork` = '$totalworkcompleted', `cs_prepayment` = '$prepayment', `cs_materialstored` = '$materialstoredonsite', `cs_subtotal1` = '$subtotal1', `cs_lessliquidated` = '$liquiddamage', `cs_subtotal2` = '$subtotal2', `cs_retainage` = '$retainage', `cs_retainagedollars` = '$retainagedollar', `cs_subtotal3` = '$subtotal3', `cs_lesspreviouspayments` = '$previouspayment', `cs_amountdue` = '$amountdue' WHERE `cs_projectid` = $projectid;";

$data = array(
    "order_sel_con" => $_POST['order_sel_con'],
	"daily_sel_con" => $_POST['daily_sel_con'],
	"daily_sel_eng" => $_POST['daily_sel_eng'],
	"daily_sel_own" => $_POST['daily_sel_own'],
	"weather" => $_POST['weather'],
	"temperature" => $_POST['temperature'],
	"time" => $_POST['time'],
	"temperaturetime" => $_POST['temperaturetime'],
	"raingaugereading" => $_POST['raingaugereading'],
	"date" => $_POST['date'],
	"contractday" => $_POST['contractday'],
	"hoursonsite" => $_POST['hoursonsite'],
	"contractor" => $_POST['contractor'],
	"workforce" => $_POST['workforce'],
	"equipment" => $_POST['equipment'],
	"workactivities" => $_POST['workactivities'],
	"testsperformed" => $_POST['testsperformed'],
	"materialsdelivered" => $_POST['materialsdelivered'],
	"visitors" => $_POST['visitors'],
	"defectiveworktobecorrected" => $_POST['defectiveworktobecorrected']
);
$jsonData = json_encode($data);

$jsonFindQuery = "Select * from sessions where project_id = $pid";
$jsonFindResult = mysqli_query($cxn, $jsonFindQuery);
$findRowNum = mysqli_num_rows($jsonFindResult);

if ($findRowNum == 0)
{
	$jsonQuery = "Insert INTO sessions (`project_id`, `dailyobservation`) VALUES ($pid, '{$jsonData}')";
	mysqli_query($cxn, $jsonQuery);
}
else
{
	$jsonQuery = "Update sessions set dailyobservation = '{$jsonData}' where project_id = $pid";
	mysqli_query($cxn, $jsonQuery);
}


echo "SUCCESS";

//mysqli_query($cxn, $query);

//$upquery = "INSERT INTO `documents` ( `document_undertype`, `document_underid`, `document_name`, `document_location`) VALUES ('folder', '4', '$location', '$location');"; 

//mysqli_query($cxn, $upquery);

?>