<?php
require_once BASE_PATH . "/controllers/userController.php";

function handle_user_routes($url, $route_user)
{
  $method = $_SERVER['REQUEST_METHOD'];
  $route_parts = explode('/', $url);
  $route = $route_parts[0]; // use 0 for localhost
  $user_id = $route_user ?? null;

  if ($route === 'users') {
    if ($method == 'GET') {
      if ($route_user == 'pemilik') {
        get_pemilik_controller();
      } elseif ($route_user == 'admin') {
        get_admin_controller();
      } else if ($route_user == 'kasir') {
        get_kasir_controller();
      } else {
        get_all_users_controller();
      }
      get_all_users_controller();
    } elseif ($method == 'POST') {
      create_user_controller();
    } else {
      http_response_code(405);
      echo json_encode(["message" => "Method not allowed"]);
    }
  } elseif ($route === 'user') {
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
          echo json_encode(["message" => "Method not allowed"]);
          break;
      }
    } else {
      http_response_code(400);
      echo json_encode(["message" => "User ID not found"]);
    }
  } else {
    http_response_code(404);
    echo json_encode(["message" => "Route not found"]);
  }
}
?>