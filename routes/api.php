<?php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$route = trim(str_replace(BASE_URL_PATH, '', $path), '/');

if (isset($_GET['route'])) {
  $route_query = $_GET['route'];

  $route_parts = explode('/', $route_query);
  $route = $route_parts[5] ?? "null"; // gunakan 0 untuk localhost
}

if (strpos($route, 'auth') === 0) {
  require_once __DIR__ . "/auth.php"; // Route ke Auth API
  handle_auth_routes($route);
  exit;
} else if (strpos($route, 'users') === 0 || strpos($route, 'user') === 0) {
  require_once __DIR__ . "/user.php"; // Route ke User API
  handle_user_routes($route);
} else if (strpos($route, 'products') === 0 || strpos($route, 'product') === 0) {
  require_once __DIR__ . "/product.php"; // Route ke Product API
  handle_product_routes($route);
} else {
  http_response_code(404);
  echo json_encode(["debug_route" => $route, "message" => "Route not found"]);
  exit;
}
?>