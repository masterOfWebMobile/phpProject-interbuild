<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
require_once 'vendor/autoload.php';
include("include/header.php");

 if(!isset($_SESSION['userid']))
{ 
	header("Location:login.php");
}





?>

<?php include("include/projectsidebar.php"); 
  $pid = $_SESSION['pid'];
  $pid_with_number = 'pid'.$pid;
  $csquery = "SELECT * FROM contractstatus WHERE cs_projectid = $project_id";
$csresult = mysqli_query($cxn,$csquery);
$userid = $_SESSION['userid'];
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

$projectQuery = "Select * from projects where project_id = $pid";
$projectresult = mysqli_query($cxn, $projectquery);
$projectrow = mysqli_fetch_assoc($projectresult);
extract($projectrow);
  
?>
<script>
var users = JSON.parse('<?php echo json_encode($users);?>',true);
var project_name = "<?php echo $_SESSION['project_name'];?>";
var project_number = "<?php echo $_SESSION['project_number'];?>";
</script>
      
<div class="col-sm-10 col-sm-offset-2 col-md-10 col-md-offset-2 ">
<?php  include("include/alerts.php"); 

  
  $csrows = mysqli_num_rows($csresult);
if($csrows != 0)
{
  $csrow = mysqli_fetch_assoc($csresult);
  if($csrow != null)
    extract($csrow); 
  $action = "update";
  
}
else
{
  $action = "new";
}
  
?>  
<div id="goodalert" class='row' style="display:none">
            <div class='alert alert-success alert-dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <strong>Success!</strong> You have saved the document.
            </div>
</div>
          
  <div class="row paddingtop10 borderbottom paddingright10">            
   <span class='indexpage_header'>Contract Change Order</span>
  </div>
  
<div id="content ">
    <ul id="tabs" class="nav nav-tabs paddingtop10" data-tabs="tabs">
        <li class="active"><a href="#current" data-toggle="tab">Current</a></li>
        <li><a href="#past" data-toggle="tab">Past</a></li>
    </ul>
    <div id="my-tab-content" class="tab-content">
        
        <div class="tab-pane active paddingtop10" id="current">
            
          <div class="row paddingright10 pull-right">
            <button class='btn btn-default btn-large' <?php if($role == 3) echo 'disabled' ?> onclick="savecontractchangeorder();">Save Draft</button>
            <button class='btn btn-success btn-warning' <?php if($role == 3) echo 'disabled' ?> onclick="printcontractchangeorder(2, '<?php echo $project_name; ?>')">Save as PDF</button>
            <button class='btn btn-info' <?php if($role == 3) echo 'disabled' ?> onclick="sendcontractchangeorderforsig(2, '<?php echo $project_name; ?>','<?php echo $_SESSION['useremail']; ?>');">Send For Signatures</button>

          </div>
          <br>
          <br>
          <form method='post' action='contractchangeordersave.php' id='contractchangeorderform'>   
          <div class="row">
            
              <div class="col-md-12">
                <h4>Document Detail</h4>
                
              <div class="col-md-6">
                                  
                  <div class="form-group">
                    <label>Change Order Number</label>
                    <input  type='text' name='changeordernumber' class='form-control' value="<?php echo $_SESSION[$pid_with_number]['changeordernumber']; ?>">
                  </div>

                  <div class="form-group">
                    <label>Project Number</label>
                    <input  type='text' name='projectnumber' class='form-control calculated' value="<?php echo $project_name; ?>">
                  </div>

                  <div class="form-group">
                    <label>Project Name</label>
                    <input  type='text' name='projectname' class='form-control calculated' value="<?php echo $project_number; ?>">
                  </div>
            
                <br>
              </div>

              <div class="col-md-12" >
                <div class="checkbox" style="margin-left: 15px !important">
                  <label >
                    <input type="checkbox" id="signerOrderCheck" name="orderSignerOrderCheck" <?php echo $_SESSION[$pid_with_number]['orderSignerOrderCheckSession']; ?>> Setting signers' order
                    <input type="text" id="signerOrderCheckSession" name="orderSignerOrderCheckSession" value="<?php echo $_SESSION[$pid_with_number]['orderSignerOrderCheckSession']; ?>" style="display:none">
                  </label>
                </div>
                <script>
                  $('#signerOrderCheck').on('change', function() {

                      if (this.checked) {
                        //$('.selgroup .bootstrap-select:first-child').css("display", null);
                        $('#signerOrderCheckSession').val('checked');
                        $('#order_sel_con_order').selectpicker("show");
                        $('#order_sel_eng_order').selectpicker("show");
                        $('#order_sel_own_order').selectpicker("show");
                      }
                      else {
                        $('#signerOrderCheckSession').val('');
                        $('#order_sel_con_order').selectpicker("hide");
                        $('#order_sel_eng_order').selectpicker("hide");
                        $('#order_sel_own_order').selectpicker("hide");
                      }
                  });
                </script>
              <div class="col-md-4" >
                  <h5>Signer</h5>
                  <div class="selgroup">
                  <select id="order_sel_con_order" name="order_sel_con_order" class="selectpicker">

                    <option value="-">-</option>
                    <?php
                    for($i=1; $i<4; $i++){
                      echo "<option value='{$i}' ";
                      if($i == $_SESSION[$pid_with_number]['order_sel_con_order'] && isset($_SESSION[$pid_with_number]['order_sel_con_order']) && $_SESSION[$pid_with_number]['order_sel_con_order']!="-")
                        echo "selected ";
                      echo ">{$i}</option>";
                    }
                    ?> 
                  </select>
                  <select id="order_sel_con" name="order_sel_con" class="selectpicker" >
                    <option value="-">-</option>
                    <?php
                    for($i=0; $i<$unums; $i++){
                      echo "<option value={$i} ";
                      if($i == $_SESSION[$pid_with_number]['order_sel_con'] && isset($_SESSION[$pid_with_number]['order_sel_con']) && $_SESSION[$pid_with_number]['order_sel_con']!="-")
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
                  <select id="order_sel_eng_order" name="order_sel_eng_order" class="selectpicker">
                    <option value="-">-</option>
                    <?php
                    for($i=1; $i<4; $i++){
                      echo "<option value='{$i}' ";
                      if($i == $_SESSION[$pid_with_number]['order_sel_eng_order'] && isset($_SESSION[$pid_with_number]['order_sel_eng_order']) && $_SESSION[$pid_with_number]['order_sel_eng_order']!="-")
                        echo "selected ";
                      echo ">{$i}</option>";
                    }
                    ?> 
                  </select>
                  <select id="order_sel_eng" name="order_sel_eng" class="selectpicker" >
                    <option value="-">-</option>
                    <?php
                    for($i=0; $i<$unums; $i++){
                      echo "<option value={$i} ";
                      if($i == $_SESSION[$pid_with_number]['order_sel_eng'] && isset($_SESSION[$pid_with_number]['order_sel_eng']) && $_SESSION[$pid_with_number]['order_sel_eng']!="-")
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
                  <select id="order_sel_own_order" name="order_sel_own_order" class="selectpicker">
                    <option value="-">-</option>
                    <?php
                    for($i=1; $i<4; $i++){
                      echo "<option value='{$i}' ";
                      if($i == $_SESSION[$pid_with_number]['order_sel_own_order'] && isset($_SESSION[$pid_with_number]['order_sel_own_order']) && $_SESSION[$pid_with_number]['order_sel_own_order']!="-")
                        echo "selected ";
                      echo ">{$i}</option>";
                    }
                    ?> 
                  </select>
                  <select id="order_sel_own" name="order_sel_own" class="selectpicker">
                    <option value="-">-</option>
                    <?php
                    for($i=0; $i<$unums; $i++){
                      echo "<option value={$i} ";
                      if($i == $_SESSION[$pid_with_number]['order_sel_own'] && isset($_SESSION[$pid_with_number]['order_sel_own']) && $_SESSION[$pid_with_number]['order_sel_own']!="-")
                        echo "selected ";
                      echo ">{$users[$i]['account_firstname']} {$users[$i]['account_lastname']}</option>";
                    }
                    ?>                  
                  </select>
                </div>
                </div>
              </div>
          </div>
        </div>      
        <br>
        <br>
        <hr>

        <div class="row">
             
              <div class="col-md-12">
                <div class="form-group col-md-8">
                    <label>Description of Change</label>
                    <textarea rows="5" name='descriptionofchange' class='form-control' value=""><?php echo $_SESSION[$pid_with_number]['descriptionofchange']; ?></textarea>
                </div>  
                <div class="form-group col-md-2">
                  <div class="col-md-12"><label>Decrease In</label></div>
                  <div class="col-md-12"><input  type='text' name='decreasein' class='form-control numeric' value="<?php echo $_SESSION[$pid_with_number]['decreasein']; ?>"></div>
                </div>
                <div class="form-group col-md-2">
                  <div class="col-md-12"><label>Increase In</label></div>
                  <div class="col-md-12"><input  type='text' name='increasein' class='form-control numeric' value="<?php echo $_SESSION[$pid_with_number]['increasein']; ?>"></div>
                </div>
              </div>
            
        </div>

        <hr>

        <div class="row">
      
              <div class="col-md-6">
                <h4>CONTRACT TIME*</h4>
                <div class="col-md-4"></div>
                <div class="col-md-4"><h5>Days</h5></div>
                <div class="col-md-4"><h5>Date</h5></div>
                 <div class="form-group col-md-12" style="padding-left: 0 !important">
                    <div class="col-md-4" style="padding-left: 0 !important"><label>Notice to Proceed</label></div>
                    <div class="col-md-4" ><input  type='text' name='noticetoproceeddays' class='form-control numeric' style="display:none" value="<?php echo $_SESSION[$pid_with_number]['noticetoproceeddays']; ?>"></div>
                    <div class="col-md-4">
                      <div class="input-group date" data-provide="datepicker">
                        <input id="bidsres" type="text" class="form-control" name='noticetoproceeddate' value="<?php echo $_SESSION[$pid_with_number]['noticetoproceeddate']; ?>">
                        <div class="input-group-addon">
                          <span class="glyphicon glyphicon-th"></span>
                        </div>
                      </div>
                    </div>
                </div>
                 <div class="form-group col-md-12" style="padding-left: 0 !important">
                    <div class="col-md-4" style="padding-left: 0 !important"><label>Original Contract Time</label></div>
                    <div class="col-md-4"><input  type='text' name='originalcontracttimedays' class='form-control numeric' value="<?php echo $_SESSION[$pid_with_number]['originalcontracttimedays']; ?>"></div>
                    <div class="col-md-4">
                      <div class="input-group date" data-provide="datepicker">
                        <input id="bidsres" type="text" class="form-control calculated" name='originalcontracttimedate' value="<?php echo $_SESSION[$pid_with_number]['originalcontracttimedate']; ?>">
                        <div class="input-group-addon">
                          <span class="glyphicon glyphicon-th"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group col-md-12" style="padding-left: 0 !important">
                    <div class="col-md-4" style="padding-left: 0 !important"><label>Net of Previous Change Orders</label></div>
                    <div class="col-md-4"><input  type='text' name='netofpreviouschangeordertimedays' class='form-control numeric' value="<?php echo $_SESSION[$pid_with_number]['netofpreviouschangeordertimedays']; ?>"></div>
                    <div class="col-md-4">
                      <div class="input-group date" data-provide="datepicker" style="display:none">
                        <input id="bidsres" type="text" class="form-control calculated" name='netofpreviouschangeordertimedate'  value="<?php echo $_SESSION[$pid_with_number]['netofpreviouschangeordertimedate']; ?>">
                        <div class="input-group-addon">
                          <span class="glyphicon glyphicon-th"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group col-md-12" style="padding-left: 0 !important">
                    <div class="col-md-4" style="padding-left: 0 !important"><label>Adjusted Contract Time</label></div>
                    <div class="col-md-4"><input  type='text' name='adjustedcontracttimedays' class='form-control numeric calculated' value="<?php echo $_SESSION[$pid_with_number]['adjustedcontracttimedays']; ?>"></div>
                    <div class="col-md-4">
                      <div class="input-group date" data-provide="datepicker">
                        <input id="bidsres" type="text" class="form-control calculated" name='adjustedcontracttimedate' value="<?php echo $_SESSION[$pid_with_number]['adjustedcontracttimedate']; ?>">
                        <div class="input-group-addon">
                          <span class="glyphicon glyphicon-th"></span>
                        </div>
                      </div>
                    </div>
                </div>
                 <div class="form-group col-md-12" style="padding-left: 0 !important; display:none">
                    <div class="col-md-4" style="padding-left: 0 !important"><label>Present Contract Time</label></div>
                    <div class="col-md-4"><input  type='text' name='presentcontracttimedays' class='form-control numeric' value="<?php echo $_SESSION[$pid_with_number]['presentcontracttimedays']; ?>"></div>
                    <div class="col-md-4">
                      <div class="input-group date" data-provide="datepicker">
                        <input id="bidsres" type="text" class="form-control" name='presentcontracttimedate' value="<?php echo $_SESSION[$pid_with_number]['presentcontracttimedate']; ?>">
                        <div class="input-group-addon">
                          <span class="glyphicon glyphicon-th"></span>
                        </div>
                      </div>
                    </div>
                </div>
                 <div class="form-group col-md-12" style="padding-left: 0 !important; display:none">
                    <div class="col-md-4" style="padding-left: 0 !important"><label>This Charge-Add-Deduct</label></div>
                    <div class="col-md-4"><input  type='text' name='thischargeadddeductdays' class='form-control numeric' value="<?php echo $_SESSION[$pid_with_number]['thischargeadddeductdays']; ?>"></div>
                    <div class="col-md-4">
                      <div class="input-group date" data-provide="datepicker">
                        <input id="bidsres" type="text" class="form-control" name='thischargeadddeductdate' value="<?php echo $_SESSION[$pid_with_number]['thischargeadddeductdate']; ?>">
                        <div class="input-group-addon">
                          <span class="glyphicon glyphicon-th"></span>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="form-group col-md-12" style="padding-left: 0 !important">
                    <div class="col-md-4" style="padding-left: 0 !important"><label>Add</label></div>
                    <div class="col-md-4"><input  type='text' name='addtimedays' class='form-control numeric' value="<?php echo $_SESSION[$pid_with_number]['addtimedays']; ?>"></div>
                    <div class="col-md-4">
                      <div class="input-group date" data-provide="datepicker" style="display:none">
                        <input id="bidsres" type="text" class="form-control" name='addtimedate' value="<?php echo $_SESSION[$pid_with_number]['addtimedate']; ?>">
                        <div class="input-group-addon">
                          <span class="glyphicon glyphicon-th"></span>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="form-group col-md-12" style="padding-left: 0 !important">
                    <div class="col-md-4" style="padding-left: 0 !important"><label>Deduct</label></div>
                    <div class="col-md-4"><input  type='text' name='deducttimedays' class='form-control numeric' value="<?php echo $_SESSION[$pid_with_number]['deducttimedays']; ?>"></div>
                    <div class="col-md-4">
                      <div class="input-group date" data-provide="datepicker" style="display:none">
                        <input id="bidsres" type="text" class="form-control" name='deducttimedate' value="<?php echo $_SESSION[$pid_with_number]['deducttimedate']; ?>">
                        <div class="input-group-addon">
                          <span class="glyphicon glyphicon-th"></span>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="form-group col-md-12" style="padding-left: 0 !important">
                    <div class="col-md-4" style="padding-left: 0 !important"><label>Change Order Subtotal</label></div>
                    <div class="col-md-4"><input  type='text' name='changeordersubtotaldays' class='form-control numeric calculated' value="<?php echo $_SESSION[$pid_with_number]['changeordersubtotaldays']; ?>"></div>
                    <div class="col-md-4">
                      <div class="input-group date" data-provide="datepicker" style="display:none">
                        <input id="bidsres" type="text" class="form-control" name='changeordersubtotaldate' value="<?php echo $_SESSION[$pid_with_number]['changeordersubtotaldate']; ?>">
                        <div class="input-group-addon">
                          <span class="glyphicon glyphicon-th"></span>
                        </div>
                      </div>
                    </div>
                </div>
                 <div class="form-group col-md-12" style="padding-left: 0 !important">
                    <div class="col-md-4" style="padding-left: 0 !important"><label>New Contract Time</label></div>
                    <div class="col-md-4"><input  type='text' name='newcontracttimedays' class='form-control numeric' value="<?php echo $_SESSION[$pid_with_number]['newcontracttimedays']; ?>"></div>
                    <div class="col-md-4">
                      <div class="input-group date" data-provide="datepicker">
                        <input id="bidsres" type="text" class="form-control calculated" name='newcontracttimedate' value="<?php echo $_SESSION[$pid_with_number]['newcontracttimedate']; ?>">
                        <div class="input-group-addon">
                          <span class="glyphicon glyphicon-th"></span>
                        </div>
                      </div>
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <label>Substantial Completion Date</label>
                    <div class="input-group date" data-provide="datepicker">
                        <input id="bidsres" type="text" class="form-control" name='substantialcompletiondate' value="<?php echo $_SESSION[$pid_with_number]['substantialcompletiondate']; ?>">
                        <div class="input-group-addon">
                          <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Final Completion Date</label>
                    <div class="input-group date" data-provide="datepicker">
                        <input id="bidsres" type="text" class="form-control" name='finalcompletiondate' value="<?php echo $_SESSION[$pid_with_number]['finalcompletiondate']; ?>">
                        <div class="input-group-addon">
                          <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>

              </div>
              <div class="col-md-6">
                <h4>CONTRACT AMOUNT* ($)</h4>
                  <div class="form-group">
                    <label>Original Contract Amount ($)</label>
                    <input  type='text' name='originalcontractamount' class='form-control numeric' value="<?php echo $_SESSION[$pid_with_number]['originalcontractamount']; ?>">
                  </div>
                  <div class="form-group">
                    <label>Net of Previous Change Order ($)</label>
                    <input  type='text' name='netofpreviouschangeorder' class='form-control numeric' value="<?php echo $_SESSION[$pid_with_number]['netofpreviouschangeorder']; ?>">
                  </div>
                  <div class="form-group">
                    <label>Adjusted Contract Amount ($)</label>
                    <input  type='text' name='adjustedcontractamount' class='form-control numeric calculated' value="<?php echo $_SESSION[$pid_with_number]['adjustedcontractamount']; ?>">
                  </div>
                  <div class="form-group">
                    <label>Add ($)</label>
                    <input  type='text' name='add' class='form-control numeric' value="<?php echo $_SESSION[$pid_with_number]['add']; ?>">
                  </div>
                  <div class="form-group">
                    <label>Deduct ($)</label>
                    <input  type='text' name='deduct' class='form-control numeric' value="<?php echo $_SESSION[$pid_with_number]['deduct']; ?>">
                  </div>
                  <div class="form-group">
                    <label>Change Order Subtotal ($)</label>
                    <input  type='text' name='changeordersubtotal' class='form-control numeric calculated' value="<?php echo $_SESSION[$pid_with_number]['changeordersubtotal']; ?>">
                  </div>
                  <div class="form-group" style="display:none">
                    <label>Original Contract Sum ($)</label>
                    <input  type='text' name='originalcontractsum' class='form-control numeric' value="<?php echo $_SESSION[$pid_with_number]['originalcontractsum']; ?>">
                  </div>
                  <div class="form-group" style="display:none">
                    <label>Present Contract Sum ($)</label>
                    <input  type='text' name='presentcontractsum' class='form-control numeric' value="<?php echo $_SESSION[$pid_with_number]['presentcontractsum']; ?>">
                  </div>
                  <div class="form-group" style="display:none">
                    <label>New Contract Sum ($)</label>
                    <input  type='text' name='newcontractsum' class='form-control numeric calculated' value="<?php echo $_SESSION[$pid_with_number]['newcontractsum']; ?>">
                  </div>
                  <div class="form-group">
                    <label>New Contract Amount, Including this Change Order ($)</label>
                    <input  type='text' name='newcontractamountincludingthischangeorder' class='form-control numeric calculated' value="<?php echo $_SESSION[$pid_with_number]['newcontractamountincludingthischangeorder']; ?>">
                  </div>
                  <br>
                  <div class="col-md-6" style="padding-left: 0 !important">
                    <div class="form-group">
                      <label>*Contract Change Order</label>
                      <input  type='text' name='reflectcontractorder' class='form-control' value="<?php echo $_SESSION[$pid_with_number]['reflectcontractorder']; ?>">
                    </div>
                  </div>
                  <div class="col-md-6" style="padding-right: 0 !important">
                    <div class="form-group">
                      <label>Thru</label>
                      <input  type='text' name='thru' class='form-control' value="<?php echo $_SESSION[$pid_with_number]['thru']; ?>">
                    </div>
                  </div>
              </div>
           
        </div>

       

        <div class="row" style="display:none">
           
              <div class="col-md-12">This Change Order is an amendment to the Contract Agreement between Contractor and the Owner, and all contract provisions shall apply unless specifically exempted.  The amount and time change designated are the maximum agreed to by both the Owner and the Contractor for this change.  In consideration of the foregoing adjustments in contract time and contract amount, the Contractor hereby releases Owner from all claims, demands or causes of action arising out of the transactions, events and occurrences giving rise to this Change Order.  This written Change Order is the entire agreement between Owner and Contractor with respect to this Change Order.  No other agreements or modifications shall apply to this Contract amendment unless expressly provided herein.  This Change Order represents final action relating to this Change Order.
              </div>
        
        </div>
        <hr>
        <div class="row" style="display:none">
           
              <div class="col-md-12">
                AGREED
              </div>
              <br>
              <br>
              <div class="form-group col-md-4">
                    <input  type='text' name='engineerinfo' class='form-control' value="<?php echo $_SESSION['engineerinfo']; ?>">
              </div>
              <div class="form-group col-md-4">
                    <input  type='text' name='contractorinfo' class='form-control' value="<?php echo $_SESSION['contractorinfo']; ?>">
              </div>
              <div class="form-group col-md-4">
                    <input  type='text' name='ownerinfo' class='form-control' value="<?php echo $_SESSION['ownerinfo']; ?>">
              </div>
              <br>
              <br>
              <div class="form-group col-md-4">
                    <label>Signature(Engineer)</label>
                    <input  type='text' name='engineersign' class='form-control' value="<?php echo $_SESSION['engineersign']; ?>">
              </div>
              <div class="form-group col-md-4">
                    <label>Signature(Contractor)</label>
                    <input  type='text' name='contractorsign' class='form-control' value="<?php echo $_SESSION['contractorsign']; ?>">
              </div>
              <div class="form-group col-md-4">
                    <label>Signature(Owner)</label>
                    <input  type='text' name='ownersign' class='form-control' value="<?php echo $_SESSION['ownersign']; ?>">
              </div>
              <br>
              <br>
              <br>
              <br>
              <div class="form-group col-md-4">
                   <div class="input-group date" data-provide="datepicker">
                        <input id="bidsres" type="text" class="form-control" name='engineersigndate' value="<?php echo $_SESSION['finalcengineersigndateompletiondate']; ?>">
                        <div class="input-group-addon">
                          <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
              </div>
              <div class="form-group col-md-4">
                    
                    <div class="input-group date" data-provide="datepicker">
                        <input id="bidsres" type="text" class="form-control" name='contractorsigndate' value="<?php echo $_SESSION['contractorsigndate']; ?>">
                        <div class="input-group-addon">
                          <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
              </div>
              <div class="form-group col-md-4">
                    
                    <div class="input-group date" data-provide="datepicker">
                        <input id="bidsres" type="text" class="form-control" name='ownersigndate' value="<?php echo $_SESSION['ownersigndate']; ?>">
                        <div class="input-group-addon">
                          <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
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
 
                      $docsquery = "SELECT * FROM documents WHERE projectid={$_SESSION['pid']} and folderid=2 and doctype in (0,1) and document_deleted = 0 order by cdate DESC";
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
<?php include("contractchangeorderhidden.php");?>

<script> document.getElementById("contractchange").className = "active"; </script>
<script>
  $(document).ready(function(){
    if ($('#signerOrderCheck').prop('checked')) {
                        //$('.selgroup .bootstrap-select:first-child').css("display", null);
      $('#order_sel_con_order').selectpicker("show");
      $('#order_sel_eng_order').selectpicker("show");
      $('#order_sel_own_order').selectpicker("show");
    }
    else {
      $('#order_sel_con_order').selectpicker("hide");
      $('#order_sel_eng_order').selectpicker("hide");
      $('#order_sel_own_order').selectpicker("hide");
    }
    $(".numeric").numericInput({ allowFloat: true });
    
    $('.date').datepicker({
      orientation: 'bottom'
    });
 
  
    checkpending();

   
    $('[name="changeordernumber"]').change(function(){
      contractchangeordercalcs();
    });

    $('[name="descriptionofchange"]').change(function(){
      contractstatuscalcs();
    });

    $('[name="decreasein"]').change(function(){
      contractchangeordercalcs();
    });

    $('[name="increasein"]').change(function(){
      contractchangeordercalcs();
    });   

    $('[name="noticetoproceeddays"]').keyup(function(){
      contractchangeordercalcs();
    });

    $('[name="noticetoproceeddate"]').change(function(){
      contractchangeordercalcs();
    });

    $('[name="originalcontracttimedays"]').keyup(function(){
      contractchangeordercalcs();
    });

    $('[name="originalcontracttimedate"]').change(function(){
      contractchangeordercalcs();
    });

    $('[name="netofpreviouschangeordertimedays"]').keyup(function(){
      contractchangeordercalcs();
    });

    $('[name="netofpreviouschangeordertimedate"]').change(function(){
      contractchangeordercalcs();
    });

    $('[name="adjustedcontracttimedays"]').keyup(function(){
      contractchangeordercalcs();
    });

    $('[name="adjustedcontracttimedate"]').change(function(){
      contractchangeordercalcs();
    });
    $('[name="addtimedays"]').keyup(function(){
      contractchangeordercalcs();
    });

    $('[name="addtimedate"]').change(function(){
      contractchangeordercalcs();
    });
    $('[name="deducttimedays"]').keyup(function(){
      contractchangeordercalcs();
    });

    $('[name="deducttimedate"]').change(function(){
      contractchangeordercalcs();
    });
    $('[name="changeordersubtotaldays"]').keyup(function(){
      contractchangeordercalcs();
    });

    $('[name="changeordersubtotaldate"]').change(function(){
      contractchangeordercalcs();
    });

    $('[name="presentcontracttimedays"]').keyup(function(){
      contractchangeordercalcs();
    });

    $('[name="presentcontracttimedate"]').change(function(){
      contractchangeordercalcs();
    });

    $('[name="thischargeadddeductdays"]').keyup(function(){
      contractchangeordercalcs();
    });

    $('[name="thischargeadddeductdate"]').change(function(){
      contractchangeordercalcs();
    });

    $('[name="newcontracttimedays"]').keyup(function(){
      contractchangeordercalcs();
    });

    $('[name="newcontracttimedate"]').change(function(){
      contractchangeordercalcs();
    });

    $('[name="substantialcompletiondate"]').change(function(){
      contractchangeordercalcs();
    });

    $('[name="finalcompletiondate"]').change(function(){
      contractchangeordercalcs();
    });

    $('[name="changeordersubtotal"]').keyup(function(){
      contractchangeordercalcs();
    });

    $('[name="originalcontractamount"]').keyup(function(){
      contractchangeordercalcs();
    });
    $('[name="netofpreviouschangeorder"]').keyup(function(){
      contractchangeordercalcs();
    });
    $('[name="adjustedcontractamount"]').keyup(function(){
      contractchangeordercalcs();
    });
    $('[name="newcontractamountincludingthischangeorder"]').keyup(function(){
      contractchangeordercalcs();
    });
    

    $('[name="add"]').keyup(function(){
      contractchangeordercalcs();
    });

    $('[name="deduct"]').keyup(function(){
      contractchangeordercalcs();
    });

    $('[name="net"]').keyup(function(){
      contractchangeordercalcs();
    });

    $('[name="originalcontractsum"]').keyup(function(){
      contractchangeordercalcs();
    });

    $('[name="presentcontractsum"]').keyup(function(){
      contractchangeordercalcs();
    });

    $('[name="newcontractsum"]').keyup(function(){
      contractchangeordercalcs();
    });

    $('[name="reflectcontractorder"]').change(function(){
      contractchangeordercalcs();
    });

});


</script>

<?php

include("include/footer.php");

?>




