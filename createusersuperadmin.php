<?php
error_reporting(E_ERROR | E_PARSE);
include("include/header.php");
session_unset();
?>

<div class="container-fluid">
  <div class="col-sm-9  col-md-10 paddingtop10">
    
    <div class="row-fluid">
      <h3>Create SuperAdmin User</h3>
    </div>
    
          <div class="row">
        

          
            <div class="col-sm-12">
              <form method='post' action='usercreatesuperadmin.php'> 
        					
        					<div class='form-group'>
        						<label>First Name*</label>
        						<input  type='text' name='firstname' class='form-control' required value=""> 
        					</div>	
        					
        					<div class='form-group'>
        						<label>Last Name*</label>
        						<input  type='text' name='lastname' class='form-control' required value=""> 
        					</div>	
        					
          <label style="margin-top: 10px !important;">Organization*</label><br>
          <!--select class='selectpicker' name='usergroup'>
            //<?php
            //  for($i=0; $i<$unums; $i++){
            //    echo "<option value={$i} ";
            //    echo ">{$groups[$i]['name']}</option>";
            //  }
            //?>     
          </select-->
          <input type='text' name='organization' class='form-control'>
          <br>
          <br>
          <label>Title*</label>
          <input type='text' name='title' class='form-control'>
          <br>
          <label>Phone(Office)*</label>
          <input type='text' name='phoneoffice' class='form-control'>
          <br>
          <label>Phone(Mobile)*</label>
          <input type='text' name='phonemobile' class='form-control'>
          <br>
          <label>Fax*</label>
          <input type='text' name='fax' class='form-control'>
          <br>
          <label>Address*</label>
          <input type='text' name='address' class='form-control'>
          <br>
          <label>Zip*</label>
          <input type='text' name='zip' class='form-control'>
          <br>
          <label>Email Address*</label>
          <input type='email' name='emailaddress' class='form-control' required>
          <br>
          <label>Password*</label>
          <input type='password' name='password' class='form-control' required>
          <br>
          <label>Password Confirm*</label>
          <input type='password' name='passwordconfirm' class='form-control' required>
          <br>
      		<div class='form-group'>
				    <div>
  				    
				      <button id='startbutton' type='submit' class='btn btn-primary btn-large pull-right'>Create SuperAdmin User</button>
				    </div>
      		</div>
          <br>
          <br>
          </form>
          
          </div>
          
        </div>
  

  </div>
</div>

<script>
  $(".placepicker").placepicker();
</script>
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




