<?php
require_once BASE_PATH . "/controllers/authController.php";

function handle_auth_routes($route, $route_auth)
{
  $method = $_SERVER['REQUEST_METHOD'];

  switch ($route. "/" .$route_auth) {
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
    case 'auth/personal-data':
      if ($method == 'PUT') {
        kasir_personal_data_controller();
      } else {
        http_response_code(405);
        echo json_encode(["message" => "Metode tidak diizinkan"]);
      }
    default:
      http_response_code(404);
      echo json_encode(["message" => "Route not found"]);
      break;
  }
}
?>