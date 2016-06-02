<?php
session_start();
include("include/access.php");
$pid = $_SESSION['pid'];
$pid_with_number = 'pid'.$pid;
$_SESSION[$pid_with_number]['order_sel_con'] = $_POST['order_sel_con'];
$_SESSION[$pid_with_number]['order_sel_eng'] = $_POST['order_sel_eng'];
$_SESSION[$pid_with_number]['order_sel_own'] = $_POST['order_sel_own'];
$_SESSION[$pid_with_number]['order_sel_con_order'] = $_POST['order_sel_con_order'];
$_SESSION[$pid_with_number]['order_sel_eng_order'] = $_POST['order_sel_eng_order'];
$_SESSION[$pid_with_number]['order_sel_own_order'] = $_POST['order_sel_own_order'];

$_SESSION[$pid_with_number]['orderSignerOrderCheckSession'] = $_POST['orderSignerOrderCheckSession'];
$_SESSION[$pid_with_number]['originalcontractamount'] = $_POST['originalcontractamount'];
$_SESSION[$pid_with_number]['netofpreviouschangeorder'] = $_POST['netofpreviouschangeorder'];
$_SESSION[$pid_with_number]['adjustedcontractamount'] = $_POST['adjustedcontractamount'];
$_SESSION[$pid_with_number]['newcontractamountincludingthischangeorder'] = $_POST['newcontractamountincludingthischangeorder'];

$_SESSION[$pid_with_number]['changeordernumber'] = $_POST['changeordernumber'];
$_SESSION[$pid_with_number]['descriptionofchange'] = $_POST['descriptionofchange'];
$_SESSION[$pid_with_number]['decreasein'] = $_POST['decreasein'];
$_SESSION[$pid_with_number]['increasein'] = $_POST['increasein'];
$_SESSION[$pid_with_number]['noticetoproceeddays'] = $_POST['noticetoproceeddays'];
$_SESSION[$pid_with_number]['noticetoproceeddate'] = $_POST['noticetoproceeddate'];
$_SESSION[$pid_with_number]['originalcontracttimedays'] = $_POST['originalcontracttimedays'];
$_SESSION[$pid_with_number]['originalcontracttimedate'] = $_POST['originalcontracttimedate'];

$_SESSION[$pid_with_number]['netofpreviouschangeordertimedays'] = $_POST['netofpreviouschangeordertimedays'];
$_SESSION[$pid_with_number]['netofpreviouschangeordertimedate'] = $_POST['netofpreviouschangeordertimedate'];
$_SESSION[$pid_with_number]['adjustedcontracttimedays'] = $_POST['adjustedcontracttimedays'];
$_SESSION[$pid_with_number]['adjustedcontracttimedate'] = $_POST['adjustedcontracttimedate'];
$_SESSION[$pid_with_number]['addtimedays'] = $_POST['addtimedays'];
$_SESSION[$pid_with_number]['addtimedate'] = $_POST['addtimedate'];
$_SESSION[$pid_with_number]['deducttimedays'] = $_POST['deducttimedays'];
$_SESSION[$pid_with_number]['deducttimedate'] = $_POST['deducttimedate'];
$_SESSION[$pid_with_number]['changeordersubtotaldays'] = $_POST['changeordersubtotaldays'];
$_SESSION[$pid_with_number]['changeordersubtotaldate'] = $_POST['changeordersubtotaldate'];

$_SESSION[$pid_with_number]['presentcontracttimedays'] = $_POST['presentcontracttimedays'];
$_SESSION[$pid_with_number]['presentcontracttimedate'] = $_POST['presentcontracttimedate'];
$_SESSION[$pid_with_number]['thischargeadddeductdays'] = $_POST['thischargeadddeductdays'];
$_SESSION[$pid_with_number]['thischargeadddeductdate'] = $_POST['thischargeadddeductdate'];
$_SESSION[$pid_with_number]['newcontracttimedays'] = $_POST['newcontracttimedays'];
$_SESSION[$pid_with_number]['newcontracttimedate'] = $_POST['newcontracttimedate'];
$_SESSION[$pid_with_number]['substantialcompletiondate'] = $_POST['substantialcompletiondate'];
$_SESSION[$pid_with_number]['finalcompletiondate'] = $_POST['finalcompletiondate'];
$_SESSION[$pid_with_number]['changeordersubtotal'] = $_POST['changeordersubtotal'];
$_SESSION[$pid_with_number]['add'] = $_POST['add'];
$_SESSION[$pid_with_number]['net'] = $_POST['net'];
$_SESSION[$pid_with_number]['deduct'] = $_POST['deduct'];
$_SESSION[$pid_with_number]['originalcontractsum'] = $_POST['originalcontractsum'];
$_SESSION[$pid_with_number]['presentcontractsum'] = $_POST['presentcontractsum'];
$_SESSION[$pid_with_number]['newcontractsum'] = $_POST['newcontractsum'];
$_SESSION[$pid_with_number]['reflectcontractorder'] = $_POST['reflectcontractorder'];
$_SESSION[$pid_with_number]['thru'] = $_POST['thru'];
//$query = "UPDATE `contractstatus` SET `cs_bidrecieved` = '$bidsreceiveddate', `cs_contractdate` = '$contractdate', `cs_noticetoproceed` = '$noticetoproceed', `cs_calendardaystocomplete` = '$daystocomplete ', `cs_originalsubstantial` = '$originalsubstcompletedate', `cs_originalcompletion` = '$originalcompletedate', `cs_daysextension` = '$daysextension', `cs_newcompletion` = '$newcompletedate', `cs_originalcontract` = '$originalcontractamt', `cs_revisedcontract` = '$revisedcontractamt', `cs_adjustmentdate` = '$adjtodate', `cs_percentcomplete` = '$percentcompl', `cs_totalwork` = '$totalworkcompleted', `cs_prepayment` = '$prepayment', `cs_materialstored` = '$materialstoredonsite', `cs_subtotal1` = '$subtotal1', `cs_lessliquidated` = '$liquiddamage', `cs_subtotal2` = '$subtotal2', `cs_retainage` = '$retainage', `cs_retainagedollars` = '$retainagedollar', `cs_subtotal3` = '$subtotal3', `cs_lesspreviouspayments` = '$previouspayment', `cs_amountdue` = '$amountdue' WHERE `cs_projectid` = $projectid;";

$data = array(
    "order_sel_con" => $_POST['order_sel_con'],
	"order_sel_eng" => $_POST['order_sel_eng'],
	"order_sel_own" => $_POST['order_sel_own'],
	"order_sel_con_order" => $_POST['order_sel_con_order'],
	"order_sel_eng_order" => $_POST['order_sel_eng_order'],
	"order_sel_own_order" => $_POST['order_sel_own_order'],

	"orderSignerOrderCheckSession" => $_POST['orderSignerOrderCheckSession'],
	"originalcontractamount" => $_POST['originalcontractamount'],
	"netofpreviouschangeorder" => $_POST['netofpreviouschangeorder'],
	"adjustedcontractamount" => $_POST['adjustedcontractamount'],
	"newcontractamountincludingthischangeorder" => $_POST['newcontractamountincludingthischangeorder'],

	"changeordernumber" => $_POST['changeordernumber'],
	"descriptionofchange" => $_POST['descriptionofchange'],
	"decreasein" => $_POST['decreasein'],
	"increasein" => $_POST['increasein'],
	"noticetoproceeddays" => $_POST['noticetoproceeddays'],
	"noticetoproceeddate" => $_POST['noticetoproceeddate'],
	"originalcontracttimedays" => $_POST['originalcontracttimedays'],
	"originalcontracttimedate" => $_POST['originalcontracttimedate'],
	"netofpreviouschangeordertimedays" => $_POST['netofpreviouschangeordertimedays'],
	"netofpreviouschangeordertimedate" => $_POST['netofpreviouschangeordertimedate'],
	"adjustedcontracttimedays" => $_POST['adjustedcontracttimedays'],
	"adjustedcontracttimedate" => $_POST['adjustedcontracttimedate'],
	"addtimedays" => $_POST['addtimedays'],
	"addtimedate" => $_POST['addtimedate'],
	"deducttimedays" => $_POST['deducttimedays'],
	"deducttimedate" => $_POST['deducttimedate'],
	"changeordersubtotaldays" => $_POST['changeordersubtotaldays'],
	"changeordersubtotaldate" => $_POST['changeordersubtotaldate'],
	"presentcontracttimedays" => $_POST['presentcontracttimedays'],
	"presentcontracttimedate" => $_POST['presentcontracttimedate'],
	"thischargeadddeductdays" => $_POST['thischargeadddeductdays'],
	"thischargeadddeductdate" => $_POST['thischargeadddeductdate'],
	"newcontracttimedays" => $_POST['newcontracttimedays'],
	"newcontracttimedate" => $_POST['newcontracttimedate'],
	"substantialcompletiondate" => $_POST['substantialcompletiondate'],
	"finalcompletiondate" => $_POST['finalcompletiondate'],
	"changeordersubtotal" => $_POST['changeordersubtotal'],

	"add" => $_POST['add'],
	"net" => $_POST['net'],
	"deduct" => $_POST['deduct'],
	"originalcontractsum" => $_POST['originalcontractsum'],
	"presentcontractsum" => $_POST['presentcontractsum'],
	"newcontractsum" => $_POST['newcontractsum'],
	"reflectcontractorder" => $_POST['reflectcontractorder'],
	"thru" => $_POST['thru']
);
$jsonData = json_encode($data);

$jsonFindQuery = "Select * from sessions where project_id = $pid";
$jsonFindResult = mysqli_query($cxn, $jsonFindQuery);
$findRowNum = mysqli_num_rows($jsonFindResult);

if ($findRowNum == 0)
{
	$jsonQuery = "Insert INTO sessions (`project_id`, `contractchangeorder`) VALUES ($pid, '{$jsonData}')";
	mysqli_query($cxn, $jsonQuery);
}
else
{
	$jsonQuery = "Update sessions set contractchangeorder = '{$jsonData}' where project_id = $pid";
	mysqli_query($cxn, $jsonQuery);
}


echo "SUCCESS";

//mysqli_query($cxn, $query);

//$upquery = "INSERT INTO `documents` ( `document_undertype`, `document_underid`, `document_name`, `document_location`) VALUES ('folder', '4', '$location', '$location');"; 

//mysqli_query($cxn, $upquery);

?>