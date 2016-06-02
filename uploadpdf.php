<?php
session_start();
include("include/access.php");
$project = $_SESSION['pid'];

$projectname = $_POST['projectname'];  
$doc_type = $_POST['doctype'];
$type = array("", "contractstatus", "contractchangeorder", "dailyobservations", "fdot");
$searchString = str_replace(" ", "", $projectname) . '_' . $type[$doc_type] . '_';

$docNumForPDF = 1;
$docNumForSign = 1;
$getdocumentquery="SELECT * FROM documents where folderid = $doc_type and projectid = {$_SESSION['pid']} and document_name like '%".$searchString."%' order by LENGTH(document_name) desc, document_name desc";
$getdocumentresult = mysqli_query($cxn,$getdocumentquery);
$getdocumentrow=mysqli_fetch_assoc($getdocumentresult);
if($getdocumentrow != null)
	extract($getdocumentrow);

if($document_name == '') {
	$docNumForPDF = 1;
  	//$docname = $projectname . "_" . $type[$doc_type] . "_1.pdf";
}
else
{
	$lastdocumentfirst_pos = strpos($document_name, '_');
	$lastdocumentsecond_pos = strpos($document_name, '_', $lastdocumentfirst_pos + 1);
	$lastdocumentnumber = substr($document_name, $lastdocumentsecond_pos + 1);
	$lastdocumentnumber = intval($lastdocumentnumber);
	$docNumForPDF = $lastdocumentnumber + 1;
	//$docname = $projectname . '_' . $type[$doc_type] . '_' . $lastdocumentnumber . '.pdf';
}
$getsigndocumentquery="SELECT * FROM pendingSig where doctype = $doc_type and projectid = {$_SESSION['pid']} and docname like '%".$searchString."%' order by LENGTH(docname) desc, docname desc";
$getsigndocumentresult = mysqli_query($cxn,$getsigndocumentquery);
$getsigndocumentrow=mysqli_fetch_assoc($getsigndocumentresult);
if($getsigndocumentrow != null)
	extract($getsigndocumentrow);

if($docname == '') {
	$docNumForSign = 1;
  	//$docname = $projectname . "_" . $type[$doc_type] . "_1.pdf";
}
else
{
	$lastdocumentfirst_pos = strpos($docname, '_');
	$lastdocumentsecond_pos = strpos($docname, '_', $lastdocumentfirst_pos + 1);
	$lastdocumentnumber = substr($docname, $lastdocumentsecond_pos + 1);
	$lastdocumentnumber = intval($lastdocumentnumber);
	$docNumForSign = $lastdocumentnumber + 1;
	//$docname = $projectname . '_' . $type[$doc_type] . '_' . $lastdocumentnumber . '.pdf';
}

if($docNumForPDF > $docNumForSign)
{
	$documentname = str_replace(" ", "", $projectname) . '_' . $type[$doc_type] . '_' . $docNumForPDF . '.pdf';
}
else {
	$documentname = str_replace(" ", "", $projectname) . '_' . $type[$doc_type] . '_' . $docNumForSign . '.pdf';
}
if(!empty($_POST['data'])){
$data = base64_decode($_POST['data']);
// print_r($data);
file_put_contents( "files/$documentname", $data );
echo $documentname;
} else {
echo "No Data Sent";
}
exit;
?>