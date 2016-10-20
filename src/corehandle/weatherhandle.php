<?php
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

 ?>
