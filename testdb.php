<?php
  $servername = "http://linebot.faxthai.com";
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
