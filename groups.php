<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
require_once 'vendor/autoload.php';
require_once 'PHPMailer/PHPMailerAutoload.php';
include("include/header.php");

 if(!isset($_SESSION['userid']))
{ 
//	header("Location:login.php");
}

//include("include/userheader.php");

?>

<?php include("include/projectsidebar.php"); ?>

      
<div class="col-sm-10 col-sm-offset-2 col-md-10 col-md-offset-2 ">
  <?php  include("include/alerts.php"); ?>  
  <?php  include("include/popup.php"); ?> 
  <?php 

    $pid = $_SESSION['pid'];
    $userid = $_SESSION['userid'];
    $rolequery = "Select distinct role as role from users,gp_relation,gu_relation where gp_relation.projectid = {$_SESSION['pid']} and gp_relation.groupid=gu_relation.groupid and gu_relation.userid=users.user_id and users.user_id = $userid";
    $roleresult = mysqli_query($cxn, $rolequery);
    $rolerow = mysqli_fetch_assoc($roleresult);
    extract($rolerow);

    $userquery = "Select * from users where user_id = {$userid}";
    $userresult = mysqli_query($cxn, $userquery);
    $userrow = mysqli_fetch_assoc($userresult);
    if($userrow != null)
    extract($userrow);
    $userlevel = $role;
  ?>
  <div class="row paddingtop10 borderbottom paddingright10">            
   <span class='indexpage_header'>Users and Groups</span>
   <span class='btn btn-info pull-right <?php if($userlevel > 1) echo 'unclickable'; ?>' data-toggle="modal" data-target="#newGroup" style="<?php if($userlevel > 1) echo 'pointer-events: none'; ?>" <?php if($userlevel > 1) echo 'onclick="return false;" disabled'; ?>>New Group</span>
   <span class='btn btn-info pull-right <?php if($userlevel > 1) echo 'unclickable'; ?>' data-toggle="modal" data-target="#newUser" style="margin-right: 10px !important; <?php if($userlevel > 1) echo 'pointer-events: none'; ?>" <?php if($userlevel > 1) echo 'onclick="return false;" disabled'; ?>>New User</span>
   <!--span class='btn btn-info pull-right <?php if($userlevel > 1) echo 'unclickable'; ?>' data-toggle="modal" data-target="#addUser" style="margin-right: 10px !important; <?php if($userlevel > 1) echo 'pointer-events: none'; ?>" <?php if($userlevel > 1) echo 'onclick="return false;" disabled'; ?>>Add User</span-->
  </div>
  
  <?php

  
  $query = "select * from groups join gp_relation on gp_relation.groupid = groups.id where gp_relation.projectid={$_SESSION['pid']}";
  $groupsresult = mysqli_query($cxn,$query);
  $groupsrows = mysqli_num_rows($groupsresult);
  if($groupsrows == 0){
    echo "<div> <h4>No Groups</h4></div>";
  }
  $groups = array();
  $usernum = -1;
  $users = array();
  for($i=0; $i<$groupsrows; $i++)
  {
    $groupsrow=mysqli_fetch_assoc($groupsresult);
    $groups[$i] = $groupsrow;
    if($groupsrow != null)
    extract($groupsrow);
  ?>
  
  <div class="row groups">
      
      <div>      
      <h4  onclick="toggle('<?php echo "group_".$groupid;?>');" style='cursor:pointer; display:inline'>
        <?php echo $name; ?>  
      </h4><span class='glyphicon glyphicon-cog arrow' data-toggle='modal' data-target='#editGroup' onclick='setGroupDetails(<?php echo $i ?>)' aria-hidden='true' style="<?php if($userlevel > 1) echo 'pointer-events: none'; ?>"></span>
      
      <div id='<?php echo "group_".$groupid;?>' style="display:none;" class="margintop20">
        <?php
        $user_query = "Select * from users,accounts,gu_relation where gu_relation.groupid=$groupid and users.user_id=gu_relation.userid and accounts.account_userid=gu_relation.userid";
        $user_res = mysqli_query($cxn, $user_query);
        $num_row = mysqli_num_rows($user_res);
        while ($userrow = mysqli_fetch_assoc($user_res)) {
        $usernum++;
        $users[$usernum] = $userrow;
        extract($userrow);
        ?>
        <div class="grouplistuser">
          <p><b><?php echo $account_firstname."&nbsp;".$account_lastname; ?></b><span class='btn btn-info pull-right <?php if($userlevel > 1) echo 'unclickable'; ?>' style="<?php if($userlevel > 1) echo 'pointer-events: none'; ?>" data-toggle="modal" data-target="#editUser" data-user-id="<?php echo $user_id; ?>" <?php if($userlevel > 1) echo 'disabled'; ?> onclick='setUserDetails(<?php echo $usernum; ?>)' >Edit User</span></p>

          <p><i><?php echo $account_organization; ?></i></p>
          <p><?php echo $user_email; ?></p>
          <p><?php echo $account_phone; ?></p>
        </div>
        <?php
        }
        if($num_row == 0){
        ?>
        <div class="grouplistuser">
          <p>No user</p>
        </div>
        <?php
        }
        ?>
      </div>
      
      </div>
      
      
    
    </div>
    <?php
    }
    ?> 
    <script>
      var grouplist = JSON.parse('<?php echo json_encode($groups);?>');
      console.log(grouplist);
      var grouplistuser = JSON.parse('<?php echo json_encode($users); ?>');
    </script>
    <!--
          <div class="groups row">
      
      <div>      
      <h4>
        Group B <span class="glyphicon glyphicon-menu-down arrow" aria-hidden="true" onclick="toggle('groupausersb');"></span><a class='editgroup' href='editgroup.php'>edit group</a> 
      </h4>
      
      <div id='groupausersb' style="display:none;" class="margintop20">
        <div class="grouplistuser">
          <p><b>John Smith</b><a class='pull-right edituser' href='edituser.php'>edit user</a></p>
          <p><i>Contractor</i></p>
          <p>john.smith@contractor.com</p>
          <p>(917)555-5555</p>
        </div>
        <div class="grouplistuser">
          <p><b>John Smith</b><a class='pull-right edituser' href='edituser.php'>edit user</a></p>
          <p><i>Contractor</i></p>
          <p>john.smith@contractor.com</p>
          <p>(917)555-5555</p>
        </div>
        <div class="grouplistuser">
          <p><b>John Smith</b><a class='pull-right edituser' href='edituser.php'>edit user</a></p>
          <p><i>Contractor</i></p>
          <p>john.smith@contractor.com</p>
          <p>(917)555-5555</p>
        </div>
      </div>
      
      </div>
      
      
    
    </div>
    -->
  </div>
  
  
  
</div>


  
  
</div>

<script> document.getElementById("groups").className = "active"; </script>
<?php

include("groupsmodal.php");

?>

<?php

include("include/footer.php");

?>




