<?php
require_once BASE_PATH . "/controllers/transactionController.php";

function handle_transaction_routes($url, $route_auth)
{
  $method = $_SERVER['REQUEST_METHOD'];
  $route_parts = explode('/', $url);
  $route = $route_parts[0]; // Use 0 for localhost
  $transaction_id = $route_auth ?? null;

  if ($route === 'transactions') {
    if ($method == 'GET') {
      get_all_transactions_controller();
    } elseif ($method == 'POST') {
      create_transaction_controller();
    } else {
      http_response_code(405);
      echo json_encode(["message" => "Metode tidak diizinkan"]);
    }
  } elseif ($route === 'transaction') {
    if ($transaction_id) {
      switch ($method) {
        case 'GET':
          get_transaction_by_id_controller($transaction_id);
          break;
        case 'DELETE':
          delete_transaction_controller($transaction_id);
          break;
        case 'PUT':
          update_transaction_controller($transaction_id);
          break;
        default:
          http_response_code(405);
          echo json_encode(["message" => "Metode tidak diizinkan"]);
          break;
      }
    } else {
      http_response_code(400);
      echo json_encode(["debug_route" => $route, "message" => "Transaction ID tidak ditemukan"]);
    }
  } else if ($route === 'detail') {
    if ($transaction_id) {
      switch ($method) {
        case 'GET':
          get_detail_transaksction_controller($transaction_id);
          break;
        default:
          http_response_code(405);
          echo json_encode(["message" => "Metode tidak diizinkan"]);
          break;
      }
    } else {
      http_response_code(400);
      echo json_encode(["debug_route" => $route, "message" => "Transaction ID tidak ditemukan"]);
    }
  }
}
?>