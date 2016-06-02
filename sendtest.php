<?php
session_start();
require_once 'vendor/autoload.php';
include("include/access.php");




$client = new HelloSign\Client($apikey);

//$templateId = $previouslySavedTemplate->getId();
$templateId = 'a538286338e1a74af02d3374cd3e19a83ac84a8a';


$baseReq = new HelloSign\TemplateSignatureRequest();
$baseReq->setTemplateId($templateId);
$baseReq->setSigner('Signer', 'uri.weg@gmail.com', 'Uri');
$baseReq->setSigningRedirectUrl('http://www.interbuild.co/signing');
$baseReq->setRequestingRedirectUrl('http://www.interbuild.co/requesting');
$baseReq->setRequesterEmailAddress('coder@interbuild.co');
$baseReq->addMetadata('custom_id', '1234');



$request = new HelloSign\EmbeddedSignatureRequest($baseReq);
$request->setClientId($client_id);
$request->enableTestMode();
$request->setEmbeddedSigning();



//$response = $client->createUnclaimedDraftEmbeddedWithTemplate($request); 

echo "pizza4";

echo "<pre>";
var_dump($request);
echo "</pre>";



  ?>

  
    <?php

include("include/footer.php");

?>
	  
  <script>
    HelloSign.init('<?php echo $client_id; ?>');  
HelloSign.open({ skipDomainVerification: true,
url: 'EDIT_URL_RECEIVED_FROM_API_REQUEST' });
    
    </script>
    
    
    
