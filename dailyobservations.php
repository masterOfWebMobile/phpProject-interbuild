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
   <span class='indexpage_header'>Daily Observations</span>
  </div>
  
<div id="content ">
    <ul id="tabs" class="nav nav-tabs paddingtop10" data-tabs="tabs">
        <li class="active"><a href="#current" data-toggle="tab">Current</a></li>
        <li><a href="#past" data-toggle="tab">Past</a></li>
    </ul>
    <div id="my-tab-content" class="tab-content">
         
        <div class="tab-pane active paddingtop10" id="current">
          <div class="row paddingright10 pull-right">
              <button class='btn btn-default btn-large' <?php if($role == 3) echo 'disabled' ?> onclick="savedailyobservations();">Save Draft</button>
              <button class='btn btn-success btn-warning' <?php if($role == 3) echo 'disabled' ?> onclick="printdailyobservations(3, '<?php echo $project_name; ?>')">Save as PDF</button>
              <button class='btn btn-info' <?php if($role == 3) echo 'disabled' ?> onclick="senddailyobservationsforsig(3, '<?php echo $project_name; ?>','<?php echo $_SESSION['useremail']; ?>');">Send For Signatures</button>

            </div>
            <br>
             <br>
             <form method='post' action='dailyobservationssave.php' id='dailyobservationsform'> 
            <div class="row">
                <div class="col-md-12"><h4>Document Detail</h4></div>
                <div class="col-md-12" >
                <div class="col-md-4">
                  <h5>Signer</h5>
                  <select id="daily_sel_con" class="selectpicker">
                    <option value="-">-</option>
                    <?php
                    for($i=0; $i<$unums; $i++){
                      echo "<option value={$i} ";
                      if($i == $_SESSION[$pid_with_number]['daily_sel_con'] && isset($_SESSION[$pid_with_number]['daily_sel_con']) && $_SESSION[$pid_with_number]['daily_sel_con']!="-")
                        echo "selected ";
                      echo ">{$users[$i]['account_firstname']} {$users[$i]['account_lastname']}</option>";
                    }
                    ?>                  
                  </select>
                </div>
                <div class="col-md-4" style="display:none">
                  <h5>Engineer</h5>
                  <select id="daily_sel_eng" id="daily_sel_owner" class="selectpicker">
                    <option value="-">-</option>
                    <?php
                    for($i=0; $i<$unums; $i++){
                      echo "<option value={$i}>{$users[$i]['account_firstname']} {$users[$i]['account_lastname']}</option>";
                    }
                    ?>                   
                  </select>                  
                </div>
                <div class="col-md-4" style="display:none">
                  <h5>Owner</h5>
                  <select id="daily_sel_own" class="selectpicker">
                    <option value="-">-</option>
                    <?php
                    for($i=0; $i<$unums; $i++){
                      echo "<option value={$i}>{$users[$i]['account_firstname']} {$users[$i]['account_lastname']}</option>";
                    }
                    ?>                   
                  </select>
                </div>
                </div>
                <br>
                <br>
                <br>
                <div class="col-md-12" style="display:none">
                  <div class="form-group width20"><input type="checkbox" name="vehicle" value="Bike">730 NE Waldo Rd. Blog. A<br>Gainesville, FL 32641<br>(352) 376-5533</div>
                  <div class="form-group width20"><input type="checkbox" name="vehicle" value="Bike">1000 Cesery Blvd.<br>Jacksonville, FL 32211<br>(903) 743-2847</div>
                  <div class="form-group width20"><input type="checkbox" name="vehicle" value="Bike"> I have a bike</div>
                  <div class="form-group width20"><input type="checkbox" name="vehicle" value="Bike"> I have a bike</div>
                  <div class="form-group width20"><input type="checkbox" name="vehicle" value="Bike"> I have a bike</div>
                </div>
            </div>  
            <br>
            <div class="row">
              <div class="col-md-12">
              <div class="form-group col-md-3">
                <label>Weather</label>
                <input  type='text' name='weather' class='form-control' value="<?php echo $_SESSION[$pid_with_number]['weather']; ?>"> 
              </div>
               <div class="form-group col-md-3">
                  <label>Temperature</label>
                  <input  type='text' name='temperature' class='form-control' value="<?php echo $_SESSION[$pid_with_number]['temperature']; ?>">
              </div>
              <div class="form-group col-md-3">
                  <label>Time</label>
                  <div class="input-group">
                    <input  type='text' name='time' class='form-control' value="<?php echo $_SESSION[$pid_with_number]['time']; ?>">
                    <div class="input-group-addon"> 
                      <select name="temperaturetime" value="<?php echo $_SESSION[$pid_with_number]['temperaturetime']; ?>"><option>AM</option><option>PM</option></select>
                    </div>
                  </div>
              </div>
              <div class="form-group col-md-3">
                <label>Rain Gauge Reading</label>
                <input  type='text' name='raingaugereading' class='form-control' value="<?php echo $_SESSION[$pid_with_number]['raingaugereading']; ?>"> 
              </div>
            </div>
            </div>
            <div class="row">
              <div class="col-md-12">
              <div class="form-group col-md-8">
                <label>Project Name</label>
                <input  type='text' name='projectname' class='form-control calculated' value="<?php echo $project_name;?> ">
              </div>
              <div class="form-group col-md-4">
                <label>Project No.</label>
                <input  type='text' name='projectno' class='form-control calculated' value="<?php echo $project_number;?>">
              </div>
            </div>
            </div>
            <div class="row">
              <div class="col-md-12">
              <div class="form-group col-md-4">
                <label>Date</label>
                <div class="input-group date" data-provide="datepicker">
                    <input id="bidsres" type="text" class="form-control" name='date' value="<?php echo $_SESSION[$pid_with_number]['date']; ?>">
                    <div class="input-group-addon">
                      <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
              </div>
              <div class="form-group col-md-4">
                <label>Contract Day</label>
                <input  type='text' name='contractday' class='form-control' value="<?php echo $_SESSION[$pid_with_number]['contractday']; ?>"> 
              </div>
              <div class="form-group col-md-4">
                <label>Hours on Site</label>
                <input  type='text' name='hoursonsite' class='form-control' value="<?php echo $_SESSION[$pid_with_number]['hoursonsite']; ?>"> 
              </div>
            </div>
            </div>
            <div class="row">
              <div class="col-md-12 onelinecomponent">
              <div class="form-group">
                <label class="col-md-12" style="padding-left: 0 !important">Contractor</label>
                <input  type='text' name='contractor' class='form-control' value="<?php echo $_SESSION[$pid_with_number]['contractor']; ?>"> 
              </div>
            </div>
            </div>
            <div class="row">
              <div class="col-md-12">
              <div class="form-group col-md-6">
                <label>Work Force</label>
                <input  type='text' name='workforce' class='form-control' value="<?php echo $_SESSION[$pid_with_number]['workforce']; ?>"> 
              </div>
              <div class="form-group col-md-6">
                <label>Equipment</label>
                <input  type='text' name='equipment' class='form-control' value="<?php echo $_SESSION[$pid_with_number]['equipment']; ?>"> 
              </div>
            </div>
            </div>
            <div class="row">
              <div class="col-md-12 onelinecomponent">
                <div class="form-group">
                    <label>Work Activities</label>
                    <textarea rows="20" name='workactivities' class='form-control' value=""><?php echo $_SESSION[$pid_with_number]['workactivities']; ?></textarea>
                </div>  
              </div>
            </div>

            <div class="row">
              <div class="col-md-12 onelinecomponent">
                <div class="form-group">
                    <label>Tests Performed</label>
                    <textarea rows="2" name='testsperformed' class='form-control' value=""><?php echo $_SESSION[$pid_with_number]['testsperformed']; ?></textarea>
                </div>  
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 onelinecomponent">
                <div class="form-group">
                    <label>Materials Delivered</label>
                    <textarea rows="2" name='materialsdelivered' class='form-control' value=""><?php echo $_SESSION[$pid_with_number]['materialsdelivered']; ?></textarea>
                </div>  
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 onelinecomponent">
                <div class="form-group">
                    <label>Visitors</label>
                    <textarea rows="2" name='visitors' class='form-control' value=""><?php echo $_SESSION[$pid_with_number]['visitors']; ?></textarea>
                </div> 
              </div> 
            </div>

            <div class="row">
              <div class="col-md-12 onelinecomponent">
                <div class="form-group">
                    <label>Defective Work To Be Corrected</label>
                    <textarea rows="2" name='defectiveworktobecorrected' class='form-control' value=""><?php echo $_SESSION[$pid_with_number]['defectiveworktobecorrected']; ?></textarea>
                </div>  
              </div>
            </div>
            <div class="row" style="display:none">
              <div class="col-md-12">
              <div class="form-group col-md-3">
                <label>Book No.</label>
                <input  type='text' name='bookno' class='form-control' value="<?php echo $_SESSION[$pid_with_number]['bookno']; ?>"> 
              </div>
              <div class="form-group col-md-3">
                <label>Page No.</label>
                <input  type='text' name='pageno' class='form-control' value="<?php echo $_SESSION[$pid_with_number]['pageno']; ?>"> 
              </div>
              <div class="form-group col-md-6">
                <label>Signed</label>
                <input  type='text' name='signed' class='form-control' value="<?php echo $_SESSION[$pid_with_number]['signed']; ?>"> 
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
 
  $docsquery = "SELECT * FROM documents WHERE projectid={$_SESSION['pid']} and folderid=3 and doctype in (0,1) and document_deleted = 0 order by cdate DESC";
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
    echo"              <button class='btn btn-danger'>Delete</button>";*/
    echo"            </div>";                
    echo"          </div>";
    //echo" </div>";
    
}
?>
                     
    </div>
</div>

</div>
   
</div>
<script type="text/javascript"> projectid = <?php echo $projectid;?></script>
<?php include("dailyobservationshidden.php");?>

<script> document.getElementById("dailyobserv").className = "active"; </script>
<script>
  $(document).ready(function(){
    checkpending();
    $(".numeric").numericInput({ allowFloat: true });
    
    $('.date').datepicker({
      orientation: 'bottom'
    });


    $('[name="weather"]').change(function(){
      contractstatuscalcs();
    });

    $('[name="temperature"]').keyup(function(){
      dailyobservationscalcs();
    });

    $('[name="temperaturetime"]').change(function(){
      dailyobservationscalcs();
    });

    $('[name="raingaugereading"]').change(function(){
      dailyobservationscalcs();
    });   

    $('[name="date"]').keyup(function(){
      dailyobservationscalcs();
    });  

    $('[name="contractday"]').keyup(function(){
      dailyobservationscalcs();
    });

    $('[name="hoursonsite"]').keyup(function(){
      dailyobservationscalcs();
    });

    $('[name="workforce"]').keyup(function(){
      dailyobservationscalcs();
    });

    $('[name="contractor"]').keyup(function(){
      dailyobservationscalcs();
    });

    $('[name="equipment"]').keyup(function(){
      dailyobservationscalcs();
    });

    $('[name="workactivities"]').keyup(function(){
      dailyobservationscalcs();
    });

    $('[name="testsperformed"]').keyup(function(){
      dailyobservationscalcs();
    });

    $('[name="materialsdelivered"]').keyup(function(){
      dailyobservationscalcs();
    });

    $('[name="visitors"]').keyup(function(){
      dailyobservationscalcs();
    });

    $('[name="defectiveworktobecorrected"]').keyup(function(){
      dailyobservationscalcs();
    });

    
});


</script>

<?php

include("include/footer.php");

?>




