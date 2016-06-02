<?php
 if((isset($_SESSION['success'])) && ($_SESSION['project_action'] == 'new'))
   {
    echo "
    
      <div class='alert message_box'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h1>Congratulations!</h1> <h3>You have created Project "; echo $_SESSION['success']; echo ".<br>
        If you would like to invite additional users to collaberate please visit our <a href='groups.php?projectid=".$projectid."'>\"Users and Groups\"</a> page.</h3>
        <br>
        <button type='button' class='btn btn-primary pull-right' data-dismiss='alert' aria-hidden='true'>OK</button>
      </div>
    
    ";
    $_SESSION['success']=NULL;
     
   }

   if((isset($_SESSION['success'])) && ($_SESSION['project_action'] == 'update'))
   {
    echo "
    
      <div class='alert message_box'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h1>Congratulations!</h1> <h3>You have updated Project "; echo $_SESSION['success']; echo ".<br>
        If you would like to invite additional users to collaberate please visit our <a href='groups.php?projectid=".$projectid."'>\"Users and Groups\"</a> page.</h3>
        <br>
        <button type='button' class='btn btn-primary pull-right' data-dismiss='alert' aria-hidden='true'>OK</button>
      </div>
    
    ";
    $_SESSION['success']=NULL;
     
   }

   if((isset($_SESSION['success'])) && ($_SESSION['project_action'] == 'group'))
   {
    echo "
    
      <div class='alert message_box'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h1>Congratulations!</h1> <h3>"; echo $_SESSION['success']; echo ".<br>
        <button type='button' class='btn btn-primary pull-right' data-dismiss='alert' aria-hidden='true'>OK</button>
      </div>
    
    ";
    $_SESSION['success']=NULL;
     
   }

   if((isset($_SESSION['success'])) && ($_SESSION['project_action'] == 'user'))
   {
    echo "
    
      <div class='alert message_box'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h3>"; echo $_SESSION['success']; echo ".<br>
        <button type='button' class='btn btn-primary pull-right' data-dismiss='alert' aria-hidden='true'>OK</button>
      </div>
    
    ";
    $_SESSION['success']=NULL;
     
   }
?>

