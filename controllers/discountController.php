<?php
require_once BASE_PATH . "/model/discount.php";

function get_all_discounts_controller()
{
  $discounts = get_all_discounts();
  if ($discounts) {
    http_response_code(200);
    echo json_encode([
      "status" => "success",
      "data" => $discounts
    ]);
    exit;
  } else {
    http_response_code(404);
    echo json_encode([
      "status" => "fail",
      "message" => "Discount tidak ditemukan"
    ]);
    exit;
  }
}

function create_discount_controller()
{
  $data = json_decode(file_get_contents("php://input"), true);

  if (!isset($data['discount_name']) || !isset($data['discount_percentage']) || !isset($data['end_date'])) {
    http_response_code(400);
    echo json_encode([
      "status" => "fail",
      "message" => "Data tidak lengkap"
    ]);
    exit;
  }

  $discount_name = empty($data['discount_name']) ? NULL : $data['discount_name'];
  $product_id = empty($data['product_id']) ? NULL : $data['product_id'];
  $product_type = empty($data['product_type']) ? NULL : $data['product_type'];
  $discount_type = empty($data['discount_type']) ? NULL : $data['discount_type'];
  $discount_percentage = empty($data['discount_percentage']) ? NULL : $data['discount_percentage'];
  $flat_rate_discount = empty($data['flat_rate_discount']) ? NULL : $data['flat_rate_discount'];
  $status = empty($data['status']) ? "Public" : $data['status'];
  $end_date = empty($data['end_date']) ? NULL : $data['end_date'];

  if (create_discount($discount_name, $product_id, $product_type, $discount_type, $discount_percentage, $flat_rate_discount, $status, $end_date)) {
    http_response_code(201);
    echo json_encode([
      "status" => "success",
      "message" => "Discount berhasil dibuat"
    ]);
    exit;
  } else {
    http_response_code(500);
    echo json_encode([
      "status" => "fail",
      "message" => "Gagal membuat discount"
    ]);
    exit;
  }
}

function update_discount_controller($discount_id)
{
  $data = json_decode(file_get_contents("php://input"), true);

  if (!isset($data['discount_name']) || !isset($data['discount_percentage']) || !isset($data['end_date'])) {
    http_response_code(400);
    echo json_encode([
      "status" => "fail",
      "message" => "Data tidak lengkap"
    ]);
    exit;
  }

  if (!isset($discount_id)) {
    http_response_code(400);
    echo json_encode([
      "status" => "fail",
      "message" => "Discount ID tidak ditemukan"
    ]);
    exit;
  }

  $discount_name = empty($data['discount_name']) ? NULL : $data['discount_name'];
  $product_id = empty($data['product_id']) ? NULL : $data['product_id'];
  $product_type = empty($data['product_type']) ? NULL : $data['product_type'];
  $discount_type = empty($data['discount_type']) ? NULL : $data['discount_type'];
  $discount_percentage = empty($data['discount_percentage']) ? NULL : $data['discount_percentage'];
  $flat_rate_discount = empty($data['flat_rate_discount']) ? NULL : $data['flat_rate_discount'];
  $status = empty($data['status']) ? NULL : $data['status'];
  $end_date = empty($data['end_date']) ? NULL : $data['end_date'];

  if (update_discount($discount_id, $discount_name, $product_id, $product_type, $discount_type, $discount_percentage, $flat_rate_discount, $status, $end_date)) {
    http_response_code(200);
    echo json_encode([
      "status" => "success",
      "message" => "Discount berhasil diperbarui"
    ]);
    exit;
  } else {
    http_response_code(500);
    echo json_encode([
      "status" => "fail",
      "message" => "Gagal memperbarui discount"
    ]);
    exit;
  }
}

function delete_discount_controller($discount_id)
{
  if (!isset($discount_id)) {
    http_response_code(400);
    echo json_encode([
      "status" => "fail",
      "message" => "Discount ID tidak ditemukan"
    ]);
    exit;
  }

  if (delete_discount($discount_id)) {
    http_response_code(200);
    echo json_encode([
      "status" => "success",
      "message" => "Discount berhasil dihapus"
    ]);
    exit;
  } else {
    http_response_code(500);
    echo json_encode([
      "status" => "fail",
      "message" => "Gagal menghapus discount"
    ]);
    exit;
  }
}

function get_discount_by_id_controller($discount_id)
{
  $discount = get_discount_by_id($discount_id);
  if ($discount) {
    http_response_code(200);
    echo json_encode([
      "status" => "success",
      "message" => "Discount ditemukan",
      "data" => $discount
    ]);
    exit;
  } else {
    http_response_code(404);
    echo json_encode([
      "status" => "fail",
      "message" => "Discount tidak ditemukan"
    ]);
    exit;
  }
}
?>