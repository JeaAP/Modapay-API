<?php
function get_all_users() {
  $conn = getConnection();

  $sql = "SELECT user_id, username, password_hash, role_id, status, is_active FROM users";

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

function create_user($username, $password, $role_id) {
  $conn = getConnection();

  $password_hash = password_hash($password, PASSWORD_BCRYPT);

  $sql = "INSERT INTO users (username, password_hash, role_id) VALUES (?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssi", $username, $password_hash, $role_id);

  $result = $stmt->execute();
  if ($result) {
    return true;
  } else {
    return false;
  }
}

function update_user($user_id, $username, $password, $role_id, $status, $is_active) {
  $conn = getConnection();

  $password_hash = password_hash($password, PASSWORD_BCRYPT);

  $sql = "UPDATE users SET username = ?, password_hash = ?, role_id = ?, status = ?, is_active = ? WHERE user_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssissi", $username, $password_hash, $role_id, $status, $is_active, $user_id);

  $result = $stmt->execute();
  if ($result) {
    return true;
  } else {
    return false;
  }
}

function delete_user($user_id) {
  $conn = getConnection();

  $sql = "DELETE FROM users WHERE user_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $user_id);

  $result = $stmt->execute();
  if ($result) {
    return true;
  } else {
    return false;
  }
}

function get_user_by_id($user_id) {
  $conn = getConnection();

  $sql = "SELECT user_id, username, password_hash, role_id, status, is_active FROM users WHERE user_id = ?";
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
?>