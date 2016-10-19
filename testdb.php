<?php
  $servername = "202.29.80.78";
  $username = "root";
  $password = "maker@min@";

  // Create connection
  $conn = new mysql($servername, $username, $password);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  echo "Connected successfully";

?>
