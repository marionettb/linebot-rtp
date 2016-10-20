<?php
require "vendor/autoload.php";
require "src/setting.php";
require "src/handle.php";
require "src/init.php";
require "src/template/confirmTemplate.php";
// foreach (glob("src/corehandle/*.php") as $core)
// {
//     require $core;
// }
//init Line dependencies
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

//bot handle area
if ((strstr($text, 'สวัสดี') !== false)) {
  $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('สวัสดีค่ะ '.$displayName);
  $response = $bot->replyMessage($replyToken, $textMessageBuilder);
  // $log->info("Got text message from $displayName: $text");
}

if ((strstr($text, 'อากาศ') !== false)) {
  $ch1 = curl_init();
  curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
  //.str_replace(' ', '%20', $text_ex[1]).' partials string in wunderground
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

// if ((strstr($text, 'เกีย') !== false)) {
//     $response = $bot->replyMessage($replyToken, new TemplateMessageBuilder(
//                         'ทดสอบความเกีย',
//                         new ConfirmTemplateBuilder('คุณกลัวเมียหรือไม่?', [
//                             new MessageTemplateActionBuilder('กลัว', '555555555555 อ่อน!'),
//                             new MessageTemplateActionBuilder('ไม่กลัว', 'ใช่ป่าวววว!'),
//                         ])
//                     ));
// }
//
// if ((strstr($text, 'Confirm') !== false)) {
//     $response = $bot->replyMessage($replyToken, new TemplateMessageBuilder(
//                         'Confirm alt text',
//                         new ConfirmTemplateBuilder('Do it?', [
//                             new MessageTemplateActionBuilder('Yes', 'Yes!'),
//                             new MessageTemplateActionBuilder('No', 'No!'),
//                         ])
//                     ));
// }

if ((strstr($text, 'psru') !== false) || (strstr($text, 'Psru') !== false)) {
  $imageUrl = 'https://linebot.faxthai.com/linebot-school/public/psru.jpg';
                $buttonTemplateBuilder = new ButtonTemplateBuilder(
                    'PSRU Contact',
                    'Hello Student',
                    $imageUrl,
                    [
                        new UriTemplateActionBuilder('ตรวจสอบความปลอดภัย', 'http://thahinc.psru.ac.th'),
                        new UriTemplateActionBuilder('เว็ปไซต์มหาวิทยาลัย', 'http://psru.ac.th'),
                        //new PostbackTemplateActionBuilder('Buy', 'action=buy&itemid=123'),
                        //new PostbackTemplateActionBuilder('Add to cart', 'action=add&itemid=123'),
                        new MessageTemplateActionBuilder('Say message', 'hello hello'),
                    ]
                );
                $templateMessage = new TemplateMessageBuilder('PSRU contact', $buttonTemplateBuilder);
                $response = $bot->replyMessage($replyToken, $templateMessage);
}

if ((strstr($text, 'Carousel') !== false)) {
  $imageUrl = 'https://linebot.faxthai.com/linebot-school/public/00.jpg';
  $imageUrl2 = 'https://linebot.faxthai.com/linebot-school/public/zakkwylde.jpg';
                $carouselTemplateBuilder = new CarouselTemplateBuilder([
                    new CarouselColumnTemplateBuilder('foo', 'bar', $imageUrl, [
                        new UriTemplateActionBuilder('Go to line.me', 'https://line.me'),
                        new PostbackTemplateActionBuilder('Buy', 'action=buy&itemid=123'),
                    ]),
                    new CarouselColumnTemplateBuilder('buz', 'qux', $imageUrl2, [
                        new PostbackTemplateActionBuilder('Add to cart', 'action=add&itemid=123'),
                        new MessageTemplateActionBuilder('Say message', 'hello hello'),
                    ]),
                ]);
                $templateMessage = new TemplateMessageBuilder('Button alt text', $carouselTemplateBuilder);
                $response = $bot->replyMessage($replyToken, $templateMessage);
}

if ((strstr($text, 'ค้นหา') !== false)) {
  $text_ex = explode('@', $text);
  if($text_ex[0] == "ค้นหา"){
      $ch1 = curl_init();
      curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch1, CURLOPT_URL, 'https://th.wikipedia.org/w/api.php?format=json&action=query&prop=extracts&exintro=&explaintext=&titles='.$text_ex[1]);
      $result1 = curl_exec($ch1);
      curl_close($ch1);

      $obj = json_decode($result1, true);

      foreach($obj['query']['pages'] as $key => $val){

          $result_text = $val['extract'];
      }

      if(empty($result_text)){
          $ch1 = curl_init();
          curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
          curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch1, CURLOPT_URL, 'https://en.wikipedia.org/w/api.php?format=json&action=query&prop=extracts&exintro=&explaintext=&titles='.$text_ex[1]);
          $result1 = curl_exec($ch1);
          curl_close($ch1);

          $obj = json_decode($result1, true);

          foreach($obj['query']['pages'] as $key => $val){

              $result_text = $val['extract'];
          }
      }
      if(empty($result_text)){//หาจาก en ไม่พบก็บอกว่า ไม่พบข้อมูล ตอบกลับไป
          $result_text = 'ไม่พบข้อมูล';
      }
      $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($result_text);
      $response = $bot->replyMessage($replyToken, $textMessageBuilder);
  }
}
 ?>
