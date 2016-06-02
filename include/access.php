<?php
error_reporting(E_ERROR | E_PARSE);
$apikey = 'a4aecd0884f88a5c66bc0c8dae87e5049f81c68cb8c5d0ef3ad89d6681d4d819';
$client_id = '3c822ee48c6bf4865212a8dc8a0b2b53';
$host="localhost";
$user="root";
$passwd=null;
$dbname="intevxyy_interbuild";
$cxn= mysqli_connect($host,$user,$passwd,$dbname) or die ("Couldn't connect");
date_default_timezone_set('UTC');
define('CONST_SERVER_DATEFORMAT', 'YmdHis');
  
?>