<?php
session_start();
include("include/access.php");  
$fquery = "select * from groups, gp_relation where gp_relation.groupid = groups.id and gp_relation.projectid={$_SESSION['pid']}";
$fresult = mysqli_query($cxn,$fquery);
$fncount = mysqli_num_rows($fresult);
$pid = $_SESSION['pid'];
$projectid = $_SESSION['pid'];
$userid = $_SESSION['userid'];
$rolequery = "Select distinct role as role from users,gp_relation,gu_relation where gp_relation.projectid = {$_SESSION['pid']} and gp_relation.groupid=gu_relation.groupid and gu_relation.userid=users.user_id and users.user_id = $userid";
$roleresult = mysqli_query($cxn, $rolequery);
$rolerow = mysqli_fetch_assoc($roleresult);
extract($rolerow);
?>
<div class="modal fade" id="folderedit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Folder</h4>
      </div>
      <form method='post' action='editfolder.php'> 
      <div class="modal-body">
        
        
          
          <div class='form-group'>
						<label>Folder Name</label>
						<input id="demodal_fName" type='text' name='fname' class='form-control'>
            <input type="hidden" id="demodal_fid" name="fid"> 
            <input type="hidden" id="demodal_pid" name="pid"> 
          </div>
          
          <div class='form-group'>
						<label>Access</label>
            <?php
            for($i=0; $i<$fncount; $i++){
              $frow = mysqli_fetch_assoc($fresult);
              extract($frow);
            ?>
            <div class="checkbox fgroup_check">
              <label><input type="checkbox" id="group_<?php echo $groupid; ?>" name="g_<?php echo $groupid; ?>" value="<?php echo $groupid; ?>"><?php echo $name;?></label>
            </div>
            <?php
            }
            ?>
          </div>
        
        <br>
        <button type="button" class='btn btn-danger' id='demodal_deletebutton' onclick='deletefolder()' <?php  if($role > 1)
        {
          echo "disabled";
        } ?>>Delete Folder</button>
        
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="newfolder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New Folder</h4>
      </div>
      <form method='post' action='newfolder.php'> 
      <div class="modal-body">
        
        
          
          <div class='form-group'>
						<label>Folder Name</label>
						<input  type='text' name='foldername' class='form-control'> 
            <input type='hidden' name='pid' value='<?php echo $_SESSION["pid"];?>'>
          </div>
          
          <div class='form-group'>
						<label>Access</label>
            <?php
            $fresult = mysqli_query($cxn,$fquery);
            for($i=0; $i<$fncount; $i++){
              $frow = mysqli_fetch_assoc($fresult);
              extract($frow);
            
            ?>
						<div class="checkbox">
              <label><input type="checkbox" name="g_<?php echo $groupid; ?>" value="1"><?php echo $name;?></label>
            </div>
            <?php
            }
            ?>
          </div>
          
        
        <br>
        
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="newfile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Upload File</h4>
      </div>
      <div class="modal-body">
        
        <form method='post' action='uploadfile.php' enctype="multipart/form-data"> 
          
          <div class="form-group">
          <label for="exampleInputFile">File</label>
          <input type="file" name="upload[]" multiple="multiple">
        </div>
          
          <input class="hidden" name="undertype" value="folder">
          <input class="hidden" id="upfid" name="folder">
           <input class="hidden" id="proid" name="project">
          
       
        <br>
        
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Upload</button>
      </div>
    </form>
    </div>
  </div>
</div>
<?php

$uquery = "Select distinct user_email,account_organization,account_location,account_zip,account_fax,account_firstname,account_phone,account_lastname,account_title from accounts,users,gp_relation,gu_relation where gp_relation.projectid = {$_SESSION['pid']} and gp_relation.groupid=gu_relation.groupid and gu_relation.userid=users.user_id and users.user_id = accounts.account_userid";
$uresult = mysqli_query($cxn, $uquery);
$unums = mysqli_num_rows($uresult);
$users = array();
for($i=0;$i<$unums; $i++){
  $row = mysqli_fetch_assoc($uresult);
  $users[$i] = $row;
}
?>
<script>
var users = JSON.parse('<?php echo json_encode($users);?>',true);
</script>
<div class="modal fade" id="docSigner" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Select Signers</h4>
      </div>
      <div class="modal-body">
          <div class="checkbox" >
                  <label >
                    <input type="checkbox" id="signerOrderCheck"> Setting signers' order
                  </label>
                </div>
                <script>
                  $(document).ready(function(){
                    $('#doc_signer1_order').selectpicker("hide");
                    $('#doc_signer2_order').selectpicker("hide");
                    $('#doc_signer3_order').selectpicker("hide");
                  });
                  $('#signerOrderCheck').on('change', function() {

                      if (this.checked) {
                        //$('.selgroup .bootstrap-select:first-child').css("display", null);
                        $('#doc_signer1_order').selectpicker("show");
                        $('#doc_signer2_order').selectpicker("show");
                        $('#doc_signer3_order').selectpicker("show");
                      }
                      else {
                        $('#doc_signer1_order').selectpicker("hide");
                        $('#doc_signer2_order').selectpicker("hide");
                        $('#doc_signer3_order').selectpicker("hide");
                      }
                  });
                </script>
          <div class='form-group'>

						<label>Signer1</label>
            &nbsp;&nbsp;&nbsp;

            <div class="selgroup" style="display: inline-block">
            <select id="doc_signer1_order" name="sel_con_order" class="selectpicker">

              <option value="-">-</option>
              <?php
              for($i=1; $i<4; $i++){
                echo "<option value='{$i}' ";
                echo ">{$i}</option>";
              }
              ?> 
            </select>
						<select id="doc_signer1" name="sel_con" class="selectpicker">
              <option value="-">-</option>
              <?php
              for($i=0; $i<$unums; $i++){
                echo "<option value={$i}>{$users[$i]['account_firstname']} {$users[$i]['account_lastname']}</option>";
              }
              ?>                   
            </select>
          </div>
          </div>

          <div class='form-group'>
            <label>Signer2</label>
            &nbsp;&nbsp;&nbsp;
            <div class="selgroup" style="display: inline-block">
            <select id="doc_signer2_order" name="sel_con_order" class="selectpicker">

              <option value="-">-</option>
              <?php
              for($i=1; $i<4; $i++){
                echo "<option value='{$i}' ";
                echo ">{$i}</option>";
              }
              ?> 
            </select>
            <select id="doc_signer2" name="sel_con" class="selectpicker">
              <option value="-">-</option>
              <?php
              for($i=0; $i<$unums; $i++){
                echo "<option value={$i}>{$users[$i]['account_firstname']} {$users[$i]['account_lastname']}</option>";
              }
              ?>                   
            </select>
          </div>
          </div>

          <div class='form-group'>
            <label>Signer3</label>
            &nbsp;&nbsp;&nbsp;
            <div class="selgroup" style="display: inline-block">
            <select id="doc_signer3_order" name="sel_con_order" class="selectpicker">

              <option value="-">-</option>
              <?php
              for($i=1; $i<4; $i++){
                echo "<option value='{$i}' ";
                echo ">{$i}</option>";
              }
              ?> 
            </select>
            <select id="doc_signer3" name="sel_con" class="selectpicker">
              <option value="-">-</option>
              <?php
              for($i=0; $i<$unums; $i++){
                echo "<option value={$i}>{$users[$i]['account_firstname']} {$users[$i]['account_lastname']}</option>";
              }
              ?>                   
            </select>
          </div>
          </div>
          <input type="hidden" id="doc_name">
          <input type="hidden" id="doc_type">
          <input type="hidden" id="doc_uemail">
        <br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="docReqSig()">Submit</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editDoc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Document</h4>
      </div>
      <div class="modal-body">
          <?php
          $pid = $_SESSION['pid'];
            $folderQuery = "Select * from folders where folder_deleted=0 and (folder_projectid = 0 or folder_projectid = $pid)";
            $folderResult = mysqli_query($cxn, $folderQuery);
            $folders = array();
            $folderRowsNum = mysqli_num_rows($folderResult); 
            
          for($i=0; $i<$folderRowsNum; $i++){
            $row = mysqli_fetch_assoc($folderResult);
            $folders[$i] = $row;
          }
          ?>
          <div class='form-group'>
            <label>Move To Folder</label>
            &nbsp;&nbsp;&nbsp;
            <select id="folderToMove" name="sel_con" class="selectpicker">
              <?php
              for($i=0; $i<$folderRowsNum; $i++){
                echo "<option value={$folders[$i]['folder_id']}";
                echo ">{$folders[$i]['folder_name']}</option>";
              }
              ?>                   
            </select>
          </div>

          <div class='form-group'>
            <label>Edit Document Name</label>
            &nbsp;&nbsp;&nbsp;
            <input type="text" id="nameToChange" name="sel_con" class='form-control' required/>
          </div>

          <input type="hidden" id="doc_id">
        <br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="moveFolder()">Move Folder</button>
        <button type="button" class="btn btn-info" onclick="editDocumentName()">Edit Document Name</button>
      </div>
    </div>
  </div>
</div>