<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
require_once 'vendor/autoload.php';
include("include/header.php");
$client = new HelloSign\Client($apikey);
$pid = $_GET['projectid'];
//echo $pid;
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
   <span class='indexpage_header'>Pending Signatures</span>
  </div>
  
  <?php

  $docsquery = "SELECT * FROM pendingSig where projectid = {$_SESSION['pid']}";
  $docsresult = mysqli_query($cxn,$docsquery);
  $docsnrows = mysqli_num_rows($docsresult);
  if($docsnrows == 0){
    echo "<div class='row'><div class='file'><span>All signature requests have been completed!</span></div></div>";
  } else {
    $docsquery1 = "SELECT * FROM pendingSig where projectid = {$_SESSION['pid']} and emails like '%".$_SESSION['useremail']."%'";
    $docsresult1 = mysqli_query($cxn,$docsquery1);
    $docsnrows1 = mysqli_num_rows($docsresult1);
    echo"<div class='row'><div class='file'><h4>Awaiting my signature<h4></div></div>";
    if($docsnrows1 == 0){
      echo "<div class='row'><div class='file'><span>No documents waiting for my sign</span></div></div>";
    }  
    $myEmail = $_SESSION['useremail'];
    $errorids = "";
    for ($z=0; $z<$docsnrows1; $z++)
    {
      $docsrow1=mysqli_fetch_assoc($docsresult1);
      extract($docsrow1);
      $signature_request = $client->getSignatureRequest($docsrow1['requestid']);
      $signatures = $signature_request->getSignatures();
      $signURL = "";
      foreach ($signatures as $key => $signature) {
        if($signature->signer_email_address == $myEmail && $signature->getStatusCode()!="signed"){
          try{
            $signURL = $client->getEmbeddedSignUrl($signature->signature_id);
            echo"<div class='row'>";
            
            echo"        <div class='file'>";
                        
            echo"            <span class='filename'><a target='_blank' href='files/$docname' download>$docname</a></span>";
                        
            echo"            <div class='pull-right'>";
            echo"              <button class='btn btn-info' onclick=pullRequest('$requestid');>Pull Request</button>";
            echo"              <button class='btn btn-warning' onclick=openSignURL('".$signURL->sign_url."');>Sign</button>";

            echo"            </div>";
                        
            echo"          </div>";

            echo" </div>";
          } catch(Exception $e) {
            $errorids .= $docsrow1['id'].",";
          }
        }
      }
      
      
    }
    if ($errorids != "")
      $docsquery2 = "SELECT * FROM pendingSig where (projectid = {$_SESSION['pid']} and emails not like '%".$_SESSION['useremail']."%') or id in (".substr($errorids,0,-1).")";
    else  
      $docsquery2 = "SELECT * FROM pendingSig where projectid = {$_SESSION['pid']} and emails not like '%".$_SESSION['useremail']."%'";
    //echo $docsquery2;
    $docsresult2 = mysqli_query($cxn,$docsquery2);
    $docsnrows2 = mysqli_num_rows($docsresult2);
    echo"<div class='row'><div class='file'><h4>Requested Signatures<h4></div></div>";
    if($docsnrows2 == 0){
      echo "<div class='row'><div class='file'><span>No documents waiting for my sign</span></div></div>";
    }  
    for ($z=0; $z<$docsnrows2; $z++)
    {
      $docsrow2=mysqli_fetch_assoc($docsresult2);
      extract($docsrow2);

      echo"<div class='row'>";
            
      echo"        <div class='file'>";
                  
      echo"            <span class='filename'><a target='_blank' href='files/$docname' download>$docname</a></span>";
                  
      echo"            <div class='pull-right'>";
      echo"              <button class='btn btn-info' onclick=pullRequest('$requestid');>Pull Request</button>";
      echo"              <button class='btn btn-warning' onclick=sendReminder('$requestid');>Send Reminder</button>";

      echo"            </div>";
                  
      echo"          </div>";

      echo" </div>";
      
    }
  }
    
  
  ?>
  

</div>        

<script> document.getElementById("pending").className = "active"; </script>
<script type="text/javascript">
$(document).ready(function(){
    checkpending();
    });
</script>
<?php

include_once("documentsmodals.php");

?>
<?php

include("include/footer.php");

?>






