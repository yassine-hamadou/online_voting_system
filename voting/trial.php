<?php


// Required libraries
require_once 'vendor/autoload.php';


// Your API key and secret
$apiKey = '45041c34';
$apiSecret = 'oCln2QBNxcvDP0af';

// Use the client to send an SMS message
$basic  = new \Nexmo\Client\Credentials\Basic($apiKey, $apiSecret);
$client = new \Nexmo\Client($basic);

$message = $client->message()->send([
    'to' => '+233244000000',
    'from' => '+14157386102',
    'text' => 'Hello, world!'
]);

