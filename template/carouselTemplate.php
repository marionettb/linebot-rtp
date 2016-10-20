<?php
if ((strstr($text, 'Carousel') !== false)) {
  $imageUrl = 'https://linebot.faxthai.com/linebot-school/public/00.jpg';
  $imageUrl2 = 'https://linebot.faxthai.com/linebot-school/public/zakkwylde.jpg';
                $carouselTemplateBuilder = new CarouselTemplateBuilder([
                    new CarouselColumnTemplateBuilder('foo', 'bar', $imageUrl, [
                        new UriTemplateActionBuilder('Go to line.me', 'https://line.me'),
                        new PostbackTemplateActionBuilder('Buy', 'action=buy&itemid=123'),
                    ]),
                    new CarouselColumnTemplateBuilder('buz', 'qux', $imageUrl2, [
                        new PostbackTemplateActionBuilder('Add to cart', 'action=add&itemid=123'),
                        new MessageTemplateActionBuilder('Say message', 'hello hello'),
                    ]),
                ]);
                $templateMessage = new TemplateMessageBuilder('Button alt text', $carouselTemplateBuilder);
                $response = $bot->replyMessage($replyToken, $templateMessage);
}
 ?>
