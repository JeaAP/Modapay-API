<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
define('BASE_PATH', __DIR__ );

header("Content-Type: application/json");
require_once "config/database.php";
require_once "routes/api.php";
?>