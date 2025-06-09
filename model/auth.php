<?php
function login($username, $password)
{
  $conn = getConnection();

  $sql = "SELECT * FROM modapay_users WHERE username = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $username);
  $result = $stmt->execute();

  if (!$result) {
    return false;
  }

  $stmt->store_result();
  if ($stmt->num_rows === 1) {
    $stmt->bind_result(
      $user_id,
      $username_db,
      $password_hash,
      $phone_number,
      $gender,
      $tahun_masuk,
      $kelas,
      $role_id,
      $created_at,
      $status,
      $is_active
    );
    $stmt->fetch();

    if ($is_active == 'inactive') {
      return [
        "success" => false,
        "message" => "Akun Anda sudah tidak aktif"
      ];
    }

    if (password_verify($password, $password_hash)) {
      if ($status == 'pending') {
        return [
          "success" => false,
          "message" => "Akun Anda sedang menunggu persetujuan"
        ];
      } else {
        return [
          "success" => true,
          "user_id" => $user_id,
          "username" => $username_db,
          "phone_number" => $phone_number,
          "gender" => $gender,
          "tahun_masuk" => $tahun_masuk,
          "kelas" => $kelas,
          "role_id" => $role_id,
          "created_at" => $created_at,
          "status" => $status,
          "is_active" => $is_active
        ];
      }
    } else {
      return [
        "success" => false,
        "message" => "Password salah"
      ];
    }
  } else {
    return [
      "success" => false,
      "message" => "Username tidak ditemukan"
    ];
  }
}

function register($username, $password)
{
  $conn = getConnection();

  // Cek apakah username sudah terdaftar
  $check = $conn->prepare("SELECT user_id FROM modapay_users WHERE username = ? LIMIT 1");
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

  $sql = "INSERT INTO modapay_users (username, password_hash) VALUES (?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $username, $password_hash);

  if ($stmt->execute()) {
    $user_id = $conn->insert_id;
    return [
      "success" => true,
      "user_id" => $user_id
    ];
  } else {
    return [
      "success" => false,
      "message" => "Gagal membuat akun"
    ];
  }
}

function personal_data($user_id, $gender, $tahun_masuk, $kelas, $phone_number)
{
  $conn = getConnection();

  $sql = "UPDATE modapay_users SET gender = ?, tahun_masuk = ?, kelas = ?, phone_number = ? WHERE user_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssssi", $gender, $tahun_masuk, $kelas, $phone_number, $user_id);

  if ($stmt->execute()) {
    return true;
  } else {
    return false;
  }
}
?>