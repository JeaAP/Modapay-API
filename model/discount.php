<?php
function get_all_discounts()
{
  $conn = getConnection();

  $sql = "SELECT * FROM modapay_discount";

  $result = $conn->query($sql);
  $discounts = array();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $discounts[] = $row;
    }
  }
  $conn->close();
  return $discounts;
}

function get_discount_by_id($discount_id)
{
  $conn = getConnection();

  $sql = "SELECT * FROM modapay_discount WHERE discount_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $discount_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    return $result->fetch_assoc();
  } else {
    return null;
  }
}

function create_discount($discount_name, $product_id, $product_type, $discount_type, $discount_percentage, $flat_rate_discount, $status, $end_date)
{
  $conn = getConnection();

  $sql = "INSERT INTO modapay_discount (discount_name, product_id, product_type, discount_type, discount_percentage, flat_rate_discount, status, end_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssssddss", $discount_name, $product_id, $product_type, $discount_type, $discount_percentage, $flat_rate_discount, $status, $end_date);
  $result = $stmt->execute();

  if ($result) {
    return $result;
  } else {
    return false;
  }
}

function update_discount($discount_id, $discount_name, $product_id, $product_type, $discount_type, $discount_percentage, $flat_rate_discount, $status, $end_date)
{
  $conn = getConnection();

  $sql = "UPDATE modapay_discount SET discount_name = ?, product_id = ?, product_type = ?, discount_type = ?, discount_percentage = ?, flat_rate_discount = ?, status = ?, end_date = ? WHERE discount_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssssddsss", $discount_name, $product_id, $product_type, $discount_type, $discount_percentage, $flat_rate_discount, $status, $end_date, $discount_id);

  $result = $stmt->execute();

  if ($result) {
    return $result;
  } else {
    return false;
  }
}

function delete_discount($discount_id)
{
  $conn = getConnection();

  $sql = "DELETE FROM modapay_discount WHERE discount_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $discount_id);

  $result = $stmt->execute();
  if ($result) {
    return true;
  } else {
    return false;
  }
}
?>