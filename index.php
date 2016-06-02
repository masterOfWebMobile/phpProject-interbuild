<?php
error_reporting(E_ERROR | E_PARSE);
session_start();  

require_once 'vendor/autoload.php';
 if(!isset($_SESSION['userid']))
{ 
	header("Location:login.php");
}

include("include/header.php");

?>

<?php include("include/mainsidebar.php"); ?>
        
<div class="col-md-10 col-md-offset-2">
  
  <div class="row paddingtop10 borderbottom">        
      
     <span class='indexpage_header '>Active Projects</span>
  
    <div class="form form-inline floatright paddingright10">
      
          <div class="form-group form-group-sm floatright marginleft10">
        <label class="font12px">Sort By</label>
        <select name='sort_projects' id='sort_projects' class="form-control">
          <option value='project_name_asc'>Project Name A-Z</option>
          <option value='project_name_desc'>Project Name Z-A</option>
          <option value='most_recent' selected>Most Recent Activity</option>
        </select>
      </div>
      
      <div class="form-group form-group-sm floatright marginleft10">
        <label class="font12px">Type</label>
        <select name='typesort_projects' id='typefilter' class="form-control">
          <option value='' selected>All</option>
          <option value='.roadway'>Roadway</option>
          <option value='.water'>Water</option>
          <option value='.sewer'>Sewer</option>
          <option value='.solid waste'>Solid Waste</option>
          <option value=''>Boating Facilities</option>
          <option value=''>Building Structures</option>
          <option value=''>Other</option>
        </select>
      </div>
      

      
            <div class="form-group form-group-sm floatright marginleft10">
        <label class="font12px">Status</label>
        <select name='statussort_projects' id='statusfilter' class="form-control">
          <option value='' selected>All</option>
          <option value='.planning'>Planning</option>
          <option value='.permitting'>Permitting</option>
          <option value=''>Design</option>
          <option value=''>Advertising</option>
          <option value=''>Bidding</option>
          <option value=''>Under Contract</option>
          <option value=''>Under Construction</option>
          <option value=''>Constr. & Budgeting Review</option>
        </select>
      </div>
      
      
    
    </div>
  
  </div>
  
  <div class="row">
  
  
  <?php
  //show current projects for the user
  //var_dump($_SESSION);
  if($_SESSION['superadmin'] == 1)
    $projectsquery = "SELECT DISTINCT projects. * FROM projects, userid_projectid, gu_relation, gp_relation WHERE (userid_projectid.up_userid = $userid AND projects.project_id = userid_projectid.up_projectid AND projects.project_status != 'completed') or (gu_relation.userid=$userid AND gp_relation.groupid=gu_relation.groupid AND gp_relation.projectid=projects.project_id AND projects.project_status != 'completed')";
  else
    $projectsquery = "SELECT projects. * FROM projects, gu_relation, gp_relation WHERE gu_relation.userid=$userid AND gp_relation.groupid=gu_relation.groupid AND gp_relation.projectid=projects.project_id AND projects.project_status != 'completed'";
  //echo $projectsquery;
  $projectsresult = mysqli_query($cxn,$projectsquery);
  $projectsnrows = mysqli_num_rows($projectsresult);
  for ($x=0; $x<$projectsnrows; $x++)
  {
    $projectsrow=mysqli_fetch_assoc($projectsresult);
    extract($projectsrow);
    echo "<div class='project $project_status $project_type'>";
    echo "<h4>";
    echo "<a href='project.php?projectid=$project_id'>$project_name</a> <span class='glyphicon glyphicon-menu-down arrow' href='#' aria-hidden='true' onclick=toggle('project$project_id');></span>";
    echo "</h4>";
    
      echo "<div id='project$project_id' style='display:none;'>";
    
      echo "<p>Project Number:  <span class='project_number'>$project_number</span></p>";
      echo "<p>Status: $project_status</p>";
      echo "<p>Type: $project_type</p>";
      echo " <p>Most Recent Activity: <span class='recent_activity''>";
      echo $project_mostrecentactivity;
      echo "</span></p>";
      
      echo "</div>";
    
    echo "</div>";
  }
    
  ?>
    
    
  </div>

</div>

<script> document.getElementById("activeprojects").className = "active"; tinysort('.project','.recent_activity', {order:'asc'}); </script> 
<?php

include("include/footer.php");

?>