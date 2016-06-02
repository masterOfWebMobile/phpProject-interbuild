<?php
session_start();

 if((isset($_SESSION['error'])))
        {
          echo "
          <div class='row'>
            <div class='alert alert-danger alert-dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <strong>Oops!</strong> "; echo $_SESSION['error']; echo "
            </div>
          </div>
          ";
          $_SESSION['error']=NULL;
           
        }
 if((isset($_SESSION['success'])))
        {
          echo "
          <div class='row'>
            <div class='alert alert-success alert-dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <strong>Updated!</strong> "; echo $_SESSION['success']; echo "
            </div>
          </div>
          ";
          $_SESSION['success']=NULL;
           
        }
             

?>