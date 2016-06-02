<?php
require_once 'vendor/autoload.php';
include("include/header.php");

 if(!isset($_SESSION['userid']))
{ 
//	header("Location:login.php");
}

//include("include/userheader.php");

?>

<?php include("include/mainsidebar.php"); ?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2">
          
  <div class="row-fluid paddingtop10">            
   <span class='indexpage_header'>Activity</span>
  </div>
  
  <br>
  <div class="row">
    
    <div class="log-entry">
      <span class='timestamp pull-right'>10:15AM 12/23/15</span>
      <p>User 123 has added a new document.</p>
    </div>
    
        <div class="log-entry">
      <span class='timestamp pull-right'>10:15AM 12/23/15</span>
      <p>User 123 has signed a document.</p>
    </div>
    
    
  </div>
  
  
  
</div>

<script> document.getElementById("activity").className = "active"; </script> 
<?php

include("include/footer.php");

?>




