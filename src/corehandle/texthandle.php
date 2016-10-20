<?php
if ((strstr($text, 'สวัสดี') !== false)) {
  $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('สวัสดีค่ะ '.$displayName);
  $response = $bot->replyMessage($replyToken, $textMessageBuilder);
}
 ?>
