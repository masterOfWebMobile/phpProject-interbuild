<?php
session_start();
include("include/access.php");
$pid = $_SESSION['pid'];
$pid_with_number = 'pid'.$pid;
$_SESSION[$pid_with_number]['sel_con'] = $_POST['sel_con'];
$_SESSION[$pid_with_number]['sel_eng'] = $_POST['sel_eng'];
$_SESSION[$pid_with_number]['sel_own'] = $_POST['sel_own'];
$_SESSION[$pid_with_number]['sel_con_order'] = $_POST['sel_con_order'];
$_SESSION[$pid_with_number]['sel_eng_order'] = $_POST['sel_eng_order'];
$_SESSION[$pid_with_number]['sel_own_order'] = $_POST['sel_own_order'];
$_SESSION[$pid_with_number]['input_cfrom'] = $_POST['input_cfrom'];
$_SESSION[$pid_with_number]['input_cto'] = $_POST['input_cto'];


$_SESSION[$pid_with_number]['signerOrderCheckSessionStatus'] = $_POST['signerOrderCheckSessionStatus'];
$_SESSION[$pid_with_number]['bidsreceiveddate'] = $_POST['bidsreceiveddate'];
$_SESSION[$pid_with_number]['contractdate'] = $_POST['contractdate'];
$_SESSION[$pid_with_number]['noticetoproceed'] = $_POST['noticetoproceed'];
$_SESSION[$pid_with_number]['daystosubcomplete'] = $_POST['daystosubcomplete'];
$_SESSION[$pid_with_number]['daystocomplete'] = $_POST['daystocomplete'];
$_SESSION[$pid_with_number]['originalsubstcompletedate'] = $_POST['originalsubstcompletedate'];
$_SESSION[$pid_with_number]['originalcompletedate'] = $_POST['originalcompletedate'];
$_SESSION[$pid_with_number]['dayssubextension'] = $_POST['dayssubextension'];
$_SESSION[$pid_with_number]['daysextension'] = $_POST['daysextension'];
$_SESSION[$pid_with_number]['newsubcompletedate'] = $_POST['newsubcompletedate'];
$_SESSION[$pid_with_number]['newcompletedate'] = $_POST['newcompletedate'];
$_SESSION[$pid_with_number]['originalcontractamt'] = $_POST['originalcontractamt'];
$_SESSION[$pid_with_number]['revisedcontractamt'] = $_POST['revisedcontractamt'];
$_SESSION[$pid_with_number]['adjtodate'] = $_POST['adjtodate'];
$_SESSION[$pid_with_number]['percentcompl'] = $_POST['percentcompl'];
$_SESSION[$pid_with_number]['totalworkcompleted'] = $_POST['totalworkcompleted'];
$_SESSION[$pid_with_number]['prepayment'] = $_POST['prepayment'];
$_SESSION[$pid_with_number]['materialstoredonsite'] = $_POST['materialstoredonsite'];
$_SESSION[$pid_with_number]['subtotal1'] = $_POST['subtotal1'];
$_SESSION[$pid_with_number]['liquiddamage'] = $_POST['liquiddamage'];
$_SESSION[$pid_with_number]['subtotal2'] = $_POST['subtotal2'];
$_SESSION[$pid_with_number]['retainage'] = $_POST['retainage'];
$_SESSION[$pid_with_number]['retainagedollar'] = $_POST['retainagedollar'];
$_SESSION[$pid_with_number]['subtotal3'] = $_POST['subtotal3'];
$_SESSION[$pid_with_number]['previouspayment'] = $_POST['previouspayment'];
$_SESSION[$pid_with_number]['amountdue'] = $_POST['amountdue'];
$_SESSION[$pid_with_number]['projectid'] = $_POST['projectid'];
$_SESSION[$pid_with_number]['location'] = $_POST['location'];

//$query = "UPDATE `contractstatus` SET `cs_bidrecieved` = '$bidsreceiveddate', `cs_contractdate` = '$contractdate', `cs_noticetoproceed` = '$noticetoproceed', `cs_calendardaystocomplete` = '$daystocomplete ', `cs_originalsubstantial` = '$originalsubstcompletedate', `cs_originalcompletion` = '$originalcompletedate', `cs_daysextension` = '$daysextension', `cs_newcompletion` = '$newcompletedate', `cs_originalcontract` = '$originalcontractamt', `cs_revisedcontract` = '$revisedcontractamt', `cs_adjustmentdate` = '$adjtodate', `cs_percentcomplete` = '$percentcompl', `cs_totalwork` = '$totalworkcompleted', `cs_prepayment` = '$prepayment', `cs_materialstored` = '$materialstoredonsite', `cs_subtotal1` = '$subtotal1', `cs_lessliquidated` = '$liquiddamage', `cs_subtotal2` = '$subtotal2', `cs_retainage` = '$retainage', `cs_retainagedollars` = '$retainagedollar', `cs_subtotal3` = '$subtotal3', `cs_lesspreviouspayments` = '$previouspayment', `cs_amountdue` = '$amountdue' WHERE `cs_projectid` = $projectid;";

$data = array(
    "sel_con" => $_POST['sel_con'],
    "sel_eng"  => $_POST['sel_eng'],
    "sel_own"  => $_POST['sel_own'],
    "sel_con_order"  => $_POST['sel_con_order'],
    "sel_eng_order"  => $_POST['sel_eng_order'],
    "sel_own_order"  => $_POST['sel_own_order'],
    "input_cfrom"  => $_POST['input_cfrom'],
    "input_cto"  => $_POST['input_cto'],
    "signerOrderCheckSessionStatus"  => $_POST['signerOrderCheckSessionStatus'],
    "bidsreceiveddate"  => $_POST['bidsreceiveddate'],
    "contractdate"  => $_POST['contractdate'],
    "noticetoproceed"  => $_POST['noticetoproceed'],
    "daystosubcomplete"  => $_POST['daystosubcomplete'],
    "daystocomplete"  => $_POST['daystocomplete'],
    "originalsubstcompletedate"  => $_POST['originalsubstcompletedate'],
    "originalcompletedate"  => $_POST['originalcompletedate'],
    "dayssubextension"  => $_POST['dayssubextension'],
    "daysextension"  => $_POST['daysextension'],
    "newsubcompletedate"  => $_POST['newsubcompletedate'],
    "newcompletedate"  => $_POST['newcompletedate'],
    "originalcontractamt"  => $_POST['originalcontractamt'],
    "revisedcontractamt"  => $_POST['revisedcontractamt'],
    "adjtodate"  => $_POST['adjtodate'],
    "percentcompl"  => $_POST['percentcompl'],
    "totalworkcompleted"  => $_POST['totalworkcompleted'],
    "prepayment"  => $_POST['prepayment'],
    "materialstoredonsite"  => $_POST['materialstoredonsite'],
    "subtotal1"  => $_POST['subtotal1'],
    "liquiddamage"  => $_POST['liquiddamage'],
    "subtotal2"  => $_POST['subtotal2'],
    "retainage"  => $_POST['retainage'],
    "retainagedollar"  => $_POST['retainagedollar'],
    "subtotal3"  => $_POST['subtotal3'],
    "previouspayment"  => $_POST['previouspayment'],
    "amountdue"  => $_POST['amountdue'],
    "projectid"  => $_POST['projectid'],
    "location"  => $_POST['location']
);
$jsonData = json_encode($data);

$jsonFindQuery = "Select * from sessions where project_id = $pid";
$jsonFindResult = mysqli_query($cxn, $jsonFindQuery);
$findRowNum = mysqli_num_rows($jsonFindResult);

if ($findRowNum == 0)
{
	$jsonQuery = "Insert INTO sessions (`project_id`, `contractstatus`) VALUES ($pid, '{$jsonData}')";
	mysqli_query($cxn, $jsonQuery);
}
else
{
	$jsonQuery = "Update sessions set contractstatus = '{$jsonData}' where project_id = $pid";
	mysqli_query($cxn, $jsonQuery);

	/*$fetchDataQuery = "Select contractstatus as con from sessions where project_id = $pid";
	$fetchDataResult = mysqli_query($cxn, $fetchDataQuery);
	$fetchDataRow = mysqli_fetch_assoc($fetchDataResult);
	extract($fetchDataRow);
	var_dump("iuwer ". $con. "json " . $jsonData);
	exit;*/
}


echo "SUCCESS";

//mysqli_query($cxn, $query);

//$upquery = "INSERT INTO `documents` ( `document_undertype`, `document_underid`, `document_name`, `document_location`) VALUES ('folder', '4', '$location', '$location');"; 

//mysqli_query($cxn, $upquery);

?>