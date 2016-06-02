<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
require_once 'vendor/autoload.php';
include("include/header.php");

 if(!isset($_SESSION['userid']))
{ 
	header("Location:login.php");
}


?>

<div class="container-fluid">
  <div class="col-sm-9  col-md-10 paddingtop10">
    
    <div class="row-fluid">
      <h3>Create New Project</h3>
    </div>
    
          <div class="row">
        

          
            <div class="col-sm-12">
              <form method='post' action='projectaction.php'> 
        					
        					 <div class='form-group'>
        						<label>Project Name</label>
        						<input  type='text' name='projectname' class='form-control' required pattern='[A-Za-z0-9\s]*' title='Alphabet and Numbers only'> 
        					</div>	
        					
        					 <div class='form-group'>
        						<label>Project Number</label>
        						<input  type='text' name='projectnumber' class='form-control'> 
        					</div>	
        					
                  <div class="form-group">
                    <label>Status</label>
                    <select name='status' class="form-control">
                      <option value='Planning'>Planning</option>
                      <option value='Permitting'>Permitting</option>
                      <option value='Design'>Design</option>
                      <option value='Advertising'>Advertising</option>
                      <option value='Bidding'>Bidding</option>
                      <option value='Under Contract'>Under Contract</option>
                      <option value='Under Construction'>Under Construction</option>
                      <option value='Constr. & Budgeting Review'>Constr. & Budgeting Review</option>
                      <option value='Completed'>Completed</option>
                    </select>
                  </div>
                  
                  <div class="form-group">
                    <label>Type</label>
                    <select name='type' class="form-control">
                      <option value='Roadway'>Roadway</option>
                      <option value='Water'>Water</option>
                      <option value='Sewer'>Sewer</option>
                      <option value='Solid Waste'>Solid Waste</option>
                      <option value='Boating Facilities'>Boating Facilities</option>
                      <option value='Building Structures'>Building Structures</option>
                      <option value='Other'>Other</option>
                    </select>
                  </div>

                  <div class='form-group'>
                    <label>Funding Sources</label>
                    <input  type='text' name='fundingsources' class='form-control'> 
                  </div>

                  <div class="form-group">
                    <label>District</label>
                    <select name='district' class="form-control">
                      <option value='1'>1</option>
                      <option value='2'>2</option>
                      <option value='3'>3</option>
                      <option value='4'>4</option>
                      <option value='5'>5</option>
                      <option value='6'>6</option>
                      <option value='7'>7</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Fiscal Year</label>
                    <select name='fiscalyear' class="form-control">
                      <?php 
                        $currentYear = date("Y");
                        for($i = $currentYear; $i < $currentYear + 10; $i++){
                          echo "<option value='{$i}' ";
                          echo ">{$i}</option>";
                        }
                      ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Work Force</label>
                    <select name='workforce' class="form-control">
                      <option value='Internal'>Internal</option>
                      <option value='Contracted'>Contracted</option>
                      <option value='Both'>Both</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Project Objective</label>
                    <select name='projectobjective' class="form-control">
                      <option value='New Construction'>New Construction</option>
                      <option value='Repair'>Repair</option>
                      <option value='Maintenance'>Maintenance</option>
                      <option value='Upgrade'>Upgrade</option>
                    </select>
                  </div>
        					
        					<div class="form-group">
          					<label>Location</label>
                    <input class="placepicker form-control" name='location'>
                  </div>
                  
                  <div class="form-group">
          					<label>Description</label>
                  <textarea class="form-control" rows="3" name='description'></textarea>
                  </div>

                  <div class="form-group">
                    <label>Special Conditions</label>
                    <textarea class="form-control" rows="3" name='specialconditions'></textarea>
                  </div>
                          					
            		<input class='span3' type="hidden" name='userid' value='<?php echo $user_id; ?>'>
            		<input class='span3' type="hidden" name='action' value='new'>
            		<input class='span3' type="hidden" name='page' value='newproject'>
            		<input class='span3' type="hidden" name='gobackurl' value='newproject.php'>
            		<br>
            		<div class='form-group'>
            				    <div>
              				    <a href='index.php' class='btn btn-default btn-large'>cancel</a>
            				      <button id='startbutton' type='submit' class='btn btn-primary btn-large pull-right'>Create New Project</button>
            				    </div>
            		</div>
            </form>
          
          </div>
          
        </div>
  

  </div>
</div>

<script>
  $(".placepicker").placepicker();
</script>
        

<?php

include("include/footer.php");

?>




