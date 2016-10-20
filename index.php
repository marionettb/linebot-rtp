<?php
  require "vendor/autoload.php";
  require "src/setting.php";
  require "src/handle.php";
  require "src/init.php";
  foreach (glob("corehandle/*.php") as $filename)
  {
      require $filename;
  }
  foreach (glob("template/*.php") as $template)
  {
      require $template;
  }
  //init Line dependencies
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

 ?>
