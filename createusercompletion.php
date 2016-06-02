<?php
error_reporting(E_ERROR | E_PARSE);
include_once('include/access.php');
require_once 'vendor/autoload.php';
include("include/notloginheader.php");
$userid = $_GET['userid'];
// if(!isset($_SESSION['userid']))
// { 
//   header("Location:login.php");
// }

$pid = $_GET['projectid'];
// $project_session_id = $_SESSION['pid'];
// $pid = $_SESSION['pid'];
//$userid = $_SESSION['userid'];
  $uquery = "Select * from groups";
  $uresult = mysqli_query($cxn, $uquery);
  $unums = mysqli_num_rows($uresult);
  $groups = array();
  for($i=0;$i<$unums; $i++){
    $row = mysqli_fetch_assoc($uresult);
    $groups[$i] = $row;
  }

$rolequery = "Select distinct role as role from users,gp_relation,gu_relation where gp_relation.projectid = $pid and gp_relation.groupid=gu_relation.groupid and gu_relation.userid=users.user_id and users.user_id = $userid";
$roleresult = mysqli_query($cxn, $rolequery);
$rolerow = mysqli_fetch_assoc($roleresult);
extract($rolerow);

  $userquery = "Select * from users where user_id = {$userid}";
  $userresult = mysqli_query($cxn, $userquery);
  $userrow = mysqli_fetch_assoc($userresult);
  if($userrow != null)
  extract($userrow);

  if ($user_id)

  $accountquery = "Select * from accounts where account_userid = {$userid}";
  $accountresult = mysqli_query($cxn, $accountquery);
  $accountrow = mysqli_fetch_assoc($accountresult);
  if($accountrow != null)
  extract($accountrow);
?>

<div class="container-fluid">
  <div class="col-sm-9  col-md-10 paddingtop10">
    
    <div class="row-fluid">
      <h3>Complete User Info</h3>
    </div>
    
          <div class="row">
        

          
            <div class="col-sm-12">
              <form method='post' action='createusercompletionaction.php'> 
                  <input name="pid" style="display: none" value="<?php echo $pid; ?>">
                  <input name="userid" style="display: none" value="<?php echo $userid; ?>">
                  <div class='form-group'>
                    <label>First Name*</label>
                    <input  type='text' name='firstname' class='form-control' required value='<?php echo $account_firstname; ?>'> 
                  </div>  
                  
                  <div class='form-group'>
                    <label>Last Name*</label>
                    <input  type='text' name='lastname' class='form-control' required value='<?php echo $account_lastname; ?>'> 
                  </div>  
                  
          <label style="margin-top: 10px !important;">Organization*</label><br>
          <select class='selectpicker' name='usergroup' disabled="disabled">
            <?php
              for($i=0; $i<$unums; $i++){
                echo "<option value={$groups[$i]['name']} ";
                if($groups[$i]['name'] == $account_organization){
                  echo 'selected';
                }
                echo ">{$groups[$i]['name']}</option>";
              }
            ?>     
          </select>
          <br>
          <br>
          <?php $roles = array("", "Administrator", "Collaborate", "Limited");
              $thisrole = $roles[$role];
          ?>
          <label >Role*</label><br>
          <select class='selectpicker' name='userrole' disabled="disabled">
            <option value="Administrator" <?php if($thisrole == 'Administrator') echo 'selected' ?>>Administrator</option>
            <option value="Collaborate" <?php if($thisrole == 'Collaborate') echo 'selected' ?>>Collaborate</option>
            <option value="Limited" <?php if($thisrole == 'Limited') echo 'selected' ?>>Limited</option>
          </select>
          <br><br>
          <label>Title*</label>
          <input type='text' name='title' class='form-control'>
          <br>
          <label>Phone(Office)*</label>
          <input type='text' name='phoneoffice' class='form-control'>
          <br>
          <label>Phone(Mobile)*</label>
          <input type='text' name='phonemobile' class='form-control'>
          <br>
          <label>Fax*</label>
          <input type='text' name='fax' class='form-control'>
          <br>
          <label>Address*</label>
          <input type='text' name='address' class='form-control'>
          <br>
          <label>Zip*</label>
          <input type='text' name='zip' class='form-control'>
          <br>
          <label>Email Address*</label>
          <input type='email' name='emailaddress' class='form-control' value='<?php echo $user_email; ?>' required readonly>
          <br>
          <label>Password*</label>
          <input type='password' name='password' class='form-control' required>
          <br>
          <label>Password Confirm*</label>
          <input type='password' name='passwordconfirm' class='form-control' required>
          <br>
          <div class='form-group'>
            <div>
              <a href='index.php' class='btn btn-default btn-large'>cancel</a>
              <button id='startbutton' type='submit' class='btn btn-primary btn-large pull-right'>Complete User Info</button>
            </div>
          </div>
          </form>
          
          </div>
          
        </div>
  

  </div>
</div>

<script>
  $(".placepicker").placepicker();
</script>
<script>
  $(document).ready(function(){


    $('[name="passwordconfirm"]').blur(function(){
      if(document.getElementsByName("password")[0].value != document.getElementsByName("passwordconfirm")[0].value) {
        document.getElementsByName("password")[0].value = '';
        document.getElementsByName("passwordconfirm")[0].value = '';
      }
    });

    

});
</script>

<?php

include("include/footer.php");

?>




