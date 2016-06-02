<?php
  $projectid = $_GET['projectid'];
  $projectquery = "SELECT * FROM projects WHERE project_id = $projectid";
  $projectresult = mysqli_query($cxn,$projectquery);
  $projectrow=mysqli_fetch_assoc($projectresult);
  if($projectrow != null)
  extract($projectrow);

  $pid = $_SESSION['pid'];
  $userid = $_SESSION['userid'];
  $rolequery = "Select distinct role as role from users,gp_relation,gu_relation where gp_relation.projectid = {$_SESSION['pid']} and gp_relation.groupid=gu_relation.groupid and gu_relation.userid=users.user_id and users.user_id = $userid";
  $roleresult = mysqli_query($cxn, $rolequery);
  $rolerow = mysqli_fetch_assoc($roleresult);
  extract($rolerow);

  $userquery = "SELECT * FROM users WHERE user_id = $userid";
  $userresult = mysqli_query($cxn,$userquery);
  $userrow=mysqli_fetch_assoc($userresult);
  if($userrow != null)
  extract($userrow);
?>

<div class="container-fluid">
  <div class="row">
    <div class="col-sm-3 col-md-2 sidebar">
      <ul class="nav nav-sidebar">
        <li id='overview'><a href="project.php?projectid=<?php echo $projectid; ?>">Overview</a></li>
        <li id='schedule'><a href="schedule.php?projectid=<?php echo $projectid; ?>">Schedule</a></li>
        <li id='budget'><a href="budget.php?projectid=<?php echo $projectid; ?>">Budget</a></li>
        <li id='contractstatus'><a href="contractstatus.php?projectid=<?php echo $projectid; ?>">Contract Status</a></li>
        <li id='documents'><a href="documents.php?projectid=<?php echo $projectid; ?>">Documents</a></li>
        <li id='pending'><a href="pendingsignatures.php?projectid=<?php echo $projectid; ?>">Pending Signatures</a></li>
        <li id='contractchange'><a href="contractchangeorder.php?projectid=<?php echo $projectid; ?>">Contract Change Order</a></li>
        <li id='dailyobserv'><a href="dailyobservations.php?projectid=<?php echo $projectid; ?>">Observations</a></li>
        <li id='fdot' style="<?php if($role > 1) echo 'display: none' ?>"><a href="fdot.php?projectid=<?php echo $projectid; ?>">FDOT Fund Request</a></li>
        <hr>
        <li id='groups'><a href="groups.php?projectid=<?php echo $projectid; ?>">Users and Groups</a></li>
        <li id='log' style="<?php if($role == 3) echo 'display: none' ?>"><a href="log.php?projectid=<?php echo $projectid; ?>">Log</a></li>
        <li id='settings'><a href="settings.php?projectid=<?php echo $projectid; ?>">My Alerts</a></li>
        
      </ul>
    </div>
  </div>
</div>