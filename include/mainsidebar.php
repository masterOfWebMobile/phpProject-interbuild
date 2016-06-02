<div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <?php if ($_SESSION['superadmin'] == 1) {
            echo '<li><a href="newproject.php">+ New Project</a></li>';
            } ?>
            <li id='activeprojects'><a href="index.php">Active Projects</a></li>
            <li id='completedprojects'><a href="completedprojects.php">Completed Projects</a></li>
          </ul>
        </div>
