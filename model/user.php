<?php
function get_all_users()
{
  $conn = getConnection();

  $sql = "SELECT user_id, username, gender, phone_number, tahun_masuk, kelas, role_id, status, is_active FROM modapay_users";

  $result = $conn->query($sql);
  $users = array();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $users[] = $row;
    }
  }
  $conn->close();
  return $users;
}

function get_user_by_id($user_id)
{
  $conn = getConnection();

  $sql = "SELECT user_id, username, gender, phone_number, tahun_masuk, kelas, role_id, status, is_active FROM modapay_users WHERE user_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    return $result->fetch_assoc();
  } else {
    return null;
  }
}

function get_users_by_role($role_id)
{
  $conn = getConnection();

  $sql = "SELECT user_id, username, gender, phone_number, tahun_masuk, kelas, role_id, status, is_active FROM modapay_users WHERE role_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $role_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $users = array();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $users[] = $row;
    }
  }
  $conn->close();
  return $users;
}

function create_user($username, $password, $gender, $phone_number, $tahun_masuk, $kelas, $role_id, $status, $is_active)
{
  $conn = getConnection();

  $password_hash = password_hash($password, PASSWORD_BCRYPT);

  $sql = "INSERT INTO modapay_users (username, password_hash, gender, phone_number, tahun_masuk, kelas, role_id, status, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssssiisss", $username, $password_hash, $gender, $phone_number, $tahun_masuk, $kelas, $role_id, $status, $is_active);

  if ($stmt->execute()) {
    return true;
  } else {
    return false;
  }
}

function update_user($user_id, $username, $password, $gender, $phone_number, $tahun_masuk, $kelas, $role_id, $status, $is_active)
{
  $conn = getConnection();

  $sql = "UPDATE modapay_users SET username = ?, password_hash = ?, gender = ?, tahun_masuk = ?, kelas = ?, role_id = ?, status = ?, is_active = ? WHERE user_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssssisisss", $username, $password, $gender, $phone_number, $tahun_masuk, $kelas, $role_id, $status, $is_active, $user_id);

  if ($stmt->execute()) {
    return true;
  } else {
    return false;
  }
}

function delete_user($user_id)
{
  $conn = getConnection();

  $sql = "DELETE FROM modapay_users WHERE user_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $user_id);
  $result = $stmt->execute();

  if ($result) {
    return true;
  } else {
    return false;
  }
}
?>