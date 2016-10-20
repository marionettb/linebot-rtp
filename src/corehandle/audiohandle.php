<?php
if ((strstr($text, 'เพลง') !== false)) {
  $urlaud = "https://linebot.faxthai.com/linebot-school/public/farewellballad.m4a";

  $audioMessageBuilder = new \LINE\LINEBot\MessageBuilder\AudioMessageBuilder($urlaud, 97000);
  $response = $bot->replyMessage($replyToken, $audioMessageBuilder);
}
 ?>
