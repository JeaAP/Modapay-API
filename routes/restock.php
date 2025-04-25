<?php
require_once BASE_PATH . "/controllers/restockController.php";

function handle_restock_routes($url, $route_restock)
{
  $method = $_SERVER['REQUEST_METHOD'];
  $route_parts = explode('/', $url);
  $route = $route_parts[0]; // Use 0 for localhost
  $restock_id = $route_restock ?? null;

  if ($route === 'restocks') {
    if ($method == 'GET') {
      if ($route_restock) {
        get_restock_by_status_controller($route_restock);
      }
      get_all_restocks_controller();
    } elseif ($method == 'POST') {
      create_restock_controller();
    } else {
      http_response_code(405);
      echo json_encode(["message" => "Metode tidak diizinkan"]);
    }
  } elseif ($route === 'restock') {
    if ($restock_id) {
      switch ($method) {
        case 'GET':
          get_restock_by_id_controller($restock_id);
          break;
        case 'DELETE':
          delete_restock_controller($restock_id);
          break;
        case 'PUT':
          update_restock_status_controller($restock_id);
          break;
        default:
          http_response_code(405);
          echo json_encode(["message" => "Metode tidak diizinkan"]);
          break;
      }
    } else {
      http_response_code(400);
      echo json_encode(["debug_route" => $route, "message" => "Restock ID tidak ditemukan"]);
    }
  }
}
?>