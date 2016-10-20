<?php
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;

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
 ?>
