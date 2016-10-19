<?php
  $link = mysql_connect('linebot.faxthai.com', 'smartschool', 'smartschool456');
  if (!$link) {
    echo "Connected Failed";
  } else {
    echo "Connected successfully";
  }
?>
