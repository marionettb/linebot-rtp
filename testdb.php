<?php
  $servername = "107.167.89.104";
  $username = "smartschool";
  $password = "smartschool456";

  // Create connection
  $conn = new mysql($servername, $username, $password);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  echo "Connected successfully";

?>
