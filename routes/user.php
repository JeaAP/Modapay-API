<?php
require_once BASE_PATH . "/controllers/userController.php";

function handle_user_routes($url)
{
  $method = $_SERVER['REQUEST_METHOD'];
  $route_parts = explode('/', $url);
  $route = $route_parts[3]; // gunakan 0 untuk localhost
  $user_id = $route_parts[4] ?? null; // gunakan 1 untuk localhost


  if ($route === 'users') {
    if ($method == 'GET') {
      get_all_users_controller();
    } elseif ($method == 'POST') {
      create_user_controller();
    } else {
      http_response_code(405);
      echo json_encode(["message" => "Metode tidak diizinkan"]);
    }
  } elseif ($route === 'user') {
    // $user_id = $_GET['user_id'] ?? null;

    if ($user_id) {
      switch ($method) {
        case 'GET':
          get_user_by_id_controller($user_id);
          break;
        case 'DELETE':
          delete_user_controller($user_id);
          break;
        case 'PUT':
          update_user_controller($user_id);
          break;
        default:
          http_response_code(405);
          echo json_encode(["message" => "Metode tidak diizinkan"]);
          break;
      }
    } else {
      http_response_code(400);
      echo json_encode(["message" => "User ID is required"]);
    }
  } else {
    http_response_code(404);
    echo json_encode(["debug_route" => $route, "message" => "Route not found"]);
  }
}
?>