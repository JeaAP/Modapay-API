<?php
require_once BASE_PATH . "/model/product.php";

function get_all_products_controller()
{
  $products = get_all_products();
  if ($products) {
    http_response_code(200);
    echo json_encode([
      "status" => "success",
      "data" => $products
    ]);
    exit;
  } else {
    http_response_code(404);
    echo json_encode([
      "status" => "fail",
      "message" => "Product tidak ditemukan"
    ]);
    exit;
  }
}

function create_product_controller()
{
  $data = json_decode(file_get_contents("php://input"), true);

  if (!isset($data['product_name']) || !isset($data['price'])) {
    http_response_code(400);
    echo json_encode([
      "status" => "fail",
      "message" => "Data tidak lengkap"
    ]);
    exit;
  }

  $product_name = empty($data['product_name']) ? NULL : $data['product_name'];
  $category = empty($data['category']) ? NULL : $data['category'];
  $description = empty($data['description']) ? NULL : $data['description'];
  $price = empty($data['price']) ? NULL : $data['price'];
  $stock_quantity = empty($data['stock_quantity']) ? 0 : $data['stock_quantity'];
  $photo_url = empty($data['photo_url']) ? NULL : $data['photo_url'];

  if (create_product($product_name, $category, $description, $price, $stock_quantity, $photo_url)) {
    http_response_code(201);
    echo json_encode([
      "status" => "success",
      "message" => "Product berhasil dibuat"
    ]);
    exit;
  } else {
    http_response_code(500);
    echo json_encode([
      "status" => "fail",
      "message" => "Gagal membuat product"
    ]);
    exit;
  }
}

function update_product_controller($product_id)
{
  $data = json_decode(file_get_contents("php://input"), true);

  if (!isset($data['product_name']) || !isset($data['price'])) {
    http_response_code(400);
    echo json_encode([
      "status" => "fail",
      "message" => "Data tidak lengkap"
    ]);
    exit;
  }

  if (!isset($product_id)) {
    http_response_code(400);
    echo json_encode([
      "status" => "fail",
      "message" => "Product ID tidak ditemukan"
    ]);
    exit;
  }

  $product_name = empty($data['product_name']) ? NULL : $data['product_name'];
  $category = empty($data['category']) ? NULL : $data['category'];
  $description = empty($data['description']) ? NULL : $data['description'];
  $price = empty($data['price']) ? NULL : $data['price'];
  $stock_quantity = empty($data['stock_quantity']) ? 0 : $data['stock_quantity'];
  $photo_url = empty($data['photo_url']) ? NULL : $data['photo_url'];

  if (update_product($product_id, $product_name, $category, $description, $price, $stock_quantity, $photo_url)) {
    http_response_code(200);
    echo json_encode([
      "status" => "success",
      "message" => "Product berhasil diperbarui"
    ]);
    exit;
  } else {
    http_response_code(500);
    echo json_encode([
      "status" => "fail",
      "message" => "Gagal memperbarui product"
    ]);
    exit;
  }
}

function delete_product_controller($product_id)
{
  if (!isset($product_id)) {
    http_response_code(400);
    echo json_encode([
      "status" => "fail",
      "message" => "Product ID tidak ditemukan"
    ]);
    exit;
  }

  if (delete_product($product_id)) {
    http_response_code(200);
    echo json_encode([
      "status" => "success",
      "message" => "Product berhasil dihapus"
    ]);
    exit;
  } else {
    http_response_code(500);
    echo json_encode([
      "status" => "fail",
      "message" => "Gagal menghapus product"
    ]);
    exit;
  }
}

function get_product_by_id_controller($product_id)
{
  $product = get_product_by_id($product_id);
  if ($product) {
    http_response_code(200);
    echo json_encode([
      "status" => "success",
      "data" => $product
    ]);
    exit;
  } else {
    http_response_code(404);
    echo json_encode([
      "status" => "fail",
      "message" => "Product tidak ditemukan"
    ]);
    exit;
  }
}

function get_product_by_category_controller($category)
{
  $products = get_product_by_category($category);
  if ($products) {
    http_response_code(200);
    echo json_encode([
      "status" => "success",
      "data" => $products
    ]);
    exit;
  } else {
    http_response_code(404);
    echo json_encode([
      "status" => "fail",
      "message" => "Product tidak ditemukan"
    ]);
    exit;
  }
}
?>