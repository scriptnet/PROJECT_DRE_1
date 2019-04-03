<?php
$captcha  = $_GET['cap'];

$secretKey = "6LdUnZsUAAAAANa-iigtQMeTnGKDSKJqY5-DY-MI";
$ip = $_SERVER['REMOTE_ADDR'];
// post request to server
$url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
$response = file_get_contents($url);
$responseKeys = json_decode($response,true);
// should return JSON with success as true
echo json_encode( $responseKeys );

  
?>