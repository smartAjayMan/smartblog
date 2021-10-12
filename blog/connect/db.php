<?php

  $localhost = "localhost";
  $user = "root";
  $password = "";
  $database = "smartblog";

  $conn = new mysqli($localhost, $user, $password, $database);
  if ($conn->connect_error) {
      die("Database Error:".$conn->connect_error);
      exit();
  }

?>