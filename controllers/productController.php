<?php
require_once BASE_PATH . "/model/product.php";

function get_all_products_controller()
{
  $products = get_all_products();
  if ($products) {
    http_response_code(200);
    echo json_encode([
      "status" => "success",
      "message" => "Berhasil mendapatkan semua produk",
      "data" => $products
    ]);
    exit;
  } else if (empty($products)) {
    http_response_code(404);
    echo json_encode([
      "status" => "fail",
      "message" => "Tidak ada produk"
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
    echo json_encode(["status" => "fail", "message" => "Data tidak lengkap"]);
    exit;
  }

  $product_name = $data['product_name'] ?? null;
  $category = $data['category'] ?? null;
  $description = $data['description'] ?? null;
  $price = $data['price'] ?? null;
  $stock_s = $data['stock_size_s'] ?? 0;
  $stock_m = $data['stock_size_m'] ?? 0;
  $stock_l = $data['stock_size_l'] ?? 0;
  $stock_xl = $data['stock_size_xl'] ?? 0;
  $photo_url = $data['photo_url'] ?? null;

  if (create_product($product_name, $category, $description, $price, $stock_s, $stock_m, $stock_l, $stock_xl, $photo_url)) {
    http_response_code(201);
    echo json_encode(["status" => "success", "message" => "Product berhasil dibuat"]);
  } else {
    http_response_code(500);
    echo json_encode(["status" => "fail", "message" => "Gagal membuat product"]);
  }
  exit;
}


function update_product_controller($product_id)
{
  $data = json_decode(file_get_contents("php://input"), true);

  if (!isset($data['product_name']) || !isset($data['price'])) {
    http_response_code(400);
    echo json_encode(["status" => "fail", "message" => "Data tidak lengkap"]);
    exit;
  }

  if (!$product_id) {
    http_response_code(400);
    echo json_encode(["status" => "fail", "message" => "Product ID tidak ditemukan"]);
    exit;
  }

  $product_name = $data['product_name'] ?? null;
  $category = $data['category'] ?? null;
  $description = $data['description'] ?? null;
  $price = $data['price'] ?? null;
  $stock_s = $data['stock_size_s'] ?? 0;
  $stock_m = $data['stock_size_m'] ?? 0;
  $stock_l = $data['stock_size_l'] ?? 0;
  $stock_xl = $data['stock_size_xl'] ?? 0;
  $photo_url = $data['photo_url'] ?? null;

  if (
    update_product(
      $product_id,
      $product_name,
      $category,
      $description,
      $price,
      $stock_s,
      $stock_m,
      $stock_l,
      $stock_xl,
      $photo_url
    )
  ) {
    http_response_code(200);
    echo json_encode(["status" => "success", "message" => "Product berhasil diperbarui"]);
  } else {
    http_response_code(500);
    echo json_encode(["status" => "fail", "message" => "Gagal memperbarui product"]);
  }
  exit;
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
      "message" => "Berhasil mendapatkan produk",
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
      "message" => "Berhasil mendapatkan produk",
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