<?php
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('od+PiQERR00IzMSuVMVb+hSYQk5J8QIbcq7+C/S9z16pNDJwgn24hZgCe1CPW/qJBpAeNhG/iodo0Og51WJ9GlhX3vuexXb5NyFCeAOtXfS/vF4Edo8uffYTWXbqbyOsaD3oe56qK6+1fGfw4E7wVQdB04t89/1O/w1cDnyilFU=');
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => 'd35578662d01550b89fdadc466fa1641']);
 ?>
