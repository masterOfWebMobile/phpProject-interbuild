<?php
session_start(); 

if(isset($_SESSION['userid']))
{ 
	header("Location:index.php");
}
include("include/notloginheader.php");
?>


<div id="main" class=" container-fluid nopadding">
  
<?php if((isset($_SESSION['error'])))
        {
          echo "
          <div class='alert alert-danger alert-dismissable'>
          <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
          <strong>Oops!</strong> "; echo $_SESSION['error']; echo "
          </div>
          ";
          $_SESSION['error']=NULL;
           
        }
?>

<br>
<div class="row">
<form role="form" class="col-md-8 col-md-offset-2" action="isauser.php" method='post'>
  <div class="form-group">
    <label>Email address</label>
    <input name="email" type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" required>
  </div>
  <div class="form-group">
    <label>Password</label>
    <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
  </div>
  <button type="submit" class="btn btn-primary btn-lg">Log In</button>
</form>
</div>

<br>
<center>
<a href='requestpassword.php'>Forget your password?</a>
</center>

</div>
<?php

include("include/footer.php");

?>



