<?php
require_once BASE_PATH . "/controllers/productController.php";

function handle_product_routes($url, $route_product)
{
  $method = $_SERVER['REQUEST_METHOD'];
  $route_parts = explode('/', $url);
  $route = $route_parts[0]; // gunakan 0 untuk localhost
  $category = $route_product ?? null;
  $product_id = $route_product ?? null;

  if ($route === 'products') {
    if ($method == 'GET') {
      if ($category) {
        get_product_by_category_controller($category);
      }
      get_all_products_controller();
    } elseif ($method == 'POST') {
      create_product_controller();
    } else {
      http_response_code(405);
      echo json_encode(["message" => "Metode tidak diizinkan"]);
    }
  } elseif ($route === 'product') {
    if ($product_id) {
      switch ($method) {
        case 'GET':
          get_product_by_id_controller($product_id);
          break;
        case 'DELETE':
          delete_product_controller($product_id);
          break;
        case 'PUT':
          update_product_controller($product_id);
          break;
        default:
          http_response_code(405);
          echo json_encode(["message" => "Metode tidak diizinkan"]);
          break;
      }
    } else {
      http_response_code(400);
      echo json_encode(["debug_route" => $route, "message" => "Product ID tidak ditemukan"]);
    }
  }
}
?>