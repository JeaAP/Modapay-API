<?php
require_once BASE_PATH . "/controllers/discountController.php";

function handle_discount_routes($url, $route_discount)
{
  $method = $_SERVER['REQUEST_METHOD'];
  $route_parts = explode('/', $url);
  $route = $route_parts[0]; // gunakan 0 untuk localhost
  $discount_id = $route_discount ?? null;

  if ($route === 'discounts') {
    if ($method == 'GET') {
      get_all_discounts_controller();
    } elseif ($method == 'POST') {
      create_discount_controller();
    } else {
      http_response_code(405);
      echo json_encode(["message" => "Metode tidak diizinkan"]);
    }
  } elseif ($route === 'discount') {

    if ($discount_id) {
      switch ($method) {
        case 'GET':
          get_discount_by_id_controller($discount_id);
          break;
        case 'DELETE':
          delete_discount_controller($discount_id);
          break;
        case 'PUT':
          update_discount_controller($discount_id);
          break;
        default:
          http_response_code(405);
          echo json_encode(["message" => "Metode tidak diizinkan"]);
          break;
      }
    } else {
      http_response_code(400);
      echo json_encode(["debug_route" => $route, "message" => "Discount ID tidak ditemukan"]);
    }
  }
}
?>