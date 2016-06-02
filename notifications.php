<?php
session_start();
require_once 'vendor/autoload.php';
include("include/header.php");
$myEmail = $_SESSION['useremail'];
$client = new HelloSign\Client($apikey);
if(!isset($_SESSION['userid']))
{ 
	header("Location:login.php");
}

//include("include/userheader.php");

?>

<div class="container-fluid">
    
    <div class="row-fluid paddingtop10">
      <h3>Notifications</h3>
    </div>
  
  
  
      <div class="row-fluid">

          <?php 
          $query = "Select * from pendingSig,projects where emails like '%".$_SESSION['useremail']."%' and projects.project_id = pendingSig.projectid order by project_name";
          $res = mysqli_query($cxn, $query);
          $pname = "";
          while($row = mysqli_fetch_assoc($res)){

            $signature_request = $client->getSignatureRequest($row['requestid']);
            $signatures = $signature_request->getSignatures();
            $signURL = "";
            foreach ($signatures as $key => $signature) {
              if($signature->signer_email_address == $myEmail && $signature->getStatusCode()!="signed"){
                try{
                  $signURL = $client->getEmbeddedSignUrl($signature->signature_id);
                } catch(Exception $e) {
                  $signURL = new stdClass();
                  $signURL->sign_url = "Error";
                }
              }
            }
            if($pname != $row['project_name']){
              $pname = $row['project_name'];
              echo "
              <div class='row notification_entry'>
                <div class='col-md-10'>
                  <p style='font-size:25px;font-weight:800;margin-bottom:0px;'>$pname</p>
                </div>
              </div>
              ";
            }
          ?>
          <div class='row notification_entry'>
            <div class='col-md-10'>
              <p>You need to sign <a target='_blank' href='/files/<?php echo $row['docname']; ?>'><?php echo $row['docname']; ?></a> doc.</p>
            </div>
            <div class='col-md-2' style="text-align:right">
              <button class='btn btn-danger' onclick="pullRequest('<?php echo $row['requestid']; ?>')">Reject</button>
              <button class='btn btn-primary' onclick="openSignURL('<?php echo $signURL->sign_url; ?>')">Sign</button>
            </div>
          </div>         
          <?php
          }
          ?>
        </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
  checkpending();
});
</script>

<script> document.getElementById("notifications").className = "active"; </script> 
<?php

include("include/footer.php");

?>