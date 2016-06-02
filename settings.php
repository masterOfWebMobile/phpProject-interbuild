<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
require_once 'vendor/autoload.php';
include("include/header.php");
include("include/access.php");

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
   <span class='indexpage_header'>Settings</span>
  </div>
  <br>
  
  <p>I would like to be notified if:</p>
  
                <form method='post' action='editsettings.php'>  
                <table class="table table-hover">
                   <tbody>
                     
                    <?php
                    $userid = $_SESSION['userid'];
                    $pid = $_SESSION['pid'];
                    $query = "SELECT * FROM activitytypeid_activityname, alertsetting where activitytypeid_activityname.aa_activitytypeid = alertsetting.activityid and projectid = $pid and userid = $userid";
                    $result = mysqli_query($cxn, $query);
                    $idstr = "";
                    while ($settingsrow=mysqli_fetch_assoc($result))
                    {
                      extract($settingsrow);
                      $idstr .=$id.",";
                      echo "<tr>"; 
                      echo " <td>";
                      echo "  <div class='checkbox'>";
                      echo $aa_activityname;
                      echo "   </div>";
                      echo "</td><td>";
                      echo "   <div class='checkbox'>";
                      echo "       <label>";
                      echo "         <input name='id_$id' type='checkbox' value='1'";
                      if ($status == 1) echo 'checked';
                      echo "> Email";
                      echo "       </label>";
                      echo "    </div>";
                      echo "  </td>";
                      echo " </tr>";
                      
                         }                 
                     ?>
                     
                    </tbody>
                </table>
        				<input type="hidden" name="idstr" value="<?php echo $idstr; ?>"/>
            		<input class='span3' type="hidden" name='projectid' value='<?php echo $project_id; ?>'>
            		<input class='span3' type="hidden" name='page' value='settings'>
            		<input class='span3' type="hidden" name='gobackurl' value='settings.php'>
            		<br>
            		<div class='form-group'>
            				    <div>
            				      <button id='startbutton' type='submit' class='btn btn-primary btn-large pull-right'>Update</button>
            				    </div>
            		</div>
            </form>
            
            

  
  
  
</div>


  
  
</div>

<script> document.getElementById("settings").className = "active"; </script> 

<?php

include("include/footer.php");

?>




