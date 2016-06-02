<?php
session_start();
include("include/access.php"); 
require_once 'vendor/autoload.php';
$req = $_POST['reqid'];
$client = new HelloSign\Client($apikey);
$client->cancelSignatureRequest($req);
$query = "delete from pendingSig where requestid='{$req}'";
mysqli_query($cxn, $query);
echo $query;
?>