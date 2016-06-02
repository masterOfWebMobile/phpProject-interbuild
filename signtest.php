<?php
session_start();
require_once 'vendor/autoload.php';
include("include/access.php");

$client = new HelloSign\Client($apikey);
$signature_request_id = '1bc3b2b1650d9ae6a5d3fa4ecbe7b552141713b8';
$response = $client->getSignatureRequest($signature_request_id);

echo "<pre>";
var_dump($response);
echo "</pre>";

if ($response->isComplete()) {
    echo 'All signers have signed this request.';
} else {
    foreach ($response->getSignatures() as $signature) {
        echo $signature->getStatusCode() . "\n";
    }
}

?>
    
    
    
