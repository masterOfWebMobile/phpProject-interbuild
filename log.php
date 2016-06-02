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

      
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 ">
<?php  include("include/alerts.php"); ?>  
  
  <div class="row paddingtop10">            
   <span class='indexpage_header'>Log</span>
  </div>


  <div class="row paddingtop10">
    <?php
    $logQuery = "Select * from logs where projectid={$_SESSION['pid']} order by time DESC";
    $logRes = mysqli_query($cxn, $logQuery);
    while($row = mysqli_fetch_assoc($logRes)){
    ?>
    <div class="log-entry">
      <span class='timestamp pull-right'><?php echo date("Y-m-d h:i:s A",$row['time']); ?></span>
      <p><?php echo $row['detail']; ?></p>
    </div>
    <?php
    }
    ?>
  </div>
  
  
  
</div>


  
  
</div>

<script> document.getElementById("log").className = "active"; </script> 

<?php

include("include/footer.php");

?>




