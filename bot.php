<?php
require "vendor/autoload.php";
require "src/init.php";
require "src/handle.php";

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('RuHhciFle36XBJXielhR22aO689nyDsFjrzG0mBBDMvlqTsIWxBJgAdBh5LiyedayUBGmHtd0q4bxYJDbmozMr609DXroXmOyKABrJuGzd9iLpbWcKazlbwlMOORJeAxdVcOYSu8yoaAGANJpSUdqQdB04t89/1O/w1cDnyilFU=');
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => '63029feed681ec683d321a94e98bfb8d']);
 ?>
