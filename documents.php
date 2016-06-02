<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
require_once 'vendor/autoload.php';
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
  
  <div class="row paddingtop10 borderbottom paddingright10">            
   <span class='indexpage_header'>Documents</span>
   <div class='pull-right'>
        <span class='btn btn-info' data-toggle="modal" data-target="#newfolder">New Folder</span> 
   </div>

  </div>
  
  <?php
  $pid = $_SESSION['pid'];
  $projectid = $_SESSION['pid'];
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
  
  if($_SESSION['superadmin'] == 1 && strpos($_SESSION['managepid'], $pid) !== false)
    $groupquery = "Select folder_id as folderid from folders where folder_projectid=0 or folder_projectid={$_SESSION['pid']}";
  else
      $groupquery = "Select folderid from gf_relation,gp_relation,gu_relation where gu_relation.userid={$_SESSION['userid']} and gu_relation.groupid=gp_relation.groupid and gp_relation.projectid={$_SESSION['pid']} and gp_relation.groupid=gf_relation.groupid";
  $gresult = mysqli_query($cxn, $groupquery);
  $gstr = "-9,";
  while($row= mysqli_fetch_assoc($gresult)){
    $gstr .= $row['folderid'].",";
  }
  if($gstr != ""){
    $gstr = substr($gstr,0,-1);
  }

  $foldersquery = "SELECT * FROM folders WHERE folder_id in ($gstr)";
  $foldersresult = mysqli_query($cxn,$foldersquery);
  $foldersnrows = mysqli_num_rows($foldersresult);
  for ($x=0; $x<$foldersnrows; $x++)
  {
    $foldersrow=mysqli_fetch_assoc($foldersresult);
    extract($foldersrow);
    if ($folder_deleted == 1)
      continue;
      echo " <div class='row folders'>";
      
     echo " <div>      ";
     echo " <h4 onclick=toggle('folders$folder_id'); style='cursor:pointer; display:inline'>";
     echo "  $folder_name &nbsp;&nbsp;&nbsp;   ";    
     echo " </h4><span class='glyphicon glyphicon-upload arrow' data-toggle='modal' data-target='#newfile' onclick='setfolder($folder_id,$project_id)' aria-hidden='true' ></span><span class='glyphicon glyphicon-edit arrow' aria-hidden='true' data-toggle='modal' data-target='#folderedit'  onclick='checkfolders($folder_id,$project_id,\"$folder_name\")'></span>";

     echo " </div>";
      
 echo " </div>";
 
echo "  <div id='folders$folder_id' style='display:none;'>";

  /*echo 'projectid'.$projectid.'folderid'.$folder_id;
  exit;*/       
  $docsquery = "SELECT * FROM documents WHERE projectid=$projectid and folderid=$folder_id and document_deleted = 0/*in (0,2)*/";
  $docsresult = mysqli_query($cxn,$docsquery);
  $docsnrows = mysqli_num_rows($docsresult);
  if($docsnrows == 0){
    echo"<div class='row'>";
          
echo"        <div class='file'>No Documents</div></div>";
  }
  for ($z=0; $z<$docsnrows; $z++)
  {
    $docsrow=mysqli_fetch_assoc($docsresult);
    extract($docsrow);
   
   
   
   echo"<div class='row'>";
          
echo"        <div class='file'>";
            
echo"            <span class='filename'><a target='_blank' href='$document_location'>$document_name</a></span>";
   if ($document_signed == 1)
    echo "<img src='images/hello-sign.png' class='hello' style='margin-left: 10px !important'>";            
echo"            <div class='pull-right'>";
echo"              <button class='btn btn-primary' data-toggle='modal' data-target='#editDoc' onclick=setDocEditDetails('$document_id','$document_name','$folderid');>Edit</button>";
echo"              <button class='btn btn-info' data-toggle='modal' data-target='#docSigner' onclick=setReqSig('$document_name','$folderid','{$_SESSION['useremail']}');>Send For Signature</button>";
echo"              <button class='btn btn-danger' onclick='deletefile($document_id)'";

if($role > 1)
  {
    echo "disabled";
  }

echo ">Delete</button>";

echo"            </div>";
            
echo"          </div>";

echo" </div>";
    
  }
         
echo "</div>";
    
    
  }
  
  ?>
  <div class='row folders'>
      
    <div>
    <h4 onclick=toggle('deletedItmes'); style='cursor:pointer; display:inline; color: #ac2925;'>
      Deleted Items
    </h4>
    </div>
  </div>
  <?php
  echo "  <div id='deletedItmes' style='display:none;'>";
  echo"<div class='row folders'>";
          
  echo"        <div style='margin-left: 10px !important'><h5>Deleted Folders</h5></div></div>";
         
  $deletedFoldersQuery = "SELECT * FROM folders WHERE folder_projectid=$projectid and folder_deleted = 1";
  $deletedFoldersResult = mysqli_query($cxn,$deletedFoldersQuery);
  $deletedFoldersRows = mysqli_num_rows($deletedFoldersResult);
  
  if($deletedFoldersRows == 0){
    echo"<div class='file'>";
          
    echo"        <div style='margin-left: 20px !important'>No Deleted Folders</div></div>";
  }
  for ($z=0; $z<$deletedFoldersRows; $z++)
  {
    $deletedFoldersRow=mysqli_fetch_assoc($deletedFoldersResult);
    extract($deletedFoldersRow);
   
    
    echo"<div class='file'>";
          
    echo"        <div style='padding-left:20px !important'>";
   
      echo"            <span class='glyphicon glyphicon-plus plusicon' style='cursor:pointer;' onclick=toggle('deletedFilesInFolder$folder_id');></span> <span class='filename plusfilename' style='cursor:pointer;' onclick=toggle('deletedFilesInFolder$folder_id');>$folder_name</span>";
    
    echo"            <div class='pull-right'>";
    echo"              <button class='btn btn-primary' onclick='recoverfolder($folder_id)'";

    if($role > 1)
      {
        echo "disabled";
      }

    echo ">Recover</button>";

    echo"            </div>";
                
    echo"          </div>";

    echo" </div>";

    $deletedFilesInFoldersQuery = "SELECT * FROM documents WHERE projectid=$projectid and document_deleted = 1 and folderid = $folder_id";
    $deletedFilesInFoldersResult = mysqli_query($cxn,$deletedFilesInFoldersQuery);
    $deletedFilesInFoldersRows = mysqli_num_rows($deletedFilesInFoldersResult);
    echo "  <div id='deletedFilesInFolder$folder_id' style='display:none;'>";
      if($deletedFilesInFoldersRows == 0){
        echo"<div class='row folders'>";
              
        echo"        <div style='margin-left: 30px !important'>No Deleted Documents</div></div>";
      }
      for ($k=0; $k<$deletedFilesInFoldersRows; $k++)
      {
        $deletedFilesInFoldersRow = mysqli_fetch_assoc($deletedFilesInFoldersResult);
        extract($deletedFilesInFoldersRow);
       
       
       
        echo"<div class='file'>";
              
        echo"        <div style='padding-left:30px !important'>";
        echo $document_name;
        echo" </div></div>";
      }     
    echo" </div>";
  }
    
  

  echo"        <div class='row folders' ><div style='margin-left: 10px !important'><h5>Deleted Documents</h5></div></div>";
         
  $deletedDocumentsQuery = "SELECT * FROM documents, folders WHERE documents.folderid = folders.folder_id and (folder_projectid=$projectid or folder_projectid = 0) and projectid = $projectid and folder_deleted = 0 and document_deleted = 1";
  $deletedDocumentsResult = mysqli_query($cxn,$deletedDocumentsQuery);
  $deletedDocumentsRows = mysqli_num_rows($deletedDocumentsResult);
  if($deletedDocumentsRows == 0){
    echo"<div class='file'>";
          
    echo"        <div style='margin-left: 20px !important'>No Deleted Documents</div></div>";
  }
  for ($z=0; $z<$deletedDocumentsRows; $z++)
  {
    $deletedDocumentsRow=mysqli_fetch_assoc($deletedDocumentsResult);
    extract($deletedDocumentsRow);
   
   
   
    echo"<div class='file'>";
          
    echo"        <div style='padding-left:20px !important'>";
   
     echo"            <span class='filename'>$document_name</span>";
      if ($document_signed == 1)
    echo "<img src='images/hello-sign.png' class='hello' style='margin-left: 10px !important'>";
    echo"            <div class='pull-right'>";
    echo"              <button class='btn btn-primary' onclick='recoverfile($document_id)'";

    if($role > 1)
      {
        echo "disabled";
      }

    echo ">Recover</button>";

    echo"            </div>";
                
    echo"          </div>";

    echo" </div>";
  }  
  ?>

</div>        
<script type="text/javascript"> projectid = <?php echo $projectid;?></script>
<script> document.getElementById("documents").className = "active"; </script>
<script type="text/javascript">
$(document).ready(function(){
    checkpending();
});
jQuery(document).ready(function ($) {
  $(".glyphicon-plus").on('click', function(event) {
  console.log('clicked');
   $(this).toggleClass("glyphicon-minus glyphicon-plus");
  });

  $(".plusfilename").on('click', function(event) {
  console.log('clicked');
   $(this).prev().toggleClass("glyphicon-minus glyphicon-plus");
  });
});
</script>
<?php

include_once("documentsmodals.php");

?>
<?php

include("include/footer.php");

?>






