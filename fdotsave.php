<?php
session_start();
include("include/access.php");
$pid = $_SESSION['pid'];
$pid_with_number = 'pid'.$pid;
$_SESSION[$pid_with_number]['fdot_sel_con'] = $_POST['fdot_sel_con'];
$_SESSION[$pid_with_number]['fdot_sel_eng'] = $_POST['fdot_sel_eng'];
$_SESSION[$pid_with_number]['fdot_sel_own'] = $_POST['fdot_sel_own'];

$_SESSION[$pid_with_number]['invoicenumber'] = $_POST['invoicenumber'];
$_SESSION[$pid_with_number]['phasebeinginvoiced'] = $_POST['phasebeinginvoiced'];
$_SESSION[$pid_with_number]['financialprojectid'] = $_POST['financialprojectid'];
$_SESSION[$pid_with_number]['contractnumber'] = $_POST['contractnumber'];
$_SESSION[$pid_with_number]['projectdescription'] = $_POST['projectdescription'];
$_SESSION[$pid_with_number]['attn'] = $_POST['attn'];
$_SESSION[$pid_with_number]['jpalapexecutiondate'] = $_POST['jpalapexecutiondate'];
$_SESSION[$pid_with_number]['localagencyname'] = $_POST['localagencyname'];
$_SESSION[$pid_with_number]['localagencyaddress'] = $_POST['localagencyaddress'];
$_SESSION[$pid_with_number]['servicebegindate'] = $_POST['servicebegindate'];
$_SESSION[$pid_with_number]['serviceenddate'] = $_POST['serviceenddate'];
$_SESSION[$pid_with_number]['daysuntilcurrentphassecompletion'] = $_POST['daysuntilcurrentphassecompletion'];
$_SESSION[$pid_with_number]['totalamountofreimbursementagreement'] = $_POST['totalamountofreimbursementagreement'];
$_SESSION[$pid_with_number]['totalpreviouslybilled'] = $_POST['totalpreviouslybilled'];
$_SESSION[$pid_with_number]['totalforcurrentbilling'] = $_POST['totalforcurrentbilling'];
$_SESSION[$pid_with_number]['percentageofjpalapfundsexpended'] = $_POST['percentageofjpalapfundsexpended'];
$_SESSION[$pid_with_number]['balanceonjpalapagreement'] = $_POST['balanceonjpalapagreement'];


//$query = "UPDATE `contractstatus` SET `cs_bidrecieved` = '$bidsreceiveddate', `cs_contractdate` = '$contractdate', `cs_noticetoproceed` = '$noticetoproceed', `cs_calendardaystocomplete` = '$daystocomplete ', `cs_originalsubstantial` = '$originalsubstcompletedate', `cs_originalcompletion` = '$originalcompletedate', `cs_daysextension` = '$daysextension', `cs_newcompletion` = '$newcompletedate', `cs_originalcontract` = '$originalcontractamt', `cs_revisedcontract` = '$revisedcontractamt', `cs_adjustmentdate` = '$adjtodate', `cs_percentcomplete` = '$percentcompl', `cs_totalwork` = '$totalworkcompleted', `cs_prepayment` = '$prepayment', `cs_materialstored` = '$materialstoredonsite', `cs_subtotal1` = '$subtotal1', `cs_lessliquidated` = '$liquiddamage', `cs_subtotal2` = '$subtotal2', `cs_retainage` = '$retainage', `cs_retainagedollars` = '$retainagedollar', `cs_subtotal3` = '$subtotal3', `cs_lesspreviouspayments` = '$previouspayment', `cs_amountdue` = '$amountdue' WHERE `cs_projectid` = $projectid;";

$data = array(
    "order_sel_con" => $_POST['order_sel_con'],
	"fdot_sel_con" => $_POST['fdot_sel_con'],
	"fdot_sel_eng" => $_POST['fdot_sel_eng'],
	"fdot_sel_own" => $_POST['fdot_sel_own'],

	"invoicenumber" => $_POST['invoicenumber'],
	"phasebeinginvoiced" => $_POST['phasebeinginvoiced'],
	"financialprojectid" => $_POST['financialprojectid'],
	"contractnumber" => $_POST['contractnumber'],
	"projectdescription" => $_POST['projectdescription'],
	"attn" => $_POST['attn'],
	"jpalapexecutiondate" => $_POST['jpalapexecutiondate'],
	"localagencyname" => $_POST['localagencyname'],
	"localagencyaddress" => $_POST['localagencyaddress'],
	"servicebegindate" => $_POST['servicebegindate'],
	"serviceenddate" => $_POST['serviceenddate'],
	"daysuntilcurrentphassecompletion" => $_POST['daysuntilcurrentphassecompletion'],
	"totalamountofreimbursementagreement" => $_POST['totalamountofreimbursementagreement'],
	"totalpreviouslybilled" => $_POST['totalpreviouslybilled'],
	"totalforcurrentbilling" => $_POST['totalforcurrentbilling'],
	"percentageofjpalapfundsexpended" => $_POST['percentageofjpalapfundsexpended'],
	"balanceonjpalapagreement" => $_POST['balanceonjpalapagreement']
);
$jsonData = json_encode($data);

$jsonFindQuery = "Select * from sessions where project_id = $pid";
$jsonFindResult = mysqli_query($cxn, $jsonFindQuery);
$findRowNum = mysqli_num_rows($jsonFindResult);

if ($findRowNum == 0)
{
	$jsonQuery = "Insert INTO sessions (`project_id`, `fdot`) VALUES ($pid, '{$jsonData}')";
	mysqli_query($cxn, $jsonQuery);
}
else
{
	$jsonQuery = "Update sessions set fdot = '{$jsonData}' where project_id = $pid";
	mysqli_query($cxn, $jsonQuery);
}

echo "SUCCESS";

//mysqli_query($cxn, $query);

//$upquery = "INSERT INTO `documents` ( `document_undertype`, `document_underid`, `document_name`, `document_location`) VALUES ('folder', '4', '$location', '$location');"; 

//mysqli_query($cxn, $upquery);

?>