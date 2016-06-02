<?php
error_reporting(E_ERROR | E_PARSE);
session_start();

require_once 'vendor/autoload.php';


 if(!isset($_SESSION['userid']))
{ 
	header("Location:login.php");
}

include("include/header.php");

$query = "SELECT * FROM accounts WHERE account_userid = $user_id";
$result = mysqli_query($cxn,$query);
if(mysqli_num_rows($result)!=0)
{
  $row = mysqli_fetch_assoc($result);
  extract($row);
  $action = 'update';

  
}
else
{
  $action = 'new';
}






?>

<div class="container-fluid">
  <?php  include("include/alerts.php"); ?>
  <div id="goodalert" class='row' style="display:none">
            <div class='alert alert-success alert-dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <strong>Success!</strong> Password Reseted.
            </div>
</div>
  <div class="col-sm-9  col-md-10 paddingtop10">
    
    <div class="row-fluid">
      <h3>My Account</h3>
    </div>
    
          <div class="row">
        

          
            <div class="col-sm-5">
              <h4>Info</h4>
              <form method='post' action='updateaccount.php'> 
        					<div class='form-group'>
        						<label>Email</label>
        						<input  type='text' class='form-control' disabled value='<?php echo $user_email; ?>'> 
        					</div>	
        					
        					 <div class='form-group'>
        						<label>First Name</label>
        						<input  type='text' name='firstname' class='form-control' value="<?php echo $account_firstname; ?>"> 
        					</div>	
        					
        					 <div class='form-group'>
        						<label>Last Name</label>
        						<input  type='text' name='lastname' class='form-control' value="<?php echo $account_lastname; ?>"> 
        					</div>	
        					
        					 <div class='form-group'>
        						<label>Organization</label>
        						<input  type='text' name='organization' class='form-control' value="<?php echo $account_organization; ?>"> 
        					</div>	
        					
        					<div class='form-group'>
        						<label>Title</label>
        						<input  type='text' name='title' class='form-control' value="<?php echo $account_title; ?>"> 
        					</div>	
        					
        					  <div class='form-group'>
        						<label>Work Phone</label>
        						<input  type='text' name='workphone' class='form-control' value="<?php echo $account_phone; ?>"> 
        					</div>	
        					
        					<div class='form-group'>
        						<label>Mobile Phone</label>
        						<input  type='text' name='mobilephone' class='form-control' value="<?php echo $account_mobilephone; ?>"> 
        					</div>	
        					
	
        					
            		<input class='span3' type="hidden" name='userid' value='<?php echo $user_id; ?>'>
            		<input class='span3' type="hidden" name='id' value='<?php echo $account_id; ?>'>
            		<input class='span3' type="hidden" name='action' value='<?php echo $action; ?>'>
            		<input class='span3' type="hidden" name='page' value='myaccount'>
            		<input class='span3' type="hidden" name='gobackurl' value='myaccount.php'>
            		<div class='form-group'>
            				    <div>
            				      <button id='startbutton' type='submit' class='btn btn-primary btn-large'>update info</button>
            				    </div>
            		</div>
            </form>
          
          </div>
          
        </div>
  
  
  <hr>
  
      <div class="row">
        

          
            <div class="col-sm-5">
              <h4>Security</h4>
              <!--form method='post' action='reset.php'--> 
        					<div class='form-group'>
        						<label>Password</label>
        						<input  type='password' name='password' class='form-control' required> 
        					</div>	
        					
        					<div class='form-group'>
        						<label>Confirm Password</label>
        						<input  type='password' name='passwordconfirm' class='form-control' required> 
        					</div>	
                        		<input class='span3' type="hidden" name='userid' value='<?php echo $user_id; ?>'>
                        		<input class='span3' type="hidden" name='page' value='account'>
                        		<input class='span3' type="hidden" name='gobackurl' value='account.php'>
                        		<div class='form-group'>
            				    <div>
            				      <button id='startbutton' onclick="updatePasswordOnMyAccount(<?php echo $user_id ?>)" class='btn btn-primary btn-large'>update password</button>
            				    </div>
            		</div>
            <!--/form-->
          
          </div>
          
        </div>

  </div>
</div>

<script>
  $(document).ready(function(){


    $('[name="passwordconfirm"]').blur(function(){
      if(document.getElementsByName("password")[0].value != document.getElementsByName("passwordconfirm")[0].value) {
        document.getElementsByName("password")[0].value = '';
        document.getElementsByName("passwordconfirm")[0].value = '';
      }
    });

    

});
</script>


<?php

include("include/footer.php");

?>




