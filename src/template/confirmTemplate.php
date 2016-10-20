<?php
  if ((strstr($text, 'เกีย') !== false)) {
      $response = $bot->replyMessage($replyToken, new TemplateMessageBuilder(
                          'ทดสอบความเกีย',
                          new ConfirmTemplateBuilder('คุณกลัวเมียหรือไม่?', [
                              new MessageTemplateActionBuilder('กลัว', '555555555555 อ่อน!'),
                              new MessageTemplateActionBuilder('ไม่กลัว', 'ใช่ป่าวววว!'),
                          ])
                      ));
  }
?>
