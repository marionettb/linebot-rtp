<?php
if ((strstr($text, 'วิดีโอ') !== false)) {
  $urlvideo = "https://linebot.faxthai.com/linebot-school/public/farewellballad.mp4";
  $urlpic = "https://linebot.faxthai.com/linebot-school/public/zakkwylde.jpg";

  $videoMessageBuilder = new \LINE\LINEBot\MessageBuilder\VideoMessageBuilder($urlvideo, $urlpic);
  $response = $bot->replyMessage($replyToken, $videoMessageBuilder);
}
 ?>
