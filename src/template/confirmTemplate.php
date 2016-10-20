<?php
  use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;
  use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;

  if ((strstr($text, 'เกีย') !== false)) {
      $response = $bot->replyMessage($replyToken, new TemplateMessageBuilder(
                          'ทดสอบความเกีย',
                          new ConfirmTemplateBuilder('คุณกลัวเมียหรือไม่?', [
                              new MessageTemplateActionBuilder('กลัว', '555555555555 อ่อน!'),
                              new MessageTemplateActionBuilder('ไม่กลัว', 'ใช่ป่าวววว!'),
                          ])
                      ));
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
 ?>
