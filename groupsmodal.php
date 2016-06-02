<?php
$pid = $_GET['projectid'];
$fquery = "Select distinct folders.folder_id as folder_id, folders.folder_name as folder_name from folders where folder_projectid=0 or folder_projectid={$_SESSION['pid']}";
$fcresult = mysqli_query($cxn, $fquery);
$folders = array();
$gfarr = array();
for($i=0;$i<count($groups);$i++){
  $gfquery = "Select * from gf_relation where groupid=".$groups[$i]['groupid'];
  $gfarr[$i] = "";
  $gfresult = mysqli_query($cxn, $gfquery);
  while($gfrow = mysqli_fetch_assoc($gfresult)){
    $gfarr[$i] .= $gfrow['folderid'].",";
  }
}
?>
<script>
var gfarr = JSON.parse('<?php echo json_encode($gfarr); ?>');
</script>
<div class="modal fade" id="newGroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Create Group</h4>
      </div>
      <form method='post' action='groupcreate.php' onsubmit="return getcPicker()"> 
        <div class="modal-body">
          <label>Group Name*</label>
          <input  type='text' name='gName' class='form-control' required> 
          <br>
          <label>Type*</label><br>
          <select class='selectpicker' name='gType'>
            <option value="Owner">Owner</option>
            <option value="Contractor">Contractor</option>
            <option value="CEI">CEI</option>
            <option value="Engineer / Architect">Engineer / Architect</option>
            <option value="Funding Agency">Funding Agency</option>
            <option value="Permitting Agency">Permitting Agency</option>
            <option value="Suppliers">Suppliers</option>
            <option value="Other">Other</option>
          </select>
          <br>
          <br>
          <label>Other Type Name</label>
          <input type='text' name='otherTName' class='form-control'>
          <br>
          <label>Folder Access</label>
          <br>
          <select class='selectpicker fcpicker' name='fAccess' multiple data-selected-text-format='count>2' data-actions-box="true">
            <?php
            while($frow = mysqli_fetch_assoc($fcresult)){
              array_push($folders, $frow);
              extract($frow);
              echo "<option value='$folder_id'>$folder_name</option>";
            }
            ?>
          </select>
          <input type="hidden" id="cfolderid" name="folderid">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="editGroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Group</h4>
      </div>
      <form method='post' action='groupedit.php' onsubmit="return getePicker()"> 
        <div class="modal-body">
          <label>Group Name*</label>
          <input type='hidden'id='ed_gid' name='gid'>
          <input  type='text' id='ed_gName' name='gName' class='form-control' required> 
          <br>
          <label>Type*</label><br>
          <select class='selectpicker' name='gType' id='ed_gType'>
            <option value="Owner">Owner</option>
            <option value="Contractor">Contractor</option>
            <option value="CEI">CEI</option>
            <option value="Engineer / Architect">Engineer / Architect</option>
            <option value="Funding Agency">Funding Agency</option>
            <option value="Permitting Agency">Permitting Agency</option>
            <option value="Suppliers">Suppliers</option>
            <option value="Other">Other</option>
          </select>
          <br>
          <br>
          <label>Other Type Name</label>
          <input type='text' id="ed_otherTName" name='otherTName' class='form-control'>
          <br>
          <label>Folder Access</label>
          <br>
          <select class='selectpicker fepicker' name='fAccess' multiple data-selected-text-format='count>2' data-actions-box="true">
          <?php
            for($i=0; $i<count($folders); $i++){
              echo "<option value=\"{$folders[$i]['folder_id']}\">{$folders[$i]['folder_name']}</option>";
            }
          ?>
          </select>
          <input type="hidden" id="efolderid" name="folderid">
          <br><br>
          <button type="button" class='btn btn-danger' onclick="delGroup()">Delete Group</button>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>



<div class="modal fade" id="newUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Create User</h4>
      </div>
      <form method='post' action='usercreate.php'> 
        <div class="modal-body">
          <div style="margin-bottom: 10px !important">
            <div class="col-md-6" style="padding-left: 0 !important">
              <label>First Name*</label>
              <input  type='text' name='userfirstname' class='form-control' required> 
            </div>
            <div class="col-md-6" style="padding-right: 0 !important">
              <label>Last Name*</label>
              <input  type='text' name='userlastname' class='form-control' required> 
            </div>
          </div>
         <br>

<?php
  $uquery = "Select * from groups,gp_relation where groups.id=gp_relation.groupid and gp_relation.projectid=$pid";
  $uresult = mysqli_query($cxn, $uquery);
  $unums = mysqli_num_rows($uresult);
  $groups = array();
  for($i=0;$i<$unums; $i++){
    $row = mysqli_fetch_assoc($uresult);
    $groups[$i] = $row;
  }
?>
          <label style="margin-top: 15px !important" >User Group*</label><br>
          <select class='selectpicker' name='usergroup'>
            <?php
              for($i=0; $i<$unums; $i++){
                echo "<option value='{$groups[$i]['groupid']}' ";
                echo ">{$groups[$i]['name']}</option>";
              }
            ?>     
          </select>
          <br><br>
          <label >Role*</label><br>
          <select class='selectpicker' name='userrole'>
            <option value="Administrator">Administrator</option>
            <option value="Collaborate">Collaborate</option>
            <option value="Limited">Limited</option>
          </select>
          <br><br>
          <label>Email Address*</label>
          <input type='email' name='useremailaddress' class='form-control' required>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Create User</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit User</h4>
      </div>
      <form method='post' action='useredit.php'> 
        <div class="modal-body">

          <?php
          $project_session_id = $_SESSION['pid'];
          $getprojectrowquery="SELECT * FROM projects where project_id = $project_session_id";
          $getprojectrowresult = mysqli_query($cxn,$getprojectrowquery);
          $getprojectrow=mysqli_fetch_assoc($getprojectrowresult);
          if($getprojectrow != null)
          extract($getprojectrow);

          $pid = $_SESSION['pid'];
          $userid = $_SESSION['userid'];
          $rolequery = "Select distinct role as role from users,gp_relation,gu_relation where gp_relation.projectid = {$_SESSION['pid']} and gp_relation.groupid=gu_relation.groupid and gu_relation.userid=users.user_id and users.user_id = $userid";
          $roleresult = mysqli_query($cxn, $rolequery);
          $rolerow = mysqli_fetch_assoc($roleresult);
          extract($rolerow);

            $uquery = "Select * from groups";
            $uresult = mysqli_query($cxn, $uquery);
            $unums = mysqli_num_rows($uresult);
            $groups = array();
            for($i=0;$i<$unums; $i++){
              $row = mysqli_fetch_assoc($uresult);
              $groups[$i] = $row;
            }
            
          ?>


        

          

  
              <div class="col-md-12" style="padding-left: 0 !important; padding-right: 0 !important; ">
                  <div class='form-group col-md-6' style="padding-left: 0 !important; " >
                    <label>First Name*</label>
                    <input  id="edituserfirstname"  type='text' name='firstname' class='form-control' required readonly value='<?php // echo $account_firstname; ?>'> 
                  </div>  
                  
                  <div class='form-group col-md-6' style="padding-right: 0 !important" >
                    <label>Last Name*</label>
                    <input  id="edituserlastname" type='text' name='lastname' class='form-control' required readonly value='<?php // echo $account_lastname; ?>'> 
                  </div>  
              </div>   
          <div class='col-md-12' style="padding-left: 0 !important; padding-right: 0 !important">
          <div class='col-md-6' style="padding-left: 0 !important; padding-right: 0 !important">
            <label >Organization*</label><br>
            <select id="editusergroup" class='selectpicker' name='usergroup' disabled="disabled">
              <?php
                for($i=0; $i<$unums; $i++){
                  echo "<option value={$groups[$i]['id']} ";
                  /*if($groups[$i]['id'] == $groupid){
                    echo 'selected';
                  }*/
                  echo ">{$groups[$i]['name']}</option>";
                }
              ?>     
            </select>
          </div>

          <div class="col-md-6" style=" padding-right: 0 !important">
            <?php $roles = array("", "Administrator", "Collaborate", "Limited");
                $thisrole = $roles[$role];
            ?>
            <label >Role*</label><br>
            <select id="edituserrolepicker" class='selectpicker' name='userrole' disabled="disabled">
              <option value="Administrator" <?php //if($thisrole == 'Administrator') echo 'selected' ?>>Administrator</option>
              <option value="Collaborate" <?php //if($thisrole == 'Collaborator') echo 'selected' ?>>Collaborate</option>
              <option value="Limited" <?php //if($thisrole == 'Limited') echo 'selected' ?>>Limited</option>
            </select>
          </div>
        </div>
          
          <div class="col-md-12" style="padding-left: 0 !important; padding-right: 0 !important; margin-top: 15px !important">
            <div class="col-md-4" style="padding-left: 0 !important; ">
          <label>Title*</label>
          <input id="editusertitle" type='text' name='title' class='form-control' readonly value='<?php //echo $account_title; ?>'>
        </div>
          <div  class="col-md-4" style="padding-left: 15px !important; padding-right: 15px !important">
          <label>Phone(Office)*</label>
          <input id="edituserphone" type='text' name='phoneoffice' class='form-control' readonly value='<?php //echo //$account_phone; ?>'>
          </div>
          <div  class="col-md-4" style=" padding-right: 0 !important">
          <label>Fax*</label>
          <input id="edituserfax" type='text' name='fax' class='form-control' readonly value='<?php //echo //$account_fax; ?>'>
          </div>
        </div>
        <div  class="col-md-12" style="padding-left: 0 !important; padding-right: 0 !important; margin-top: 15px !important">
          <div class="col-md-6" style="padding-left: 0 !important; ">
          <label>Address*</label>
          <input id="edituseraddress" type='text' name='address' class='form-control' readonly value='<?php //echo //$account_location; ?>'>
          </div>
          <div class="col-md-6 " style="padding-right: 0 !important">
          <label>Zip*</label>
          <input id="edituserzip" type='text' name='zip' class='form-control' readonly value='<?php //echo //$account_zip; ?>'>
          </div>
        </div>
          <label style="margin-top: 15px !important;">Email Address*</label>
          <input id="edituseremail" type='email' name='emailaddress' class='form-control' value='<?php //echo //$user_email; ?>' required readonly>
          <br>
 
          <label >Account Status</label><br>
          <select id="edituserstatus" class='selectpicker' name='accountstatus' disabled="disabled">
            <option value="Active" <?php if($user_status == 1) echo 'selected' ?>>Active</option>
            <option value="Invited" <?php if($user_status == 0) echo 'selected' ?>>Invited</option>
          </select>
          
                <!--label>Last Login</label>
                <div class="input-group date" data-provide="datepicker">
                    <input id="bidsres" type="text" class="form-control" name='lastlogin' value="<?php //echo $_SESSION['lastlogin']; ?>">
                    <div class="input-group-addon">
                      <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
              
          
          <br>
          
                <label>Created At</label>
                <div class="input-group date" data-provide="datepicker">
                    <input id="bidsres" type="text" class="form-control" name='createdat' value="<?php //echo $_SESSION['createdat']; ?>">
                    <div class="input-group-addon">
                      <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
              
          
          <br>
          
                <label>Updated At</label>
                <div class="input-group date" data-provide="datepicker">
                    <input id="bidsres" type="text" class="form-control" name='updatedat' value="<?php //echo $_SESSION['updatedat']; ?>">
                    <div class="input-group-addon">
                      <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
              
       
          <br>
          <label>Created By</label>
          <input type='text' name='createdby' class='form-control' required>
          <br>
          <label>Updated By</label>
          <input type='text' name='updatedby' class='form-control' required-->

        </div>
        <div class="modal-footer">
          <input type="hidden" id="userid" name=""><div>
          <input type="hidden" id="groupid" name=""></div>
          <!--button type="button" class="btn btn-default" data-dismiss="modal">Close</button-->
          <div>
          <a onclick='sendInviteEmail()' >Resend Invite Email</a>
          </div>
          <div>
          <a onclick="setPassword()">Reset Password</a>
        </div>
        <!--div>
          <a href='groups.php?projectid=<?php echo $_SESSION['pid']; ?>' >Disable Project Access</a>
        </div-->
        <div>
          <a onclick="removeFromProject()">Remove From Project</a>
        </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add User</h4>
      </div>
      <?php
        $uquery = "Select * from groups, gp_relation where gp_relation.projectid = $pid and groups.id = gp_relation.groupid";
        $uresult = mysqli_query($cxn, $uquery);
        $unums = mysqli_num_rows($uresult);
        $groups = array();
        for($i=0;$i<$unums; $i++){
          $row = mysqli_fetch_assoc($uresult);
          $groups[$i] = $row;
        }

        $userquery = "Select * from users";
        $userresult = mysqli_query($cxn, $userquery);
        $userunums = mysqli_num_rows($userresult);
        $users = array();
        for($i=0;$i<$userunums; $i++){
          $row = mysqli_fetch_assoc($userresult);
          $users[$i] = $row;
        }
      ?>
      <form method='post' action='addUserToGroup.php'> 
        <div class="modal-body">
            <label >Group</label><br>
            <select class='selectpicker' name='groups'>
              <?php
                for($i=0; $i<$unums; $i++){
                  echo "<option value={$groups[$i]['groupid']} ";
                  echo ">{$groups[$i]['name']}</option>";
                }
              ?>     
            </select>
          <br>
          <br>
          <label >User</label><br>
            <select class='selectpicker' name='users'>
              <?php
                for($i=0; $i<$userunums; $i++){
                  echo "<option value={$users[$i]['user_id']} ";
                  echo ">{$users[$i]['user_email']}</option>";
                }
              ?>     
            </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add User</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function getcPicker(){
  $("#cfolderid").val("");
  $(".fcpicker :selected").each(function(){
    $("#cfolderid").val($("#cfolderid").val()+","+$(this).val());
  })
  return true;
}
function getePicker(){
  $("#efolderid").val("");
  $(".fepicker :selected").each(function(){
    $("#efolderid").val($("#efolderid").val()+","+$(this).val());
  })
  return true;
}
$(document).ready(function(){
    $('[name="passwordconfirm"]').blur(function(){
      if(document.getElementsByName("password")[0].value != document.getElementsByName("passwordconfirm")[0].value) {
        document.getElementsByName("password")[0].value = '';
        document.getElementsByName("passwordconfirm")[0].value = '';
      }
    });
});
</script>

