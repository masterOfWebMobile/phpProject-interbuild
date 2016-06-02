<?php
session_start();
include("include/access.php");

$notquery = "Select * from pendingSig where emails like '%".$_SESSION['useremail']."%'";
$notres = mysqli_query($cxn, $notquery);
$notnum = mysqli_num_rows($notres);
echo $notnum;
?>