<?php
session_start();
include("include/printheader.php");

 if(!isset($_SESSION['userid']))
{ 
//	header("Location:login.php");
}

//include("include/userheader.php");

?>
<div id="toprint" class='printbody' style="background-color: white">

    <center>
                <h4><u>PARTIAL PAYMENT ESTIMATE</u></h4> 
      </center>
   
      <div class="row paddingtop10">
        
        <div class="col-md-4">
          <p>CONTRACTOR:</p>
          <p>Contractor Inc.</p>
          <p>123 Street</p>
          <p>Hahira, Georgia</p>
          <p>Person</p>
          
          <p>Ph: 123123123123</p>
          <p> FAX: 123</p>
        </div>
        
        <div class="col-md-4">
          <p>ENGINEER:</p>
          <p>Darabi and Associates</p>
          <p>123 Street</p>
          <p>Hahira, Georgia</p>
          <p>Person</p>
          
          <p>Ph: 123123123123</p>
          <p> FAX: 123</p>
        </div>
        
        <div class="col-md-4">
          <p>OWNER:</p>
          <p>Columbia County BOCC</p>
          <p>123 Street</p>
          <p>Hahira, Georgia</p>
          <p>Person</p>
          
          <p>Ph: 123123123123</p>
          <p> FAX: 123</p>
        </div>
        
      </div>
      
      <div class="row paddingtop10">
        
        <div class="col-md-6">
          <p>Project Name:</p>
          <p>PROJECT NAME</p>
        </div>
        
        <div class="col-md-6">
          <p>Partial Payment Estimate</p>
          <p>Submittal Date: DATE</p>
        </div>
        
      </div>
      
      
      <div class="row paddingtop10">
        
        <div class="col-md-6">
          <p>Project No:</p>
          <p>Period Covered: DATE</p>
        </div>
        
        <div class="col-md-6">
          <p></p>
          <p>through: DATE</p>
        </div>
        
      </div>
      
</div>

<script>
$(document).ready(function(){
var action = getUrlParameter('action');

$.when( savepdf() ).done(function() {
if (action == 'save')
{
  window.close();
}

if (action == 'print')
{
  $.when( makepdf() ).done(function(){
     window.close();
  });
 
}



});
  
});
</script>




