<?php
if ((strstr($text, 'รูป') !== false)) {
  $urlpic = "https://linebot.faxthai.com/linebot-school/public/zakkwylde.jpg";

  $picMessageBuilder = new \LINE\LINEBot\MessageBuilder\ImageMessageBuilder($urlpic, $urlpic);
  $response = $bot->replyMessage($replyToken, $picMessageBuilder);
}
 ?>
