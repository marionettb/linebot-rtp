<?php
  $link = mysql_connect('202.29.80.78', 'root', 'maker@min@');
  if (!$link) {
    die('connect failed: ' . mysql_error());
  }
  echo 'Connect succes';
  mysql_close($link);
?>
