<?php
function objectToArray($d)
{
    if (is_object($d)) {
        $d = get_object_vars($d);
    }
    if (is_array($d)) {
        return array_map(__FUNCTION__, $d);
    } else {
        return $d;
    }
}
//init line bot
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('RuHhciFle36XBJXielhR22aO689nyDsFjrzG0mBBDMvlqTsIWxBJgAdBh5LiyedayUBGmHtd0q4bxYJDbmozMr609DXroXmOyKABrJuGzd9iLpbWcKazlbwlMOORJeAxdVcOYSu8yoaAGANJpSUdqQdB04t89/1O/w1cDnyilFU=');
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => 'f241bea6d6db5d7778ad06a7fff1d00b']);

//get input
$json_string = file_get_contents('php://input');
$jsonObj = json_decode($json_string);
$json_string2=objectToArray($jsonObj);
$array = json_decode(json_encode($json_string2), True);

//
$to =  $array['events'][0]['source']['userId'];
$text = $array['events'][0]['message']['text'];
$replyToken = $array['events'][0]['replyToken'];
$text=str_replace('  ', ' ', $text);
$text=str_replace("\r", NULL, $text);
$text=str_replace("\n", NULL, $text);
 ?>
