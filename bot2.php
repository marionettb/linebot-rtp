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
function getuser_profile($a){
  $b=print_r($a,true);
  $text_ex = explode('=>', $b) ;
  $text_ex[2]=str_replace('}', NULL, $text_ex[2]);
  $text_ex[2]=str_replace('{', NULL, $text_ex[2]);
  $user_profle=explode(',', $text_ex[2]) ;
  $a=explode(':', $user_profle[0]) ;
  $a[1]=str_replace('"', NULL, $a[1]);
  $user_profle_data['displayName']=$a[1];
  $a=explode(':', $user_profle[1]) ;
  $a[1]=str_replace('"', NULL, $a[1]);
  $user_profle_data['userId']=$a[1];
  $a=explode(':', $user_profle[2]) ;
  $a[2]=str_replace('"', NULL, $a[2]);
  $a[2]=str_replace('//', NULL, $a[2]);
  $user_profle_data['pictureUrl']='http://'.$a[2];
  $a=explode(':', $user_profle[3]) ;
  $user_profle_data['statusMessage']=$a[1];
  return $user_profle_data;
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
$a=$bot->getProfile($to);
$user_profle=getuser_profile($a);
$displayName=$user_profle['displayName'];
$userId=$user_profle['userId'];
$pictureUrl=$user_profle['pictureUrl'];
$statusMessage=$user_profle['statusMessage'];

//bot handle
if ((strstr($text, 'สวัสดี') !== false)) {
  $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('สวัสดีครับ คุณ '.$displayName);
  $response = $bot->replyMessage($replyToken, $textMessageBuilder);
}

if ((strstr($text, 'วิดีโอ') !== false)) {
  $urlvideo = "https://www.mangoplug.com/modules/core/client/img/brand/doyoumind.mp4";
  $urlpic = "https://www.mangoplug.com/modules/core/client/img/brand/djkhaled.jpg";

  $post = json_encode($data);
  $videoMessageBuilder = new \LINE\LINEBot\MessageBuilder\VideoMessageBuilder($urlvideo, $urlpic);
  $response = $bot->replyMessage($replyToken, $videoMessageBuilder);
}
 ?>
