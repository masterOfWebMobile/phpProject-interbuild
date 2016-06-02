<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
require_once 'vendor/autoload.php';
include("include/header.php");

 if(!isset($_SESSION['userid']))
{ 
	header("Location:login.php");
}
$project_session_id = $_SESSION['pid'];
$getprojectrowquery="SELECT * FROM projects where project_id = $project_session_id";
$getprojectrowresult = mysqli_query($cxn,$getprojectrowquery);
$getprojectrow=mysqli_fetch_assoc($getprojectrowresult);
if($getprojectrow != null)
extract($getprojectrow);
?>

<div class="container-fluid">
  <div class="col-sm-9  col-md-10 paddingtop10">
    
    <div class="row-fluid">
      <h3>Edit Project</h3>
    </div>
    
          <div class="row">
        

          
            <div class="col-sm-12">
              <form method='post' action='projectaction.php'> 
        					
        					 <div class='form-group'>
        						<label>Project Name</label>
        						<input  type='text' name='projectname' class='form-control' required value="<?php echo $project_name ?>"> 
        					</div>	
        					
        					 <div class='form-group'>
        						<label>Project Number</label>
        						<input  type='text' name='projectnumber' class='form-control' value="<?php echo $project_number ?>"> 
        					</div>	
        					
                  <div class="form-group">
                    <label>Status</label>
                    <select name='status' class="form-control" value="<?php echo $project_status; ?>">
                      <option value='Planning' <?php if($project_status == 'Planning'){ echo "selected"; } ?>>Planning</option>
                      <option value='Permitting' <?php if($project_status == 'Permitting'){ echo "selected"; } ?>>Permitting</option>
                      <option value='Design' <?php if($project_status == 'Design'){ echo "selected"; } ?>>Design</option>
                      <option value='Advertising' <?php if($project_status == 'Advertising'){ echo "selected"; } ?>>Advertising</option>
                      <option value='Bidding' <?php if($project_status == 'Bidding'){ echo "selected"; } ?>>Bidding</option>
                      <option value='Under Contract' <?php if($project_status == 'Under Contract'){ echo "selected"; } ?>>Under Contract</option>
                      <option value='Under Construction' <?php if($project_status == 'Under Construction'){ echo "selected"; } ?>>Under Construction</option>
                      <option value='Constr. & Budgeting Review' <?php if($project_status == 'Constr. & Budgeting Review'){ echo "selected"; } ?>>Constr. & Budgeting Review</option>
                      <option value='Completed' <?php if($project_status == 'Completed'){ echo "selected"; } ?>>Completed</option>
                    </select>
                  </div>
                  
                  <div class="form-group">
                    <label>Type</label>
                    <select name='type' class="form-control" value="<?php echo $project_type; ?>">
                      <option value='Roadway' <?php if($project_type == 'Roadway'){ echo "selected"; } ?>>Roadway</option>
                      <option value='Water' <?php if($project_type == 'Water'){ echo "selected"; } ?>>Water</option>
                      <option value='Sewer' <?php if($project_type == 'Sewer'){ echo "selected"; } ?>>Sewer</option>
                      <option value='Solid Waste' <?php if($project_type == 'Solid Waste'){ echo "selected"; } ?>>Solid Waste</option>
                      <option value='Boating Facilities' <?php if($project_type == 'Boating Facilities'){ echo "selected"; } ?>>Boating Facilities</option>
                      <option value='Building Structures' <?php if($project_type == 'Building Structures'){ echo "selected"; } ?>>Building Structures</option>
                      <option value='Other' <?php if($project_type == 'Other'){ echo "selected"; } ?>>Other</option>
                    </select>
                  </div>

                  <div class='form-group'>
                    <label>Funding Sources</label>
                    <input  type='text' name='fundingsources' class='form-control' value="<?php echo $project_fundingsources; ?>"> 
                  </div>

                  <div class="form-group">
                    <label>District</label>
                    <select name='district' class="form-control">
                      <option value='1' <?php if($project_district == '1'){ echo "selected"; } ?>>1</option>
                      <option value='2' <?php if($project_district == '2'){ echo "selected"; } ?>>2</option>
                      <option value='3' <?php if($project_district == '3'){ echo "selected"; } ?>>3</option>
                      <option value='4' <?php if($project_district == '4'){ echo "selected"; } ?>>4</option>
                      <option value='5' <?php if($project_district == '5'){ echo "selected"; } ?>>5</option>
                      <option value='6' <?php if($project_district == '6'){ echo "selected"; } ?>>6</option>
                      <option value='7' <?php if($project_district == '7'){ echo "selected"; } ?>>7</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Fiscal Year</label>
                    <select name='fiscalyear' class="form-control">
                      <?php 
                        $currentYear = date("Y");
                        for($i = $currentYear; $i < $currentYear + 10; $i++){
                          echo "<option value='{$i}' ";
                          if ($project_fiscalyear == $i) {echo "selected";}
                          echo ">{$i}</option>";
                        }
                      ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Work Force</label>
                    <select name='workforce' class="form-control">
                      <option value='Internal' <?php if($project_workforce == 'Internal'){ echo "selected"; } ?>>Internal</option>
                      <option value='Contracted'<?php if($project_workforce == 'Contracted'){ echo "selected"; } ?>>Contracted</option>
                      <option value='Both' <?php if($project_workforce == 'Both'){ echo "selected"; } ?>>Both</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Project Objective</label>
                    <select name='projectobjective' class="form-control">
                      <option value='New Construction' <?php if($project_objective == 'New Construction'){ echo "selected"; } ?>>New Construction</option>
                      <option value='Repair' <?php if($project_objective == 'Repair'){ echo "selected"; } ?>>Repair</option>
                      <option value='Maintenance' <?php if($project_objective == 'Maintenance'){ echo "selected"; } ?>>Maintenance</option>
                      <option value='Upgrade' <?php if($project_objective == 'Upgrade'){ echo "selected"; } ?>>Upgrade</option>
                    </select>
                  </div>
        					
        					<div class="form-group">
          					<label>Location</label>
                    <input class="placepicker form-control" name='location' value="<?php echo $project_location; ?>">
                  </div>
                  
                  <div class="form-group">
          					<label>Description</label>
                  <textarea class="form-control" rows="3" name='description'><?php echo $project_desc; ?></textarea>
                  </div>

                  <div class="form-group">
                    <label>Special Conditions</label>
                    <textarea class="form-control" rows="3" name='specialconditions'><?php echo $project_specialconditions; ?></textarea>
                  </div>
                          					
            		<input class='span3' type="hidden" name='userid' value='<?php echo $user_id; ?>'>
            		<input class='span3' type="hidden" name='action' value='update'>
            		<input class='span3' type="hidden" name='page' value='newproject'>
            		<input class='span3' type="hidden" name='gobackurl' value='newproject.php'>
                <input class='span3' type="hidden" name='id' value='<?php echo $_SESSION['pid']; ?>'>
            		<br>
            		<div class='form-group'>
            				    <div>
              				    <a href='project.php?projectid=<?php echo $_SESSION['pid']; ?>' class='btn btn-default btn-large'>cancel</a>
            				      <button id='startbutton' type='submit' class='btn btn-primary btn-large pull-right'>Edit Project</button>
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




