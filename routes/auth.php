<?php
require_once BASE_PATH . "/controllers/authController.php";

function handle_auth_routes($route)
{
  $method = $_SERVER['REQUEST_METHOD'];

  switch ($route) {
    case 'auth/login':
      if ($method == 'POST') {
        auth_login_controller();
      } else {
        http_response_code(405);
        echo json_encode(["message" => "Metode tidak diizinkan"]);
      }
      break;
    case 'auth/register':
      if ($method == 'POST') {
        auth_register_controller();
      } else {
        http_response_code(405);
        echo json_encode(["message" => "Metode tidak diizinkan"]);
      }
      break;
    default:
      http_response_code(404);
      echo json_encode(["message" => "Route not found"]);
      break;
  }
}
?>