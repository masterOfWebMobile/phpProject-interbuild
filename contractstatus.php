<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
require_once 'vendor/autoload.php';
include("include/header.php");
if(!isset($_SESSION['userid']))
{ 
	header("Location:login.php");
}
include("include/projectsidebar.php"); 
$pid = $_SESSION['pid'];
$pid_with_number = 'pid'.$pid;
$userid = $_SESSION['userid'];
$uquery = "Select distinct user_email,account_organization, account_organization_type ,account_location,account_zip,account_fax,account_firstname,account_phone,account_lastname,account_title from accounts,users,gp_relation,gu_relation where gp_relation.projectid = {$_SESSION['pid']} and gp_relation.groupid=gu_relation.groupid and gu_relation.userid=users.user_id and users.user_id = accounts.account_userid";
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
   <span class='indexpage_header'>Contract Status</span>
  </div>
  
<div id="content ">
    <ul id="tabs" class="nav nav-tabs paddingtop10" data-tabs="tabs">
        <li class="active"><a href="#current" data-toggle="tab">Current</a></li>
        <li><a href="#past" data-toggle="tab">Past</a></li>
    </ul>
    <div id="my-tab-content" class="tab-content">
        
        <div class="tab-pane active paddingtop10" id="current">
            
            <div class="row paddingright10 pull-right">
              <button class='btn btn-default btn-large' <?php if($role == 3) echo 'disabled' ?> onclick="savecontractstatus();">Save Draft</button>
              <button class='btn btn-success btn-warning' <?php if($role == 3) echo 'disabled' ?> onclick="printcontractstatus(1, '<?php echo $project_name; ?>')">Save as PDF</button>
              <button class='btn btn-info' <?php if($role == 3) echo 'disabled' ?> onclick="sendcontractstatusforsig(1, '<?php echo $project_name; ?>','<?php echo $_SESSION['useremail']; ?>')">Send For Signatures</button>

            </div>
            <br>
            <br>
            
            <form method='post' action='contractstatussave.php' id='contractstatusform'> 
            <div class="row">
              <div class="col-md-12">
                <h4>Document Detail</h4>
                <div class="checkbox" style="margin-left: 15px !important">
                  <label >
                    <input type="checkbox" id="signerOrderCheck" <?php echo $_SESSION[$pid_with_number]['signerOrderCheckSessionStatus']; ?>> Setting signers' order
                    <input type="text" id="signerOrderCheckSessionStatus" name="signerOrderCheckSessionStatus" value="<?php echo $_SESSION[$pid_with_number]['signerOrderCheckSessionStatus']; ?>" style="display:none">
                
                  </label>
                </div>
                <script>
                  $('#signerOrderCheck').on('change', function() {

                      if (this.checked) {
                        //$('.selgroup .bootstrap-select:first-child').css("display", null);
                        $('#signerOrderCheckSessionStatus').val('checked');
                        $('#sel_con_order').selectpicker("show");
                        $('#sel_eng_order').selectpicker("show");
                        $('#sel_own_order').selectpicker("show");
                      }
                      else {
                        $('#signerOrderCheckSessionStatus').val('checked');
                        $('#sel_con_order').selectpicker("hide");
                        $('#sel_eng_order').selectpicker("hide");
                        $('#sel_own_order').selectpicker("hide");
                      }
                  });
                </script>
                <div class="col-md-4">
                  <h5>Signer</h5>
                  <div class="selgroup">
                  <select id="sel_con_order" name="sel_con_order" class="selectpicker">

                    <option value="-">-</option>
                    <?php
                    for($i=1; $i<4; $i++){
                      echo "<option value='{$i}' ";
                      if($i == $_SESSION[$pid_with_number]['sel_con_order'] && isset($_SESSION[$pid_with_number]['sel_con_order']) && $_SESSION[$pid_with_number]['sel_con_order']!="-")
                        echo "selected ";
                      echo ">{$i}</option>";
                    }
                    ?> 
                  </select>
                  <select id="sel_con" name="sel_con" class="selectpicker">
                    <option value="-">-</option>
                    <?php
                    for($i=0; $i<$unums; $i++){
                      echo "<option value={$i} ";
                      if($i == $_SESSION[$pid_with_number]['sel_con'] && isset($_SESSION[$pid_with_number]['sel_con']) && $_SESSION[$pid_with_number]['sel_con']!="-")
                        echo "selected ";
                      echo ">{$users[$i]['account_firstname']} {$users[$i]['account_lastname']}</option>";
                    }
                    ?>                   
                  </select>
                </div>
                </div>
                <div class="col-md-4">
                  <h5>Signer</h5>
                  <div class="selgroup">
                  <select id="sel_eng_order" name="sel_eng_order" class="selectpicker">

                    <option value="-" >-</option>
                    <?php
                    for($i=1; $i<4; $i++){
                      echo "<option value='{$i}' ";
                      if($i == $_SESSION[$pid_with_number]['sel_eng_order'] && isset($_SESSION[$pid_with_number]['sel_eng_order']) && $_SESSION[$pid_with_number]['sel_eng_order']!="-")
                        echo "selected ";
                      echo ">{$i}</option>";
                    }
                    ?> 
                  </select>
                  <select id="sel_eng" name="sel_eng" class="selectpicker">
                    <option value="-">-</option>
                    <?php
                    for($i=0; $i<$unums; $i++){
                      echo "<option value={$i} ";
                      if($i == $_SESSION[$pid_with_number]['sel_eng'] && isset($_SESSION[$pid_with_number]['sel_eng']) && $_SESSION[$pid_with_number]['sel_eng']!="-")
                        echo "selected ";
                      echo ">{$users[$i]['account_firstname']} {$users[$i]['account_lastname']}</option>";
                    }
                    ?>                   
                  </select>  
                  </div>                
                </div>
                <div class="col-md-4">
                  <h5>Signer</h5>
                  <div class="selgroup">
                  <select id="sel_own_order" name="sel_own_order" class="selectpicker">

                    <option value="-">-</option>
                    <?php
                    for($i=1; $i<4; $i++){
                      echo "<option value='{$i}' ";
                      if($i == $_SESSION[$pid_with_number]['sel_own_order'] && isset($_SESSION[$pid_with_number]['sel_own_order']) && $_SESSION[$pid_with_number]['sel_own_order']!="-")
                        echo "selected ";
                      echo ">{$i}</option>";
                    }
                    ?> 
                  </select>
                  <select id="sel_own" name="sel_own" class="selectpicker">
                    <option value="-">-</option>
                    <?php
                    for($i=0; $i<$unums; $i++){
                      echo "<option value={$i} ";
                      if($i == $_SESSION[$pid_with_number]['sel_own'] && isset($_SESSION[$pid_with_number]['sel_own']) && $_SESSION[$pid_with_number]['sel_own']!="-")
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
                <div class = "col-md-6">
                  <div class="form-group">
                    <label>Period Covered</label>
                    <div class="input-group date" data-provide="datepicker">
                        <input id="input_cfrom" name="input_cfrom" type="text" class="form-control" value="<?php echo $_SESSION[$pid_with_number]['input_cfrom']; ?>">
                        <div class="input-group-addon">
                          <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                  </div>
                </div>
                <div class = "col-md-6">
                  <div class="form-group">
                    <label>through</label>
                    <div class="input-group date" data-provide="datepicker">
                        <input id="input_cto" name="input_cto" type="text" class="form-control" value="<?php echo $_SESSION[$pid_with_number]['input_cto']; ?>">
                        <div class="input-group-addon">
                          <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <hr>  
            <div class="row">
             
              <div class="col-md-6">
                <h5><u>Contract Data</u></h5>
                        					
                  <div class="form-group">
                    <label>Bids Received Date</label>
                    <div class="input-group date" data-provide="datepicker">
                        <input id="bidsres" type="text" class="form-control" name='bidsreceiveddate' value="<?php echo $_SESSION[$pid_with_number]['bidsreceiveddate']; ?>">
                        <div class="input-group-addon">
                          <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                  </div>
                  
                   <div class="form-group">
                    <label>Contract Date</label>
                    <div class="input-group date" data-provide="datepicker">
                        <input type="text" class="form-control" name='contractdate' value="<?php echo $_SESSION[$pid_with_number]['contractdate']; ?>">
                        <div class="input-group-addon">
                          <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                  </div>
                  
                   <div class="form-group">
                    <label>Notice To Proceed</label>
                    <div class="input-group date" data-provide="datepicker">
                        <input type="text" class="form-control" name='noticetoproceed' value="<?php echo $_SESSION[$pid_with_number]['noticetoproceed']; ?>">
                        <div class="input-group-addon">
                          <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                  </div>

                  
        					<div class='form-group'>
        						<label>Calendar Days To Substantial Completion</label>
        						<input  type='text' name='daystosubcomplete' class='form-control numeric' value="<?php echo $_SESSION[$pid_with_number]['daystosubcomplete']; ?>"> 
        					</div>	
        					
        					<div class='form-group'>
                    <label>Calendar Days To Final Completion</label>
                    <input  type='text' name='daystocomplete' class='form-control numeric' value="<?php echo $_SESSION[$pid_with_number]['daystocomplete']; ?>"> 
                  </div>

        					<div class="form-group">
                    <label>Original Substantial Completion Date</label>
                    <div class="input-group date" data-provide="datepicker">
                        <input type="text" class="form-control calculated" name='originalsubstcompletedate' value="<?php echo $_SESSION[$pid_with_number]['originalsubstcompletedate']; ?>">
                        <div class="input-group-addon">
                          <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                  </div>
        					
        					 <div class="form-group">
                    <label>Original Completion Date</label>
                    <div class="input-group date" data-provide="datepicker">
                        <input type="text" class="form-control calculated" name='originalcompletedate' value="<?php echo $_SESSION[$pid_with_number]['originalcompletedate']; ?>">
                        <div class="input-group-addon">
                          <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                  </div>
        					
        					 <div class='form-group'>
        						<label>Days Extension, Substantial Completion</label>
        						<input  type='text' name='dayssubextension' class='form-control numeric' value="<?php echo $_SESSION[$pid_with_number]['dayssubextension']; ?>"> 
        					</div>	

                  <div class='form-group'>
                    <label>Days Extension, Final Completion</label>
                    <input  type='text' name='daysextension' class='form-control numeric' value="<?php echo $_SESSION[$pid_with_number]['daysextension']; ?>"> 
                  </div>

                  <div class="form-group">
                    <label>New Substantial Completion Date</label>
                    <div class="input-group date" data-provide="datepicker">
                        <input type="text" class="form-control calculated" name='newsubcompletedate' value="<?php echo $_SESSION[$pid_with_number]['newsubcompletedate']; ?>">
                        <div class="input-group-addon">
                          <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                  </div>
        					
        					<div class="form-group">
                    <label>New Completion Date</label>
                    <div class="input-group date" data-provide="datepicker">
                        <input type="text" class="form-control calculated" name='newcompletedate' value="<?php echo $_SESSION[$pid_with_number]['newcompletedate']; ?>">
                        <div class="input-group-addon">
                          <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                  </div>
                  
                  <div class='form-group'>
        						<label>Original Contract Amount $</label>
        						<input  type='text' name='originalcontractamt' class='form-control numeric' value="<?php echo $_SESSION[$pid_with_number]['originalcontractamt']; ?>"> 
        					</div>	
        					
        					 <div class='form-group'>
        						<label>Revised Contract Amount $</label>
        						<input  type='text' name='revisedcontractamt' class='form-control numeric' value="<?php echo $_SESSION[$pid_with_number]['revisedcontractamt']; ?>"> 
        					</div>	
        					
        					<div class='form-group'>
        						<label>Adjustment To Date $</label>
        						<input  type='text' name='adjtodate' class='form-control calculated' value="<?php echo $_SESSION[$pid_with_number]['adjtodate']; ?>"> 
        					</div>
        						
        					 <div class='form-group'>
        						<label>Percentage Complete (% Basis)</label>
        						<input  type='text' name='percentcompl' class='form-control numeric' value="<?php echo $_SESSION[$pid_with_number]['percentcompl']; ?>"> 
        					</div>
            
            <br><br>
              </div>
              
              <div class="col-md-6">
                <h5><u>Summary of Job Status</u></h5>
                 
                  
         					<div class='form-group'>
        						<label>Total Work Completed ($)</label>
        						<input  type='text' name='totalworkcompleted' class='form-control numeric calculated' value="<?php echo $_SESSION[$pid_with_number]['totalworkcompleted']; ?>"> 
        					</div>	
        					
        					<div class='form-group'>
        						<label>Prepayment ($)</label>
        						<input  type='text' name='prepayment' class='form-control numeric' value="<?php echo $_SESSION[$pid_with_number]['prepayment']; ?>"> 
        					</div>	
                  
        					 <div class='form-group'>
        						<label>Material Stored on  Site ($)</label>
        						<input  type='text' name='materialstoredonsite' class='form-control numeric' value="<?php echo $_SESSION[$pid_with_number]['materialstoredonsite']; ?>"> 
        					</div>	
                  
                  <div class='form-group'>
        						<label>Subtotal ($)</label>
        						<input  type='text' name='subtotal1' class='form-control numeric calculated' value="<?php echo $_SESSION[$pid_with_number]['subtotal1']; ?>"> 
        					</div>
                  
                  <div class='form-group'>
        						<label>Less Liquidated Damages ($)</label>
        						<input  type='text' name='liquiddamage' class='form-control numeric' value="<?php echo $_SESSION[$pid_with_number]['liquiddamage']; ?>"> 
        					</div>	
                  
                  <div class='form-group'>
        						<label>Subtotal ($)</label>
        						<input  type='text' name='subtotal2' class='form-control numeric calculated' value="<?php echo $_SESSION[$pid_with_number]['subtotal2']; ?>"> 
        					</div>
                  
                  <div class='form-group'>
        						<label>Less Retainage (% Basis)</label>
        						<input  type='text' name='retainage' class='form-control numeric' value="<?php echo $_SESSION[$pid_with_number]['retainage']; ?>"> 
        					</div>
        					
        					 <div class='form-group'>
        						<label>Less Retainage ($)</label>
        						<input  type='text' name='retainagedollar' class='form-control numeric calculated' value="<?php echo $_SESSION[$pid_with_number]['retainagedollar']; ?>"> 
        					</div>	
                  
                                    
                    <div class='form-group'>
        						<label>Subtotal ($)</label>
        						<input  type='text' name='subtotal3' class='form-control numeric calculated' value="<?php echo $_SESSION[$pid_with_number]['subtotal3']; ?>"> 
        					</div>
                  
                 <div class='form-group'>
        						<label>Less Previous Payments</label>
        						<input  type='text' name='previouspayment' class='form-control' value="<?php echo $_SESSION[$pid_with_number]['previouspayment']; ?>"> 
        					</div>	
                  
                  
                    <div class='form-group'>
        						<label>Amount Due This Period: ($)</label>
        						<input  type='text' name='amountdue' class='form-control numeric calculated' value="<?php echo $_SESSION[$pid_with_number]['amountdue']; ?>"> 
        					</div>	
                  
        					                 
            		<br>
            		


                
              </div>

              <input class='span3' type="hidden" name='projectid' value='<?php echo $project_id; ?>'>

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
 
  $docsquery = "SELECT * FROM documents WHERE projectid={$_SESSION['pid']} and folderid=1 and doctype in (0,1) and document_deleted = 0 order by cdate DESC";
  $docsresult = mysqli_query($cxn,$docsquery);
  $docsnrows = mysqli_num_rows($docsresult);
  for ($z=0; $z<$docsnrows; $z++)
  {
    $docsrow=mysqli_fetch_assoc($docsresult);
    if($docsrow != null)
      extract($docsrow);
    
    echo"<div class='row'>";
          
    echo"        <div class='file'>";
                
    echo"            <span class='filename'><a target='_blank' href='$document_location'>$document_name</a></span>&nbsp;&nbsp;";
    if ($doctype == 0)
      echo "<img src='images/hello-sign.png' class='hello'>";
    echo "<span class='pull-right'>".date("Y-m-d h:i:s A",$cdate)."</span>";            
    echo"          </div>";
    echo" </div>";
    
}
?>
                     
    </div>
</div>


   
</div> <!-- container -->
  
</div>  
<script type="text/javascript"> projectid = <?php echo $projectid;?></script>

<?php include("contractstatushidden.php");?>

<script> document.getElementById("contractstatus").className = "active"; </script>
<script>
  $(document).ready(function(){
    if ($('#signerOrderCheck').prop('checked')) {
      $('#sel_con_order').selectpicker("show");
      $('#sel_eng_order').selectpicker("show");
      $('#sel_own_order').selectpicker("show");
    }
    else {
      $('#sel_con_order').selectpicker("hide");
      $('#sel_eng_order').selectpicker("hide");
      $('#sel_own_order').selectpicker("hide");
    }
    checkpending();

    $(".numeric").numericInput({ allowFloat: true });
    
    $('.date').datepicker({
      orientation: 'bottom'
    });

    $('[name="noticetoproceed"]').change(function(){
      contractstatuscalcs();
    });

    $('[name="daystosubcomplete"]').keyup(function(){
      contractstatuscalcs();
    });

    $('[name="daystocomplete"]').keyup(function(){
      contractstatuscalcs();
    });

    $('[name="originalcompletedate"]').change(function(){
      contractstatuscalcs();
    });

    $('[name="dayssubextension"]').keyup(function(){
      contractstatuscalcs();
    });

    $('[name="daysextension"]').keyup(function(){
      contractstatuscalcs();
    });   

    $('[name="originalcontractamt"]').keyup(function(){
      contractstatuscalcs();
    });

    $('[name="revisedcontractamt"]').keyup(function(){
      contractstatuscalcs();
    });

    $('[name="percentcompl"]').keyup(function(){
      contractstatuscalcs();
    });

    $('[name="totalworkcompleted"]').keyup(function(){
      contractstatuscalcs();
    });

    $('[name="prepayment"]').keyup(function(){
      contractstatuscalcs();
    });

    $('[name="materialstoredonsite"]').keyup(function(){
      contractstatuscalcs();
    });

    $('[name="subtotal1"]').keyup(function(){
      contractstatuscalcs();
    });

    $('[name="liquiddamage"]').keyup(function(){
      contractstatuscalcs();
    });

    $('[name="subtotal2"]').keyup(function(){
      contractstatuscalcs();
    });

    $('[name="retainage"]').keyup(function(){
      contractstatuscalcs();
    });

    $('[name="subtotal3"]').keyup(function(){
      contractstatuscalcs();
    });

    $('[name="previouspayment"]').keyup(function(){
      contractstatuscalcs();
    });

});
</script>

<?php

include("include/footer.php");

?>




