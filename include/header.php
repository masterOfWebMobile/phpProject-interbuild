<?php
session_start();
include("include/access.php");
date_default_timezone_set('US/Eastern');
$userid = $_SESSION['userid'];

$userquery = "SELECT * FROM users WHERE user_id = $userid";
$userresult = mysqli_query($cxn,$userquery);
$userrow = mysqli_fetch_assoc($userresult);
if($userrow != null)
extract($userrow);

$notquery = "Select * from pendingSig where emails like '%".$_SESSION['useremail']."%'";
$notres = mysqli_query($cxn, $notquery);
$notnum = mysqli_num_rows($notres);
?>
<DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="shortcut icon" href="/favicon.ico">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
    <script src="js/tinysort.min.js"></script>
    <script type="text/javascript" src="//s3.amazonaws.com/cdn.hellofax.com/js/embedded.js"></script>
    <script src="js/jquery.placepicker.js"></script>
    <script src="js/file-tree.min.js"></script> 
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?language=en&libraries=places"></script>
    <script src="js/jquery.mjs.nestedSortable.js"></script>
    <script src="js/bootstrap-datepicker.min.js"></script>
    
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jspdf.min.js"></script>
    <script src="js/html2canvas.min.js"></script>
    <script src="js/html2canvas.svg.min.js"></script>
    <script src="js/moment.js"></script>
    <script src="js/numonly.min.js"></script>
    <script src="js/custom.js"></script>


        
    <title>Interbuild</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <link href="css/file-tree.min.css" rel="stylesheet">
 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>


    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
  </head>

  <body>
    <div id="loading">
      <img id="loading-image" src="images/loading.gif" alt="Loading..." />
    </div>
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php"><img src="/images/interbuild-logo.png" style="height:20px"/></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          
          <ul class="nav navbar-nav navbar-right">
            
            <li id="dashboard_page"><a href="index.php" >Projects</a></li>
            
            <li id="notifications"><a href="notifications.php">Notifications <?php if($notnum>0) { ?><span class="badge" id="not_Count"><?php echo $notnum;?></span><?php } ?></a></li>
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $user_email; ?><span class="caret"></span></a>
              
              <ul class="dropdown-menu">
                <li><a href="myaccount.php">My Account</a></li>
                <li><a href="logout.php">Log Out</a></li>
              </ul>
            </li>
          
          </ul>
        
        </div>
      </div>
    </nav>