<?php
//get input
$json_string = file_get_contents('php://input');
$jsonObj = json_decode($json_string);
$json_string2=objectToArray($jsonObj);
$array = json_decode(json_encode($json_string2), True);

//init reply data
$to =  $array['events'][0]['source']['userId'];
$text = $array['events'][0]['message']['text'];
$replyToken = $array['events'][0]['replyToken'];
$text=str_replace('  ', ' ', $text);
$text=str_replace("\r", NULL, $text);
$text=str_replace("\n", NULL, $text);

//init user Data
$a=$bot->getProfile($to);
$user_profle=getuser_profile($a);
$displayName=$user_profle['displayName'];
$userId=$user_profle['userId'];
$pictureUrl=$user_profle['pictureUrl'];
$statusMessage=$user_profle['statusMessage'];
 ?>
