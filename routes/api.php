<?php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$route = trim(str_replace(BASE_URL_PATH, '', $path), '/');

if (isset($_GET['route'])) {
  $route_query = $_GET['route'];
}

$route_parts = explode('/', $route);
$route = $route_parts[0] ?? null; // gunakan 0 untuk localhost ||| 3
$second_route = $route_parts[1] ?? null; // gunakan 1 untuk localhost ||| 4

if (strpos($route, 'auth') === 0) {
  require_once __DIR__ . "/auth.php"; // Route ke Auth API
  handle_auth_routes($route, $second_route);
  exit;
} else if (strpos($route, 'users') === 0 || strpos($route, 'user') === 0) {
  require_once __DIR__ . "/user.php"; // Route ke User API
  handle_user_routes($route, $second_route);
} else if (strpos($route, 'products') === 0 || strpos($route, 'product') === 0) {
  require_once __DIR__ . "/product.php"; // Route ke Product API
  handle_product_routes($route, $second_route);
} else if (strpos($route, 'discounts') === 0 || strpos($route, 'discount') === 0) {
  require_once __DIR__ . "/discount.php"; // Route ke Discount API
  handle_discount_routes($route, $second_route);
} else if (strpos($route, 'transactions') === 0 || strpos($route, 'transaction') === 0) {
  require_once __DIR__ . "/transaction.php"; // Route ke Transaction API
  handle_transaction_routes($route, $second_route);
} else if (strpos($route, 'restocks') === 0 || strpos($route, 'restock') === 0) {
  require_once __DIR__ . "/restock.php"; // Route ke Restock API
  handle_restock_routes($route, $second_route);
}
else {
  http_response_code(404);
  echo json_encode(["debug_route" => $route, "count" => count($route_parts), "message" => "Route not found"]);
  exit;
}
?>