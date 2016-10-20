<?php
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
