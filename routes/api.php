<?php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$route = trim(str_replace(BASE_URL_PATH, '', $path), '/');

if (isset($_GET['route'])) {
  $route_query = $_GET['route'];
}

$route_parts = explode('/', $route);
$route = $route_parts[0] ?? "null"; // gunakan 0 untuk localhost

if (strpos($route, 'auth') === 0) {
  require_once __DIR__ . "/auth.php"; // Route ke Auth API
  $route_auth = $route_parts[4] ?? "null"; // gunakan 1 untuk localhost
  handle_auth_routes($route, $route_auth);
  exit;
} else if (strpos($route, 'users') === 0 || strpos($route, 'user') === 0) {
  require_once __DIR__ . "/user.php"; // Route ke User API
  $route_user = $route_parts[1] ?? "null"; // gunakan 1 untuk localhost
  handle_user_routes($route, $route_user);
} else if (strpos($route, 'products') === 0 || strpos($route, 'product') === 0) {
  require_once __DIR__ . "/product.php"; // Route ke Product API
  $route_product = $route_parts[1] ?? "null"; // gunakan 1 untuk localhost
  handle_product_routes($route, $route_product);
} else if (strpos($route, 'discounts') === 0 || strpos($route, 'discount') === 0) {
  require_once __DIR__ . "/discount.php"; // Route ke Discount API
  $route_discount = $route_parts[1] ?? "null"; // gunakan 1 untuk localhost
  handle_discount_routes($route, $route_discount);
} else {
  http_response_code(404);
  echo json_encode(["debug_route" => $route, "count" => count($route_parts), "message" => "Route not found"]);
  exit;
}
?>