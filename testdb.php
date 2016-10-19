<?php
  echo "test rtp";
  // $link = mysql_connect('https://linebot.faxthai.com', 'smartschool', 'smartschool456');
  // if (!$link) {
  //   die('connect failed: ' . mysql_error());
  // }
  // echo 'Connect succes';
  // mysql_close($link);
  $servername = "https://linebot.faxthai.com";
  $username = "smartschool";
  $password = "smartschool456";

  // Create connection
  $conn = new mysqli($servername, $username, $password);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  echo "Connected successfully";
?>
