<?php
require_once BASE_PATH . "/model/restock.php";
require_once BASE_PATH . "/model/product.php";

function create_restock_controller()
{
  $data = json_decode(file_get_contents("php://input"), true);

  if (!isset($data['store_id']) || !isset($data['user_id']) || !isset($data['status']) || !isset($data['items'])) {
    http_response_code(400);
    echo json_encode([
      "status" => "fail",
      "message" => "Data tidak lengkap"
    ]);
    exit;
  }

  $store_id = empty($data['store_id']) ? NULL : $data['store_id'];
  $user_id = empty($data['user_id']) ? NULL : $data['user_id'];
  $status = empty($data['status']) ? "pending" : $data['status'];
  $notes = isset($data['notes']) ? $data['notes'] : '';
  $items = $data['items'];

  // Step 1: Create the restock record
  $restock_id = create_restock($store_id, $user_id, $status, $notes, $items);

  if ($restock_id === false) {
    http_response_code(500);
    echo json_encode([
      "status" => "fail",
      "message" => "Gagal membuat restock"
    ]);
    exit;
  }

  // Step 2: Insert restock items
  if (create_restock_items($restock_id, $items)) {
    http_response_code(201);
    echo json_encode([
      "status" => "success",
      "message" => "Restock berhasil dibuat",
      "data" => [
        "restock_id" => $restock_id,
      ]
    ]);
    exit;
  } else {
    http_response_code(500);
    echo json_encode([
      "status" => "fail",
      "message" => "Gagal menambahkan item ke restock"
    ]);
    exit;
  }
}

function get_all_restocks_controller()
{
  $restocks = get_all_restocks();
  if ($restocks) {
    http_response_code(200);
    echo json_encode([
      "status" => "success",
      "message" => "Berhasil mendapatkan restock",
      "data" => $restocks
    ]);
    exit;
  } else {
    http_response_code(404);
    echo json_encode([
      "status" => "fail",
      "message" => "Restock tidak ditemukan"
    ]);
    exit;
  }
}

function get_restock_by_id_controller($restock_id)
{
  $restock = get_restock_by_id($restock_id);
  if ($restock) {
    http_response_code(200);
    echo json_encode([
      "status" => "success",
      "message" => "Berhasil mendapatkan restock",
      "data" => $restock
    ]);
    exit;
  } else {
    http_response_code(404);
    echo json_encode([
      "status" => "fail",
      "message" => "Restock tidak ditemukan"
    ]);
    exit;
  }
}

function update_restock_status_controller($restock_id)
{
  $data = json_decode(file_get_contents("php://input"), true);

  if (!isset($data['status'])) {
    http_response_code(400);
    echo json_encode([
      "status" => "fail",
      "message" => "Status tidak diberikan"
    ]);
    exit;
  }

  $status = $data['status'];

  if (update_restock_status($restock_id, $status)) {
    http_response_code(200);
    echo json_encode([
      "status" => "success",
      "message" => "Status restock berhasil diperbarui"
    ]);
    exit;
  } else {
    http_response_code(500);
    echo json_encode([
      "status" => "fail",
      "message" => "Gagal memperbarui status restock"
    ]);
    exit;
  }
}

function delete_restock_controller($restock_id)
{
  if (delete_restock($restock_id)) {
    http_response_code(200);
    echo json_encode([
      "status" => "success",
      "message" => "Restock berhasil dihapus"
    ]);
    exit;
  } else {
    http_response_code(500);
    echo json_encode([
      "status" => "fail",
      "message" => "Gagal menghapus restock"
    ]);
    exit;
  }
}

function get_restock_by_status_controller($status)
{
  $restocks = get_restock_by_status($status);
  if ($restocks) {
    http_response_code(200);
    echo json_encode([
      "status" => "success",
      "message" => "Berhasil mendapatkan restock",
      "data" => $restocks
    ]);
    exit;
  } else {
    http_response_code(404);
    echo json_encode([
      "status" => "fail",
      "message" => "Restock tidak ditemukan"
    ]);
    exit;
  }
}
?>