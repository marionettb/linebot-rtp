<?php
  $link = mysql_connect('http://linebot.faxthai.com', 'smartschool', 'smartschool456');
  if (!$link) {
    die('connect failed: ' . mysql_error());
  }
  echo 'Connect succes';
  mysql_close($link);
?>
