<?php
require_once __DIR__ . "/product.php";

function generate_uuid()
{
  return bin2hex(random_bytes(16));  // Generate a random UUID (char(36) compatible format)
}

function create_transaction($user_id, $payment_method, $items)
{
  $conn = getConnection();

  $transaction_id = generate_uuid();

  $total_amount = 0;
  foreach ($items as $item) {
    $price = get_product_price($item['product_id']);
    if ($price === false) {
      return false;
    }
    $total_amount += $price * $item['quantity'];
  }

  $sql = "INSERT INTO modapay_transactions (transaction_id, user_id, total_amount, payment_method) 
            VALUES (?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sids",  $transaction_id, $user_id, $total_amount, $payment_method);

  if ($stmt->execute()) {
    return $transaction_id;
  } else {
    return [
      "status" => "fail",
      "message" => "Gagal membuat transaksi"
    ];
  }
}

function create_transaction_items($transaction_id, $items)
{
  $conn = getConnection();
  $sql = "INSERT INTO modapay_transaction_items (	item_id, transaction_id, product_id, quantity, price) 
            VALUES (UUID(), ?, ?, ?, ?)";

  $stmt = $conn->prepare($sql);

  foreach ($items as $item) {
    $product = get_product_price($item['product_id']);

    if ($product === false) {
      return false;
    }
    $product_price = $product * $item['quantity'];

    $stmt->bind_param("ssis", $transaction_id, $item['product_id'], $item['quantity'], $product_price);
    if (!$stmt->execute()) {
      return false;
    }
  }

  return true;
}

function get_all_transactions()
{
  $conn = getConnection();

  $sql = "SELECT transaction_id, user_id, total_amount, payment_method, transaction_date 
            FROM modapay_transactions";

  $result = $conn->query($sql);
  $transactions = [];
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $transactions[] = $row;
    }
  }
  $conn->close();
  return $transactions;
}

function get_transaction_by_id($transaction_id)
{
  $conn = getConnection();

  $sql = "SELECT transaction_id, user_id, total_amount, payment_method, transaction_date 
            FROM modapay_transactions WHERE transaction_id = ?";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $transaction_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    return $result->fetch_assoc();
  } else {
    return null;
  }
}

function update_transaction($transaction_id, $user_id, $payment_method)
{
  $conn = getConnection();

  $sql = "UPDATE modapay_transactions SET user_id = ?, payment_method = ?
            WHERE transaction_id = ?";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("iss", $user_id,  $payment_method, $transaction_id);

  return $stmt->execute();
}

function delete_transaction($transaction_id)
{
  $conn = getConnection();

  $sql = "DELETE FROM modapay_transactions WHERE transaction_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $transaction_id);
  return $stmt->execute();
}
?>