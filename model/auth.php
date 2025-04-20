<?php
function login($username, $password)
{
  $conn = getConnection();

  $sql = "SELECT user_id, password_hash, role_id FROM users WHERE username = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $username);
  $stmt->execute();

  $stmt->store_result();
  if ($stmt->num_rows === 1) {
    $stmt->bind_result($user_id, $password_hash, $role_id);
    $stmt->fetch();

    if (password_verify($password, $password_hash)) {
      return [
        "success" => true,
        "user_id" => $user_id,
        "username" => $username,
        "role_id" => $role_id
      ];
    } else {
      return [
        "success" => false,
        "message" => "Password salah"
      ];
    }
  } else {
    return false;
  }
}


function register($username, $password)
{
  $conn = getConnection();

  // Cek apakah username sudah terdaftar
  $check = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
  $check->bind_param("s", $username);
  $check->execute();
  $check->store_result();

  if ($check->num_rows > 0) {
    return [
      "success" => false,
      "message" => "Username sudah terdaftar"
    ];
  }
  // ------------------

  $password_hash = password_hash($password, PASSWORD_BCRYPT);

  $sql = "INSERT INTO users (username, password_hash) VALUES (?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $username, $password_hash);

  if ($stmt->execute()) {
    return true;
  } else {
    return false;
  }
}
?>