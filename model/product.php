<?php
function get_all_products()
{
  $conn = getConnection();

  $sql = "SELECT product_id, product_name, category, description, price, 
                  stock_size_s, stock_size_m, stock_size_l, stock_size_xl, 
                  stock_quantity, photo_url 
          FROM modapay_products";

  $result = $conn->query($sql);
  $products = array();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $products[] = $row;
    }
  }
  $conn->close();
  return $products;
}

function get_product_by_id($product_id)
{
  $conn = getConnection();

  $sql = "SELECT product_id, product_name, category, description, price, 
                  stock_size_s, stock_size_m, stock_size_l, stock_size_xl, 
                  stock_quantity, photo_url 
          FROM modapay_products WHERE product_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $product_id);
  $stmt->execute();
  $result = $stmt->get_result();

  return $result->num_rows > 0 ? $result->fetch_assoc() : null;
}

function create_product(
  $product_name,
  $category,
  $description,
  $price,
  $stock_s,
  $stock_m,
  $stock_l,
  $stock_xl,
  $photo_url
) {
  $conn = getConnection();

  $stock_quantity = $stock_s + $stock_m + $stock_l + $stock_xl;

  $sql = "INSERT INTO modapay_products 
          (product_name, category, description, price, 
            stock_size_s, stock_size_m, stock_size_l, stock_size_xl, 
            stock_quantity, photo_url)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param(
    "sssdiiiiis",
    $product_name,
    $category,
    $description,
    $price,
    $stock_s,
    $stock_m,
    $stock_l,
    $stock_xl,
    $stock_quantity,
    $photo_url
  );

  return $stmt->execute();
}

function update_product(
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
) {
  $conn = getConnection();

  $stock_quantity = $stock_s + $stock_m + $stock_l + $stock_xl;

  $sql = "UPDATE modapay_products 
          SET product_name = ?, category = ?, description = ?, price = ?, 
              stock_size_s = ?, stock_size_m = ?, stock_size_l = ?, stock_size_xl = ?, 
              stock_quantity = ?, photo_url = ?
          WHERE product_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param(
    "sssdiiiiiss",
    $product_name,
    $category,
    $description,
    $price,
    $stock_s,
    $stock_m,
    $stock_l,
    $stock_xl,
    $stock_quantity,
    $photo_url,
    $product_id
  );

  return $stmt->execute();
}

?>