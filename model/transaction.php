<?php
require_once __DIR__ . "/product.php";

function generate_uuid()
{
  return bin2hex(random_bytes(16));  // Generate a random UUID (char(36) compatible format)
}

function create_transaction($user_id, $payment_method, $total_amount)
{
  $conn = getConnection();

  do {
    $transaction_id = 'TX-' . sprintf('%02d%04d', mt_rand(0, 99), mt_rand(0, 9999));
    $sql_check = "SELECT transaction_id FROM modapay_transactions WHERE transaction_id = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $transaction_id);
    $stmt_check->execute();
    $stmt_check->store_result();
  } while ($stmt_check->num_rows > 0);

  $sql = "INSERT INTO modapay_transactions (transaction_id, user_id, total_amount, payment_method) 
            VALUES (?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sids", $transaction_id, $user_id, $total_amount, $payment_method);

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
    $product = get_product_by_id($item['product_id']);

    if ($product === false) {
      return false;
    }
    $product_price = $product['price'] * $item['quantity'];

    $stmt->bind_param("ssis", $transaction_id, $item['product_id'], $item['quantity'], $product_price);
    if (!$stmt->execute()) {
      return false;
    }
  }

  return true;
}

function get_transactions_by_date($date)
{
  $conn = getConnection();

  $sql = "SELECT * FROM modapay_transactions WHERE DATE(transaction_date) = ?";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $date);
  $stmt->execute();
  $result = $stmt->get_result();

  $transactions = [];
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $transactions[] = $row;
    }
  }
  $conn->close();
  return $transactions;
}

function get_all_transactions()
{
  $conn = getConnection();

  $sql = "SELECT transaction_id, user_id, total_amount, payment_method, transaction_date, status
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

  $sql = "SELECT transaction_id, user_id, total_amount, payment_method, transaction_date, status
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
  $stmt->bind_param("iss", $user_id, $payment_method, $transaction_id);

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

function get_detail_transaction($transaction_id)
{
  $conn = getConnection();
  $sql = "SELECT * FROM modapay_transaction_items WHERE transaction_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $transaction_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $transaction_items = [];
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $transaction_items[] = $row;
    }
  }
  $conn->close();
  return $transaction_items;
}

function get_all_detail_transaction()
{
  $conn = getConnection();
  $sql = "SELECT * FROM modapay_transaction_items";
  $result = $conn->query($sql);
  $transaction_items = [];
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $transaction_items[] = $row;
    }
  }
  $conn->close();
  return $transaction_items;
}
?>