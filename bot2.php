<?php
require "vendor/autoload.php";
//handle function
function objectToArray($d)
{
    if (is_object($d)) {
        $d = get_object_vars($d);
    }
    if (is_array($d)) {
        return array_map(__FUNCTION__, $d);
    } else {
        return $d;
    }
}
function getuser_profile($to){
  $response = $bot->getProfile($to);
  if ($response->isSucceeded()) {
      $profile = decode_json($response->getBody);
      $user_profle_data['displayName'] = 'test';
      // $user_profle_data['pictureUrl'] = $profile->{'pictureUrl'};
      // $user_profle_data['statusMessage'] = $profile->{'statusMessage'};
      return $user_profle_data;
  }
  //return $user_profle_data;
}

//init line bot
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('RuHhciFle36XBJXielhR22aO689nyDsFjrzG0mBBDMvlqTsIWxBJgAdBh5LiyedayUBGmHtd0q4bxYJDbmozMr609DXroXmOyKABrJuGzd9iLpbWcKazlbwlMOORJeAxdVcOYSu8yoaAGANJpSUdqQdB04t89/1O/w1cDnyilFU=');
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => '63029feed681ec683d321a94e98bfb8d']);

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
// $a=getUserProfile($to);
// $profile = json_decode($a);
// $name = $profile->{'displayName'};
$user_profle=getuser_profile($to);
$displayName=$user_profle['displayName'];
$userId=$user_profle['userId'];
$pictureUrl=$user_profle['pictureUrl'];
$statusMessage=$user_profle['statusMessage'];

//bot handle
if ((strstr($text, 'ทดสอบ') !== false)) {
  $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('ทดสอบบบบบ 6 Token and '.$displayName);
  $response = $bot->replyMessage($replyToken, $textMessageBuilder);
}
 ?>
