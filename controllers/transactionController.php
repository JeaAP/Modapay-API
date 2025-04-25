<?php
require_once BASE_PATH . "/model/transaction.php";
require_once BASE_PATH . "/model/product.php";  // To validate product_id if needed

function create_transaction_controller()
{
  $data = json_decode(file_get_contents("php://input"), true);

  if (!isset($data['user_id']) || !isset($data['payment_method']) || !isset($data['items'])) {
    http_response_code(400);
    echo json_encode([
      "status" => "fail",
      "message" => "Data tidak lengkap"
    ]);
    exit;
  }

  $user_id = empty($data['user_id']) ? NULL : $data['user_id'];
  $payment_method = empty($data['payment_method']) ? "cash" : $data['payment_method'];
  $items = empty($data['items']) ? NULL : $data['items'];

  // Step 1: Create the transaction
  $transaction_id = create_transaction($user_id, $payment_method, $items);

  if ($transaction_id === false) {
    http_response_code(500);
    echo json_encode([
      "status" => "fail",
      "message" => "Gagal membuat transaksi"
    ]);
    exit;
  }

  // Step 2: Insert transaction items
  if (create_transaction_items($transaction_id, $items)) {
    http_response_code(201);
    echo json_encode([
      "status" => "success",
      "message" => "Transaksi berhasil dibuat",
      "transaction_id" => $transaction_id
    ]);
    exit;
  } else {
    http_response_code(500);
    echo json_encode([
      "status" => "fail",
      "message" => "Gagal menambahkan item ke transaksi"
    ]);
    exit;
  }
}

function get_all_transactions_controller()
{
  $transactions = get_all_transactions();
  if ($transactions) {
    http_response_code(200);
    echo json_encode([
      "status" => "success",
      "data" => $transactions
    ]);
    exit;
  } else {
    http_response_code(404);
    echo json_encode([
      "status" => "fail",
      "message" => "Transaksi tidak ditemukan"
    ]);
    exit;
  }
}

function get_transaction_by_id_controller($transaction_id)
{
  $transaction = get_transaction_by_id($transaction_id);
  if ($transaction) {
    http_response_code(200);
    echo json_encode([
      "status" => "success",
      "data" => $transaction
    ]);
    exit;
  } else {
    http_response_code(404);
    echo json_encode([
      "status" => "fail",
      "message" => "Transaksi tidak ditemukan"
    ]);
    exit;
  }
}

function update_transaction_controller($transaction_id)
{
  $data = json_decode(file_get_contents("php://input"), true);

  if (!isset($data['user_id']) || !isset($data['total_amount']) || !isset($data['payment_method'])) {
    http_response_code(400);
    echo json_encode([
      "status" => "fail",
      "message" => "Data tidak lengkap"
    ]);
    exit;
  }

  $user_id = $data['user_id'];
  $total_amount = $data['total_amount'];
  $payment_method = $data['payment_method'];
  $transaction_date = date('Y-m-d H:i:s');

  if (update_transaction($transaction_id, $user_id, $total_amount, $payment_method, $transaction_date)) {
    http_response_code(200);
    echo json_encode([
      "status" => "success",
      "message" => "Transaksi berhasil diperbarui"
    ]);
    exit;
  } else {
    http_response_code(500);
    echo json_encode([
      "status" => "fail",
      "message" => "Gagal memperbarui transaksi"
    ]);
    exit;
  }
}

function delete_transaction_controller($transaction_id)
{
  if (delete_transaction($transaction_id)) {
    http_response_code(200);
    echo json_encode([
      "status" => "success",
      "message" => "Transaksi berhasil dihapus"
    ]);
    exit;
  } else {
    http_response_code(500);
    echo json_encode([
      "status" => "fail",
      "message" => "Gagal menghapus transaksi"
    ]);
    exit;
  }
}
?>