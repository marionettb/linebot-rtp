<?php
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
