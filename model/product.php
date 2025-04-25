<?php
function get_all_products()
{
  $conn = getConnection();

  $sql = "SELECT product_id, product_name, category, price, stock_quantity, photo_url FROM modapay_products";

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

  $sql = "SELECT product_id, product_name, category, price, stock_quantity, photo_url FROM modapay_products WHERE product_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $product_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    return $result->fetch_assoc();
  } else {
    return null;
  }

}

function create_product($product_name, $category, $description, $price, $stock_quantity, $photo_url)
{
  $conn = getConnection();

  $sql = "INSERT INTO modapay_products (product_name, category, description, price, stock_quantity, photo_url) VALUES (?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssdis", $product_name, $category, $description, $price, $stock_quantity, $photo_url);

  if ($stmt->execute()) {
    return true;
  } else {
    return false;
  }
}

function update_product($product_id, $product_name, $category, $description, $price, $stock_quantity, $photo_url)
{
  $conn = getConnection();

  $sql = "UPDATE modapay_products SET product_name = ?, category = ?, description = ?, price = ?, stock_quantity = ?, photo_url = ? WHERE product_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssdiss", $product_name, $category, $description, $price, $stock_quantity, $photo_url, $product_id);

  if ($stmt->execute()) {
    return true;
  } else {
    return false;
  }
}

function delete_product($product_id)
{
  $conn = getConnection();

  $sql = "DELETE FROM modapay_products WHERE product_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $product_id);
  $result = $stmt->execute();

  if ($result) {
    return true;
  } else {
    return false;
  }
}
?>