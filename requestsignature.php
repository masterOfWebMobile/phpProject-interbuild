<?php  
include("include/access.php"); 
require_once 'vendor/autoload.php';
$attids = $_POST['attids'];
$emails = json_decode($_POST['emails']);
$names = json_decode($_POST['names']);
$orders = json_decode($_POST['orders']);
$filename = $_POST['filename'];
$fromdoc = $_POST['fromdoc'];
$reqemail = $_POST['useremail'];
//echo $_SERVER['DOCUMENT_ROOT']."/".$filename;

$client = new HelloSign\Client($apikey);
$request = new HelloSign\SignatureRequest;
$request->enableTestMode();
$request->setRequesterEmail($reqemail);
if($fromdoc != "1")
	$request->addFile($_SERVER['DOCUMENT_ROOT'].'/files/'.$filename);
else{
	$request->addFile($_SERVER['DOCUMENT_ROOT'].'/signed/'.$filename);
	if(substr($filename, -4,1) == ".")
		copy($_SERVER['DOCUMENT_ROOT'].'/signed/'.$filename, $_SERVER['DOCUMENT_ROOT'].'/files/'.substr($filename,0,-4)."_sign.pdf");
	else
		copy($_SERVER['DOCUMENT_ROOT'].'/signed/'.$filename, $_SERVER['DOCUMENT_ROOT'].'/files/'.substr($filename,0,-5)."_sign.pdf");
}
if($attids != ""){
	$query = "select * from `attachments` where id in ($attids)";
	$res = mysqli_query($cxn, $query);
	while($row = mysqli_fetch_assoc($res)){
		$request->addFile($_SERVER['DOCUMENT_ROOT'].'/'.$row['attpath']);
	}
}

if(count($emails) > 0){
	for($i=0;$i<3;$i++){
		if($emails[$i] != ""){
			//echo (intval($orders[$i]) - 1);
			//$request->addSigner($emails[$i], $names[$i], intval($orders[$i]) - 1);
			if($orders[0] != '' || $orders[1] != '' || $orders[2] != '')
			{
				
				$request->addSigner(new HelloSign\Signer(array(
				    'name' => $names[$i],
				    'email_address' => $emails[$i],
				    'order' => intval($orders[$i]) - 1
				)));
			}
			else {

				$request->addSigner(new HelloSign\Signer(array(
				    'name' => $names[$i],
				    'email_address' => $emails[$i]
				)));
			}
		}
	}
}

$draft_request = new HelloSign\UnclaimedDraft($request, $client_id);
$draft_request->setIsForEmbeddedSigning(true);
$response = $client->createUnclaimedDraft($draft_request);
$claim_url = $draft_request->getClaimUrl();
$cleanclaim = trim($claim_url);
echo $cleanclaim;
?>  
    
