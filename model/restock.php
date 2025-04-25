<?php
require_once __DIR__ . "/product.php";

function generate_restock_uuid()
{
  return bin2hex(random_bytes(16));  // Generate a random UUID for restock
}

function create_restock($store_id, $user_id, $status, $notes, $items)
{
  $conn = getConnection();

  $restock_id = generate_restock_uuid();

  $total_amount = 0;
  foreach ($items as $item) {
    $product_price = get_product_price($item['product_id']);
    if ($product_price === false) {
      return false;
    }
    $total_amount += $product_price * $item['quantity'];
  }

  $sql = "INSERT INTO modapay_restock (restock_id, store_id, user_id, total_amount, status, notes)
          VALUES (?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("siidss", $restock_id, $store_id, $user_id, $total_amount, $status, $notes);
  $result = $stmt->execute();

  if ($result) {
    return $restock_id;
  } else {
    return false;
  }
}

function create_restock_items($restock_id, $items)
{
  $conn = getConnection();
  $sql = "INSERT INTO modapay_restock_items (restock_item_id, restock_id, product_id, quantity, price)
          VALUES (UUID(), ?, ?, ?, ?)";

  $stmt = $conn->prepare($sql);

  foreach ($items as $item) {
    $product_price = get_product_price($item['product_id']);

    if ($product_price === false) {
      return false;
    }
    $product_price = $product_price * $item['quantity'];

    $stmt->bind_param("ssii", $restock_id, $item['product_id'], $item['quantity'], $product_price);
    if (!$stmt->execute()) {
      return false;
    }
  }

  return true;
}

function get_all_restocks()
{
  $conn = getConnection();
  $sql = "SELECT restock_id, store_id, user_id, total_amount, status, restock_date, notes FROM modapay_restock";
  $result = $conn->query($sql);
  $restocks = [];
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $restocks[] = $row;
    }
  }
  return $restocks;
}

function get_restock_by_id($restock_id)
{
  $conn = getConnection();
  $sql = "SELECT restock_id, store_id, user_id, total_amount, status, restock_date, notes
          FROM modapay_restock WHERE restock_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $restock_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    return $result->fetch_assoc();
  } else {
    return null;
  }
}

function update_restock_status($restock_id, $status)
{
  $conn = getConnection();
  $sql = "UPDATE modapay_restock SET status = ? WHERE restock_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $status, $restock_id);

  return $stmt->execute();
}

function delete_restock($restock_id)
{
  $conn = getConnection();
  $sql = "DELETE FROM modapay_restock WHERE restock_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $restock_id);
  return $stmt->execute();
}

function get_restock_by_status($status) {
  $conn = getConnection();
  $sql = "SELECT restock_id, store_id, user_id, total_amount, status, restock_date, notes
          FROM modapay_restock WHERE status = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $status);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    return $result->fetch_all(MYSQLI_ASSOC);
  } else {
    return null;
  }
}
?>