<?php
// parameters
$hubVerifyToken = 'TOKEN123456abcd';
$accessToken = "EAAbjcuvajRYBAKc0O857d7sBYqjFc18uZBlCaBP2LK3YGZCuueQAG6DHC66AMQi534qC3ZADgZBWLTZCGOMISZAYRBu2cQ6g6wcB7S6WYTESbWSGoRkY4Wts0N0f4z19nx28jWwFaYWBMZBeXKgQUrr249BgVtIao4RsP4AE1a5EQZDZD";

// check token at setup
if ($_REQUEST['hub_verify_token'] === $hubVerifyToken) {
  echo $_REQUEST['hub_challenge'];
  exit;
}

// handle bot's anwser
$input = json_decode(file_get_contents('php://input'), true);

$senderId = $input['entry'][0]['messaging'][0]['sender']['id'];
$messageText = $input['entry'][0]['messaging'][0]['message']['text'];


$answer = "I don't understand. Ask me 'hi'.";
if($messageText == "hi") {
    $answer = "Hello";
}

$response = [
    'recipient' => [ 'id' => $senderId ],
    'message' => [ 'text' => $answer ]
];
$ch = curl_init('https://graph.facebook.com/v2.6/me/messages?access_token='.$accessToken);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_exec($ch);
curl_close($ch);

//based on http://stackoverflow.com/questions/36803518
