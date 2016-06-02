<?php
session_start(); 

if(isset($_SESSION['userid']))
{ 
	header("Location:index.php");
}
include("include/notloginheader.php");
?>


<div id="main" class=" container-fluid nopadding">

<br>
<div class="row">
<form role="form" class="col-md-8 col-md-offset-2" action="forgotpassword.php" method='post'>
  <div class="form-group">
    <label>Email address</label>
    <input name="email" type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" required>
  </div>
  <button type="submit" class="btn btn-primary btn-lg">Reset Password</button>
</form>
</div>

</div>
<?php

include("include/footer.php");

?>



