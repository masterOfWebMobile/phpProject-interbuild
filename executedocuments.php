<?php
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
   <span class='indexpage_header'>Execute Documents</span>
  </div>
  
  
  
  
  <div>
        
        <div class='row'>
          <div class='file'>
            
            <span class='filename'><a target="_blank" href='files/demoproject/contract.pdf' download>contract.pdf</a></span>
            
            <div class='pull-right'>
              <button class='btn btn-danger'>Remove</button>
              <button class='btn btn-info' onclick="requestsig('files/demoproject/contract.pdf')">Request Signature</button>
              <a href='requestsignature.php' class='btn btn-info'>Request Signature</a>
              

            </div>
            
          </div>
            
          </div>
        
        <div class='row'>
          
        <div class='file'>
            
            <span class='filename'><a target="_blank" href='files/demoproject/contract2.pdf' download>contract2.pdf</a></span> <span><i>Pending Signature</i></span>
            
            <div class='pull-right'>
              <button class='btn btn-danger'>Remove</button>
              <button class='btn btn-warning'>Remove Request</button>
              <button class='btn btn-info'>Resend Request</button>
              

            </div>
            
          </div>
            
          </div>
  
  </div>
  

        

<script> document.getElementById("execute").className = "active"; </script>
<?php

include_once("documentsmodals.php");

?>
<?php

include("include/footer.php");

?>






