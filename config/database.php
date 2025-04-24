<?php
require_once "config.php";

function getConnection()
{
  $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $conn->set_charset("utf8");

  return $conn;
}
?>