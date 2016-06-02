<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
include("include/access.php");
require_once 'vendor/autoload.php';
$_SESSION['pid'] = $_GET['projectid'];

$pid = $_SESSION['pid'];

$fetchDataQuery = "Select * from sessions where project_id = $pid";
$fetchDataResult = mysqli_query($cxn, $fetchDataQuery);
$fetchDataNum = mysqli_num_rows($fetchDataResult);
if ($fetchDataNum > 0){
  $fetchDataRow = mysqli_fetch_assoc($fetchDataResult);
  extract($fetchDataRow);
  /*echo("jsonDatas: ". "contractstatus= ".$contractstatus." contractchangeorder= ".$contractchangeorder." dailyobservation= ". $dailyobservation. " fdot= ". $fdot);
  exit;*/
  if($contractstatus != '')
  {
  
    $pid_with_number = 'pid'.$pid;
    $contractstatus = json_decode($contractstatus, true);
    $_SESSION[$pid_with_number]['sel_con'] = $contractstatus['sel_con'];
    $_SESSION[$pid_with_number]['sel_eng'] = $contractstatus['sel_eng'];
    $_SESSION[$pid_with_number]['sel_own'] = $contractstatus['sel_own'];
    $_SESSION[$pid_with_number]['sel_con_order'] = $contractstatus['sel_con_order'];
    $_SESSION[$pid_with_number]['sel_eng_order'] = $contractstatus['sel_eng_order'];
    $_SESSION[$pid_with_number]['sel_own_order'] = $contractstatus['sel_own_order'];
    $_SESSION[$pid_with_number]['input_cfrom'] = $contractstatus['input_cfrom'];
    $_SESSION[$pid_with_number]['input_cto'] = $contractstatus['input_cto'];


    $_SESSION[$pid_with_number]['signerOrderCheckSessionStatus'] = $contractstatus['signerOrderCheckSessionStatus'];
    $_SESSION[$pid_with_number]['bidsreceiveddate'] = $contractstatus['bidsreceiveddate'];
    $_SESSION[$pid_with_number]['contractdate'] = $contractstatus['contractdate'];
    $_SESSION[$pid_with_number]['noticetoproceed'] = $contractstatus['noticetoproceed'];
    $_SESSION[$pid_with_number]['daystosubcomplete'] = $contractstatus['daystosubcomplete'];
    $_SESSION[$pid_with_number]['daystocomplete'] = $contractstatus['daystocomplete'];
    $_SESSION[$pid_with_number]['originalsubstcompletedate'] = $contractstatus['originalsubstcompletedate'];
    $_SESSION[$pid_with_number]['originalcompletedate'] = $contractstatus['originalcompletedate'];
    $_SESSION[$pid_with_number]['dayssubextension'] = $contractstatus['dayssubextension'];
    $_SESSION[$pid_with_number]['daysextension'] = $contractstatus['daysextension'];
    $_SESSION[$pid_with_number]['newsubcompletedate'] = $contractstatus['newsubcompletedate'];
    $_SESSION[$pid_with_number]['newcompletedate'] = $contractstatus['newcompletedate'];
    $_SESSION[$pid_with_number]['originalcontractamt'] = $contractstatus['originalcontractamt'];
    $_SESSION[$pid_with_number]['revisedcontractamt'] = $contractstatus['revisedcontractamt'];
    $_SESSION[$pid_with_number]['adjtodate'] = $contractstatus['adjtodate'];
    $_SESSION[$pid_with_number]['percentcompl'] = $contractstatus['percentcompl'];
    $_SESSION[$pid_with_number]['totalworkcompleted'] = $contractstatus['totalworkcompleted'];
    $_SESSION[$pid_with_number]['prepayment'] = $contractstatus['prepayment'];
    $_SESSION[$pid_with_number]['materialstoredonsite'] = $contractstatus['materialstoredonsite'];
    $_SESSION[$pid_with_number]['subtotal1'] = $contractstatus['subtotal1'];
    $_SESSION[$pid_with_number]['liquiddamage'] = $contractstatus['liquiddamage'];
    $_SESSION[$pid_with_number]['subtotal2'] = $contractstatus['subtotal2'];
    $_SESSION[$pid_with_number]['retainage'] = $contractstatus['retainage'];
    $_SESSION[$pid_with_number]['retainagedollar'] = $contractstatus['retainagedollar'];
    $_SESSION[$pid_with_number]['subtotal3'] = $contractstatus['subtotal3'];
    $_SESSION[$pid_with_number]['previouspayment'] = $contractstatus['previouspayment'];
    $_SESSION[$pid_with_number]['amountdue'] = $contractstatus['amountdue'];
    $_SESSION[$pid_with_number]['projectid'] = $contractstatus['projectid'];
    $_SESSION[$pid_with_number]['location'] = $contractstatus['location'];
  }
  if($contractchangeorder != '')
  {
    $pid_with_number = 'pid'.$pid;
    $contractchangeorder = json_decode($contractchangeorder, true);

    $_SESSION[$pid_with_number]['order_sel_con'] = $contractchangeorder['order_sel_con'];
    $_SESSION[$pid_with_number]['order_sel_eng'] = $contractchangeorder['order_sel_eng'];
    $_SESSION[$pid_with_number]['order_sel_own'] = $contractchangeorder['order_sel_own'];
    $_SESSION[$pid_with_number]['order_sel_con_order'] = $contractchangeorder['order_sel_con_order'];
    $_SESSION[$pid_with_number]['order_sel_eng_order'] = $contractchangeorder['order_sel_eng_order'];
    $_SESSION[$pid_with_number]['order_sel_own_order'] = $contractchangeorder['order_sel_own_order'];

    $_SESSION[$pid_with_number]['orderSignerOrderCheckSession'] = $contractchangeorder['orderSignerOrderCheckSession'];
    $_SESSION[$pid_with_number]['originalcontractamount'] = $contractchangeorder['originalcontractamount'];
    $_SESSION[$pid_with_number]['netofpreviouschangeorder'] = $contractchangeorder['netofpreviouschangeorder'];
    $_SESSION[$pid_with_number]['adjustedcontractamount'] = $contractchangeorder['adjustedcontractamount'];
    $_SESSION[$pid_with_number]['newcontractamountincludingthischangeorder'] = $contractchangeorder['newcontractamountincludingthischangeorder'];

    $_SESSION[$pid_with_number]['changeordernumber'] = $contractchangeorder['changeordernumber'];
    $_SESSION[$pid_with_number]['descriptionofchange'] = $contractchangeorder['descriptionofchange'];
    $_SESSION[$pid_with_number]['decreasein'] = $contractchangeorder['decreasein'];
    $_SESSION[$pid_with_number]['increasein'] = $contractchangeorder['increasein'];
    $_SESSION[$pid_with_number]['noticetoproceeddays'] = $contractchangeorder['noticetoproceeddays'];
    $_SESSION[$pid_with_number]['noticetoproceeddate'] = $contractchangeorder['noticetoproceeddate'];
    $_SESSION[$pid_with_number]['originalcontracttimedays'] = $contractchangeorder['originalcontracttimedays'];
    $_SESSION[$pid_with_number]['originalcontracttimedate'] = $contractchangeorder['originalcontracttimedate'];
    $_SESSION[$pid_with_number]['netofpreviouschangeordertimedays'] = $contractchangeorder['netofpreviouschangeordertimedays'];
    $_SESSION[$pid_with_number]['netofpreviouschangeordertimedate'] = $contractchangeorder['netofpreviouschangeordertimedate'];
    $_SESSION[$pid_with_number]['adjustedcontracttimedays'] = $contractchangeorder['adjustedcontracttimedays'];
    $_SESSION[$pid_with_number]['adjustedcontracttimedate'] = $contractchangeorder['adjustedcontracttimedate'];
    $_SESSION[$pid_with_number]['addtimedays'] = $contractchangeorder['addtimedays'];
    $_SESSION[$pid_with_number]['addtimedate'] = $contractchangeorder['addtimedate'];
    $_SESSION[$pid_with_number]['deducttimedays'] = $contractchangeorder['deducttimedays'];
    $_SESSION[$pid_with_number]['deducttimedate'] = $contractchangeorder['deducttimedate'];
    $_SESSION[$pid_with_number]['changeordersubtotaldays'] = $contractchangeorder['changeordersubtotaldays'];
    $_SESSION[$pid_with_number]['changeordersubtotaldate'] = $contractchangeorder['changeordersubtotaldate'];
    $_SESSION[$pid_with_number]['presentcontracttimedays'] = $contractchangeorder['presentcontracttimedays'];
    $_SESSION[$pid_with_number]['presentcontracttimedate'] = $contractchangeorder['presentcontracttimedate'];
    $_SESSION[$pid_with_number]['thischargeadddeductdays'] = $contractchangeorder['thischargeadddeductdays'];
    $_SESSION[$pid_with_number]['thischargeadddeductdate'] = $contractchangeorder['thischargeadddeductdate'];
    $_SESSION[$pid_with_number]['newcontracttimedays'] = $contractchangeorder['newcontracttimedays'];
    $_SESSION[$pid_with_number]['newcontracttimedate'] = $contractchangeorder['newcontracttimedate'];
    $_SESSION[$pid_with_number]['substantialcompletiondate'] = $contractchangeorder['substantialcompletiondate'];
    $_SESSION[$pid_with_number]['finalcompletiondate'] = $contractchangeorder['finalcompletiondate'];
    $_SESSION[$pid_with_number]['changeordersubtotal'] = $contractchangeorder['changeordersubtotal'];
    $_SESSION[$pid_with_number]['add'] = $contractchangeorder['add'];
    $_SESSION[$pid_with_number]['net'] = $contractchangeorder['net'];
    $_SESSION[$pid_with_number]['deduct'] = $contractchangeorder['deduct'];
    $_SESSION[$pid_with_number]['originalcontractsum'] = $contractchangeorder['originalcontractsum'];
    $_SESSION[$pid_with_number]['presentcontractsum'] = $contractchangeorder['presentcontractsum'];
    $_SESSION[$pid_with_number]['newcontractsum'] = $contractchangeorder['newcontractsum'];
    $_SESSION[$pid_with_number]['reflectcontractorder'] = $contractchangeorder['reflectcontractorder'];
    $_SESSION[$pid_with_number]['thru'] = $contractchangeorder['thru'];
  }

  if($dailyobservation != '')
  {
    $pid_with_number = 'pid'.$pid;
    $dailyobservation = json_decode($dailyobservation, true);

    $_SESSION[$pid_with_number]['daily_sel_con'] = $dailyobservation['daily_sel_con'];
    $_SESSION[$pid_with_number]['daily_sel_eng'] = $dailyobservation['daily_sel_eng'];
    $_SESSION[$pid_with_number]['daily_sel_own'] = $dailyobservation['daily_sel_own'];
    $_SESSION[$pid_with_number]['weather'] = $dailyobservation['weather'];
    $_SESSION[$pid_with_number]['temperature'] = $dailyobservation['temperature'];
    $_SESSION[$pid_with_number]['time'] = $dailyobservation['time'];
    $_SESSION[$pid_with_number]['temperaturetime'] = $dailyobservation['temperaturetime'];
    $_SESSION[$pid_with_number]['raingaugereading'] = $dailyobservation['raingaugereading'];
    $_SESSION[$pid_with_number]['date'] = $dailyobservation['date'];
    $_SESSION[$pid_with_number]['contractday'] = $dailyobservation['contractday'];
    $_SESSION[$pid_with_number]['hoursonsite'] = $dailyobservation['hoursonsite'];
    $_SESSION[$pid_with_number]['contractor'] = $dailyobservation['contractor'];
    $_SESSION[$pid_with_number]['workforce'] = $dailyobservation['workforce'];
    $_SESSION[$pid_with_number]['equipment'] = $dailyobservation['equipment'];
    $_SESSION[$pid_with_number]['workactivities'] = $dailyobservation['workactivities'];
    $_SESSION[$pid_with_number]['testsperformed'] = $dailyobservation['testsperformed'];
    $_SESSION[$pid_with_number]['materialsdelivered'] = $dailyobservation['materialsdelivered'];
    $_SESSION[$pid_with_number]['visitors'] = $dailyobservation['visitors'];
    $_SESSION[$pid_with_number]['defectiveworktobecorrected'] = $dailyobservation['defectiveworktobecorrected'];
  }

  if($fdot != '')
  {
     
    $pid_with_number = 'pid'.$pid;
    $fdot = json_decode($fdot, true);
    $_SESSION[$pid_with_number]['fdot_sel_con'] = $fdot['fdot_sel_con'];
    $_SESSION[$pid_with_number]['fdot_sel_eng'] = $fdot['fdot_sel_eng'];
    $_SESSION[$pid_with_number]['fdot_sel_own'] = $fdot['fdot_sel_own'];

    $_SESSION[$pid_with_number]['invoicenumber'] = $fdot['invoicenumber'];
    $_SESSION[$pid_with_number]['phasebeinginvoiced'] = $fdot['phasebeinginvoiced'];
    $_SESSION[$pid_with_number]['financialprojectid'] = $fdot['financialprojectid'];
    $_SESSION[$pid_with_number]['contractnumber'] = $fdot['contractnumber'];
    $_SESSION[$pid_with_number]['projectdescription'] = $fdot['projectdescription'];
    $_SESSION[$pid_with_number]['attn'] = $fdot['attn'];
    $_SESSION[$pid_with_number]['jpalapexecutiondate'] = $fdot['jpalapexecutiondate'];
    $_SESSION[$pid_with_number]['localagencyname'] = $fdot['localagencyname'];
    $_SESSION[$pid_with_number]['localagencyaddress'] = $fdot['localagencyaddress'];
    $_SESSION[$pid_with_number]['servicebegindate'] = $fdot['servicebegindate'];
    $_SESSION[$pid_with_number]['serviceenddate'] = $fdot['serviceenddate'];
    $_SESSION[$pid_with_number]['daysuntilcurrentphassecompletion'] = $fdot['daysuntilcurrentphassecompletion'];
    $_SESSION[$pid_with_number]['totalamountofreimbursementagreement'] = $fdot['totalamountofreimbursementagreement'];
    $_SESSION[$pid_with_number]['totalpreviouslybilled'] = $fdot['totalpreviouslybilled'];
    $_SESSION[$pid_with_number]['totalforcurrentbilling'] = $fdot['totalforcurrentbilling'];
    $_SESSION[$pid_with_number]['percentageofjpalapfundsexpended'] = $fdot['percentageofjpalapfundsexpended'];
    $_SESSION[$pid_with_number]['balanceonjpalapagreement'] = $fdot['balanceonjpalapagreement'];
    
  }
}






 if(!isset($_SESSION['userid']))
{ 
	header("Location:login.php");
}

include("include/header.php");

$project_session_id = $_SESSION['pid'];
$getprojectrowquery="SELECT * FROM projects where project_id = $project_session_id";
$getprojectrowresult = mysqli_query($cxn,$getprojectrowquery);
$getprojectrow=mysqli_fetch_assoc($getprojectrowresult);
if($getprojectrow != null)
extract($getprojectrow);

?>

<?php include("include/projectsidebar.php"); ?>
<?php  include("include/popup.php"); ?>  
      
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 ">

  
  <div class="row paddingtop10 borderbottom">            
   <span class='indexpage_header'><?php echo $project_name; ?></span>
  </div>
  
  <div class="row-fluid">
    <h4><u>Overview</u><span class="pull-right"><a href="editproject.php?projectid=<?php echo $_SESSION['pid']; ?>"><span class="glyphicon glyphicon-cog arrow"></span></a></span></h4>
    <p><b>Project Number: </b><?php echo $project_number; ?></p>   
    <p><b>Status: </b><?php echo $project_status; ?></p>
    <p><b>Type: </b><?php echo $project_type; ?></p>
    <p><b>Funding Sources: </b><?php echo $project_fundingsources; ?></p>
    <p><b>District: </b><?php echo $project_district; ?></p>
    <p><b>Fiscal Year: </b><?php echo $project_fiscalyear; ?></p>
    <p><b>Work Force: </b><?php echo $project_workforce; ?></p>
    <p><b>Project Objective: </b><?php echo $project_objective; ?></p>
    <p><b>Location: </b><?php echo $project_location; ?></p>
    <p><b>Description</b></p>
    <p><?php echo $project_desc; ?></p>
    <p><b>Special Conditions</b></p>
    <p><?php echo $project_specialconditions; ?></p>
    <br>
    <br>
    <h4><u>Groups</u><span class="pull-right"><a href="groups.php?projectid=<?php echo $_SESSION['pid']; ?>"><span class="glyphicon glyphicon-cog arrow"></span></a></span></h4>
    <?php
    $groupquery = "select * from groups,gp_relation where gp_relation.groupid = groups.id and gp_relation.projectid={$_SESSION['pid']}";

    $gresult = mysqli_query($cxn,$groupquery);
    $pnums = mysqli_num_rows($gresult);
    if($pnums == 0){
      echo "<p>No Groups</p>";
    }
    for($i=0; $i<$pnums; $i++){  
      $grow=mysqli_fetch_assoc($gresult);
      extract($grow);
      echo "<p>".$name."</p>";
    }
    ?>
  </div>
  
  
  
</div>


  
  
</div>

<script> document.getElementById("overview").className = "active"; </script> 
<script type="text/javascript">
$(document).ready(function(){
  checkpending();
})
</script>
<?php

include("include/footer.php");

?>




