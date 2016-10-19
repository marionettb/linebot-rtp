<?php
  $link = mysql_connect('107.167.89.104', 'smartschool', 'smartschool456');
  if (!$link) {
    die('connect failed: ' . mysql_error());
}
echo 'Connect succes';
mysql_close($link);
?>
