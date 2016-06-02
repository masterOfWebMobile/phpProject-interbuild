<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
require_once 'vendor/autoload.php';
include("include/header.php");
if(!isset($_SESSION['userid']))
{ 
	header("Location:login.php");
}

$userid = $_SESSION['userid'];
$pid = $_SESSION['pid'];
$pid_with_number = 'pid'.$pid;
include("include/projectsidebar.php"); 
$uquery = "Select distinct user_email,account_organization, account_organization_type,account_location,account_zip,account_fax,account_firstname,account_phone,account_lastname,account_title from accounts,users,gp_relation,gu_relation where gp_relation.projectid = {$_SESSION['pid']} and gp_relation.groupid=gu_relation.groupid and gu_relation.userid=users.user_id and users.user_id = accounts.account_userid";
$uresult = mysqli_query($cxn, $uquery);
$unums = mysqli_num_rows($uresult);
$users = array();
for($i=0;$i<$unums; $i++){
  $row = mysqli_fetch_assoc($uresult);
  $users[$i] = $row;
}

$rolequery = "Select distinct role as role from users,gp_relation,gu_relation where gp_relation.projectid = {$_SESSION['pid']} and gp_relation.groupid=gu_relation.groupid and gu_relation.userid=users.user_id and users.user_id = $userid";
$roleresult = mysqli_query($cxn, $rolequery);
$rolerow = mysqli_fetch_assoc($roleresult);
extract($rolerow);

  $userquery = "Select * from users where user_id = {$userid}";
  $userresult = mysqli_query($cxn, $userquery);
  $userrow = mysqli_fetch_assoc($userresult);
  if($userrow != null)
  extract($userrow);

?>
<script>
var users = JSON.parse('<?php echo json_encode($users);?>',true);
var project_name = "<?php echo $_SESSION['project_name'];?>";
var project_number = "<?php echo $_SESSION['project_number'];?>";
</script>
<div class="col-sm-10 col-sm-offset-2 col-md-10 col-md-offset-2 ">
<?php  
include("include/alerts.php");   
?>  
<div id="goodalert" class='row' style="display:none">
            <div class='alert alert-success alert-dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <strong>Success!</strong> You have saved the document.
            </div>
</div>
          
  <div class="row paddingtop10 borderbottom paddingright10">            
   <span class='indexpage_header'>FDOT</span>
  </div>
  
<div id="content ">
  <?php 
  if($role > 1)
  {
    echo "Permission Denied";
    exit;
  }
  ?>
    <ul id="tabs" class="nav nav-tabs paddingtop10" data-tabs="tabs">
        <li class="active"><a href="#current" data-toggle="tab">Current</a></li>
        <li><a href="#past" data-toggle="tab">Past</a></li>
    </ul>
    <div id="my-tab-content" class="tab-content">
        
        <div class="tab-pane active paddingtop10" id="current">
            
            <div class="row paddingright10 pull-right">
              <button class='btn btn-default btn-large' onclick="savefdot();">Save Draft</button>
              <button class='btn btn-success btn-warning' onclick="printfdot(4, '<?php echo $project_name; ?>')">Save as PDF</button>
              <button class='btn btn-info' onclick="sendfdotforsig(4, '<?php echo $project_name; ?>','<?php echo $_SESSION['useremail']; ?>')">Send For Signatures</button>

            </div>
            <br>
             <br>
            
              <form method='post' action='fdotsave.php' id='fdotform'> 
            
              <div class="col-md-12">
                <h4>Document Detail</h4>
              </div>
              <div class="col-md-12">
                <div class="col-md-4" style="padding-left: 0 !important">
                  <h5>Signer</h5>
                  <select id="fdot_sel_con" name="fdot_sel_con" class="selectpicker">
                    <option value="-">-</option>
                    <?php
                    for($i=0; $i<$unums; $i++){
                      echo "<option value={$i} ";
                      if($i == $_SESSION[$pid_with_number]['fdot_sel_con'] && isset($_SESSION[$pid_with_number]['fdot_sel_con']) && $_SESSION[$pid_with_number]['fdot_sel_con']!="-")
                        echo "selected ";
                      echo ">{$users[$i]['account_firstname']} {$users[$i]['account_lastname']}</option>";
                    }
                    ?>                   
                  </select>
                </div>
                <div class="col-md-4" style="display:none">
                  <h5>Engineer</h5>
                  <select id="fdot_sel_eng" name="fdot_sel_eng" class="selectpicker">
                    <option value="-">-</option>
                    <?php
                    for($i=0; $i<$unums; $i++){
                      echo "<option value={$i} ";
                      if($i == $_SESSION[$pid_with_number]['fdot_sel_eng'] && isset($_SESSION[$pid_with_number]['fdot_sel_eng']) && $_SESSION[$pid_with_number]['fdot_sel_eng']!="-")
                        echo "selected ";
                      echo ">{$users[$i]['account_firstname']} {$users[$i]['account_lastname']}</option>";
                    }
                    ?>                   
                  </select>                  
                </div>

                <div class="col-md-4" style="display:none">
                  <h5>Owner</h5>
                  <select id="fdot_sel_own" name="fdot_sel_own" class="selectpicker">
                    <option value="-">-</option>
                    <?php
                    for($i=0; $i<$unums; $i++){
                      echo "<option value={$i} ";
                      if($i == $_SESSION[$pid_with_number]['fdot_sel_own'] && isset($_SESSION[$pid_with_number]['fdot_sel_own']) && $_SESSION[$pid_with_number]['fdot_sel_own']!="-")
                        echo "selected ";
                      echo ">{$users[$i]['account_firstname']} {$users[$i]['account_lastname']}</option>";
                    }
                    ?>                   
                  </select>
                </div>
              </div>
                <div class = "col-md-12">
                  &nbsp;
                </div>
                <div class = "col-md-12">
                  <div class="form-group">
                    <label>Invoice Number</label>
                    <input  type='text' name='invoicenumber' class='form-control' value="<?php echo $_SESSION[$pid_with_number]['invoicenumber']; ?>"> 
                  </div>
                </div>
                <div class = "col-md-12">
                  <div class="form-group">
                    <label>Phase Being Invoiced</label>
                    <input  type='text' name='phasebeinginvoiced' class='form-control' value="<?php echo $_SESSION[$pid_with_number]['phasebeinginvoiced']; ?>"> 
                  </div>
                </div>
                <div class = "col-md-12">
                  <div class="form-group">
                    <label>Financial Project ID</label>
                    <input  type='text' name='financialprojectid' class='form-control' value="<?php echo $_SESSION[$pid_with_number]['financialprojectid']; ?>"> 
                  </div>
                </div>
                <div class = "col-md-12">
                  <div class="form-group">
                    <label>Contract Number</label>
                    <input  type='text' name='contractnumber' class='form-control numeric' value="<?php echo $_SESSION[$pid_with_number]['contractnumber']; ?>"> 
                  </div>
                </div>
                <div class = "col-md-12">
                  <div class="form-group">
                    <label>Project Description</label>
                    <input  type='text' name='projectdescription' class='form-control ' value="<?php echo $_SESSION[$pid_with_number]['contractnumber']; ?>"> 
                  </div>
                </div>

                <div class = "col-md-12">
                  <div class="form-group">
                    <label>ATTN (FDOT Representative)</label>
                    <input  type='text' name='attn' class='form-control ' value="<?php echo $_SESSION[$pid_with_number]['attn']; ?>"> 
                  </div>
                </div>

                <div class = "col-md-12">
                  <div class="form-group">
                    <label>Progress Summary of work completed</label>
                    <input  type='text' name='progresssummaryofworkcompleted' class='form-control ' value="<?php echo $_SESSION[$pid_with_number]['progresssummaryofworkcompleted']; ?>"> 
                  </div>
                </div>

                <div class = "col-md-12">
                  <div class="form-group">
                    <label>JPA/LAP Execution Date</label> 
                    <div class="input-group date" data-provide="datepicker">
                        <input type="text" class="form-control" name='jpalapexecutiondate' value="<?php echo $_SESSION[$pid_with_number]['jpalapexecutiondate']; ?>">
                        <div class="input-group-addon">
                          <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                    
                  </div>
                </div>

                <div class = "col-md-12">
                  <div class="form-group">
                    <label>Local Agency Name</label>
                    <input  type='text' name='localagencyname' class='form-control ' value="<?php echo $_SESSION[$pid_with_number]['localagencyname']; ?>"> 
                  </div>
                </div>

                <div class = "col-md-12">
                  <div class="form-group">
                    <label>Local Agency Address</label>
                    <input  type='text' name='localagencyaddress' class='form-control ' value="<?php echo $_SESSION[$pid_with_number]['localagencyaddress']; ?>"> 
                  </div>
                </div>
                <div class ="row" style="padding-left: 15px !important; padding-right: 15px !important">
                <div class = "col-md-4">
                  <div class="form-group">
                    <label>Service Beg. Date</label>
                    <div class="input-group date" data-provide="datepicker">
                        <input type="text" class="form-control" name='servicebegindate' value="<?php echo $_SESSION[$pid_with_number]['servicebegindate']; ?>">
                        <div class="input-group-addon">
                          <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div> 
                  </div>
                </div>

                <div class = "col-md-4">
                  <div class="form-group">
                    <label>Service End Date</label>
                    <div class="input-group date" data-provide="datepicker">
                        <input type="text" class="form-control" name='serviceenddate' value="<?php echo $_SESSION[$pid_with_number]['serviceenddate']; ?>">
                        <div class="input-group-addon">
                          <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div> 
                  </div>
                </div>

                <div class = "col-md-4">
                  <div class="form-group">
                    <label>Days Until Current Phase Completion</label>
                    
                        <input type="text" class="form-control numeric" name='daysuntilcurrentphassecompletion' value="<?php echo $_SESSION[$pid_with_number]['daysuntilcurrentphasecompletion']; ?>">
                    
                  </div>
                </div>
              </div>
              
              <div class="row" style="padding-left:15px !important; padding-right:15px !important; margin-bottom: 30px !important; margin-top: 30px !important">
                <div class="col-md-12">
                  <label>The invoice is for cost incurred on an Executed Joint Participation Agreeement or Local Agency Program Agreement.</label>
                </div>
              </div>

              <div class ="row" style="padding-left: 15px !important; padding-right: 15px !important">
                <div class = "col-md-4">
                  <div class="form-group">
                    <label>TOTAL AMOUNT OF REIMBURSEMENT AGREEMENT ($)</label>
                    <input  type='text' name='totalamountofreimbursementagreement' class='form-control numeric' value="<?php echo $_SESSION[$pid_with_number]['totalamountofreimbursementagreement']; ?>">  
                  </div>
                </div>

                <div class = "col-md-4">
                  <div class="form-group">
                    <label>TOTAL PREVIOUSLY BILLED ($)</label>
                    <input  type='text' name='totalpreviouslybilled' class='form-control numeric' value="<?php echo $_SESSION[$pid_with_number]['totalpreviouslybilled']; ?>">
                  </div>
                </div>

                <div class = "col-md-4">
                  <div class="form-group">
                    <label>TOTAL for CURRENT BILLING ($)</label>
                    <input  type='text' name='totalforcurrentbilling' class='form-control numeric' value="<?php echo $_SESSION[$pid_with_number]['totalforcurrentbilling']; ?>">
                  </div>
                </div>
              </div>

              <div class ="row" style="padding-left: 15px !important; padding-right: 15px !important">
                <div class = "col-md-6">
                  <div class="form-group">
                    <label>Percentage of JPA/LAP FUNDS EXPENDED (%)</label>
                    <input  type='text' name='percentageofjpalapfundsexpended' class='form-control numeric calculated' value="<?php echo $_SESSION[$pid_with_number]['percentageofjpalapfundsexpended']; ?>">  
                  </div>
                </div>

                <div class = "col-md-6">
                  <div class="form-group">
                    <label>BALANCE on JPA/LAP AGREEMENT ($)</label>
                    <input  type='text' name='balanceonjpalapagreement' class='form-control numeric calculated' value="<?php echo $_SESSION[$pid_with_number]['balanceonjpalapagreement']; ?>">
                  </div>
                </div>

              </div>

              <div class="row" style="padding-left:15px !important; padding-right:15px !important; margin-top: 30px !important; margin-bottom: 30px !important">
                <div class="col-md-12">
                <label>I certify, under penalty of perjury, that the aforesaid listing is true and correct, that requested reimbursements are for actual cost incurred, that our agency has compiled with all previsions of the above referenced Agreement, including terms and conditions of procurement, and that the supporting documentation submitted is sufficient for a proper pre-audit and post-audit thereof and is availalble for review upon request.</label>
                </div>
              </div>
             
              </form> 
              <form id='file_attach' enctype="multipart/form-data">
              <div class='form-group'>
                  <label >Attach Files</label>                
                  <input id='input_file' name="file[]" type='file' multiple>
              </div>
            </form>
            </div>
                      
      
        
        
        
        <div class="tab-pane paddingtop10" id="past">
            <div class="">
 <?php
 
  $docsquery = "SELECT * FROM documents WHERE projectid={$_SESSION['pid']} and folderid=4 and doctype in (0,1) and document_deleted = 0 order by cdate DESC";
  $docsresult = mysqli_query($cxn,$docsquery);
  $docsnrows = mysqli_num_rows($docsresult);
  for ($z=0; $z<$docsnrows; $z++)
  {
    $docsrow=mysqli_fetch_assoc($docsresult);
    extract($docsrow);
    
    echo"<div class='row'>";
          
    echo"        <div class='file'>";
                
    echo"            <span class='filename'><a target='_blank' href='$document_location'>$document_name</a></span>&nbsp;&nbsp;";
    if ($doctype == 0)
      echo "<img src='images/hello-sign.png' class='hello'>";
    echo "<span class='pull-right'>".date("Y-m-d h:i:s A",$cdate)."</span>";
    /*echo"            <div class='pull-right' style='display:none'>";
    echo"              <button class='btn btn-info' onclick=requestsig('$document_location');>Send For Signature</button>";
    echo"              <button class='btn btn-danger'>Delete</button>";
    echo"            </div>";        */        
    echo"          </div>";
    echo" </div>";
    
}
?>
                     
    </div>
</div>


   
</div> <!-- container -->
  
</div>  
<script type="text/javascript"> projectid = <?php echo $projectid;?></script>
<?php include("fdothidden.php");?>

<script> document.getElementById("fdot").className = "active"; </script>
<script>
  $(document).ready(function(){
    checkpending();
    $(".numeric").numericInput({ allowFloat: true });
    
    $('.date').datepicker({
      orientation: 'bottom'
    });


    $('[name="totalamountofreimbursementagreement"]').keyup(function(){
      fdotcalcs();
    });

    $('[name="totalpreviouslybilled"]').keyup(function(){
      fdotcalcs();
    });

    $('[name="totalforcurrentbilling"]').keyup(function(){
      fdotcalcs();
    });

    

});
</script>

<?php

include("include/footer.php");

?>




