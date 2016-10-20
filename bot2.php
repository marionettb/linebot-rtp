<?php
require "vendor/autoload.php";
//init dependencies
use LINE\LINEBot;
use LINE\LINEBot\ImagemapActionBuilder\AreaBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use LINE\LINEBot\Event\MessageEvent\TextMessage;
use LINE\LINEBot\KitchenSink\EventHandler;
use LINE\LINEBot\KitchenSink\EventHandler\MessageHandler\Util\UrlBuilder;
use LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder;
use LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;

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

if ((strstr($text, 'อากาศ') !== false)) {
  $ch1 = curl_init();
    curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch1, CURLOPT_URL, 'http://api.wunderground.com/api/cf7dc205e34e58be/forecast/lang:TH/q/Thailand/%E0%B8%81%E0%B8%A3%E0%B8%B8%E0%B8%87%E0%B9%80%E0%B8%97%E0%B8%9E%E0%B8%A1%E0%B8%AB%E0%B8%B2%E0%B8%99%E0%B8%84%E0%B8%A3.json');
    $result1 = curl_exec($ch1);
    curl_close($ch1);

    $obj = json_decode($result1, true);
    if(isset($obj['forecast']['txt_forecast']['forecastday'][0]['fcttext_metric'])){
        $result_text = $obj['forecast']['txt_forecast']['forecastday'][0]['fcttext_metric'];
    }else{
        $result_text = 'ไม่พบข้อมูล';
    }
  $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($result_text);
  $response = $bot->replyMessage($replyToken, $textMessageBuilder);
}

if ((strstr($text, 'วิดีโอ') !== false)) {
  $urlvideo = "https://linebot.faxthai.com/linebot-school/public/farewellballad.mp4";
  $urlpic = "https://linebot.faxthai.com/linebot-school/public/zakkwylde.jpg";

  $videoMessageBuilder = new \LINE\LINEBot\MessageBuilder\VideoMessageBuilder($urlvideo, $urlpic);
  $response = $bot->replyMessage($replyToken, $videoMessageBuilder);
}

if ((strstr($text, 'รูป') !== false)) {
  $urlpic = "https://linebot.faxthai.com/linebot-school/public/zakkwylde.jpg";

  $picMessageBuilder = new \LINE\LINEBot\MessageBuilder\ImageMessageBuilder($urlpic, $urlpic);
  $response = $bot->replyMessage($replyToken, $picMessageBuilder);
}

if ((strstr($text, 'เพลง') !== false)) {
  $urlaud = "https://linebot.faxthai.com/linebot-school/public/farewellballad.m4a";

  $audioMessageBuilder = new \LINE\LINEBot\MessageBuilder\AudioMessageBuilder($urlaud, 97000);
  $response = $bot->replyMessage($replyToken, $audioMessageBuilder);
}

if ((strstr($text, 'Confirm') !== false)) {
    $response = $bot->replyMessage($replyToken, new TemplateMessageBuilder(
                        'Confirm alt text',
                        new ConfirmTemplateBuilder('Do it?', [
                            new MessageTemplateActionBuilder('Yes', 'Yes!'),
                            new MessageTemplateActionBuilder('No', 'No!'),
                        ])
                    ));
}

if ((strstr($text, 'Button') !== false)) {
  $imageUrl = 'http://linebot.faxthai.com/linebot-school/public/00.png';
                $buttonTemplateBuilder = new ButtonTemplateBuilder(
                    'My button sample',
                    'Hello my button',
                    $imageUrl,
                    [
                        new UriTemplateActionBuilder('Go to line.me', 'https://line.me'),
                        new PostbackTemplateActionBuilder('Buy', 'action=buy&itemid=123'),
                        new PostbackTemplateActionBuilder('Add to cart', 'action=add&itemid=123'),
                        new MessageTemplateActionBuilder('Say message', 'hello hello'),
                    ]
                );
                $templateMessage = new TemplateMessageBuilder('Button alt text', $buttonTemplateBuilder);
                $response = $bot->replyMessage($replyToken, $templateMessage);
}
 ?>
