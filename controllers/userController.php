<?php
require_once BASE_PATH . "/model/user.php";

function get_all_users_controller() {
  $users = get_all_users();
  if ($users) {
    http_response_code(200);
    echo json_encode([
      "status" => "success",
      "data" => $users
    ]);
    exit;
  } else {
    http_response_code(404);
    echo json_encode([
      "status" => "fail",
      "message" => "User tidak ditemukan"
    ]);
    exit;
  }
}

function create_user_controller() {
  $data = json_decode(file_get_contents("php://input"), true);

  if (!isset($data['username']) || !isset($data['password']) || !isset($data['role_id'])) {
    http_response_code(400);
    echo json_encode([
      "status" => "fail",
      "message" => "Data tidak lengkap"
    ]);
    exit;
  }

  $username = $data['username'];
  $password = $data['password'];
  $role_id = $data['role_id'];

  if (create_user($username, $password, $role_id)) {
    http_response_code(201);
    echo json_encode([
      "status" => "success",
      "message" => "User berhasil dibuat"
    ]);
    exit;
  } else {
    http_response_code(500);
    echo json_encode([
      "status" => "fail",
      "message" => "Gagal membuat user"
    ]);
    exit;
  }
}

function update_user_controller($user_id) {
  if (!isset($user_id)) {
    http_response_code(400);
    echo json_encode([
      "status" => "fail",
      "message" => "User ID tidak ditemukan"
    ]);
    exit;
  }

  $data = json_decode(file_get_contents("php://input"), true);

  if (!isset($data['user_id']) || !isset($data['username']) || !isset($data['password']) || !isset($data['role_id']) || !isset($data['status']) || !isset($data['is_active'])) {
    http_response_code(400);
    echo json_encode([
      "status" => "fail",
      "message" => "Data tidak lengkap"
    ]);
    exit;
  }

  $username = $data['username'];
  $password = $data['password'];
  $role_id = $data['role_id'];
  $status = $data['status'];
  $is_active = $data['is_active'];

  if (update_user($user_id, $username, $password, $role_id, $status, $is_active)) {
    http_response_code(200);
    echo json_encode([
      "status" => "success",
      "message" => "User berhasil diperbarui"
    ]);
    exit;
  } else {
    http_response_code(500);
    echo json_encode([
      "status" => "fail",
      "message" => "Gagal memperbarui user"
    ]);
    exit;
  }
}

function delete_user_controller($user_id) {
  if (!isset($user_id)) {
    http_response_code(400);
    echo json_encode([
      "status" => "fail",
      "message" => "User ID tidak ditemukan"
    ]);
    exit;
  }

  if (delete_user($user_id)) {
    http_response_code(200);
    echo json_encode([
      "status" => "success",
      "message" => "User berhasil dihapus"
    ]);
    exit;
  } else {
    http_response_code(500);
    echo json_encode([
      "status" => "fail",
      "message" => "Gagal menghapus user"
    ]);
    exit;
  }
}

function get_user_by_id_controller($user_id) {
  if (!isset($user_id)) {
    http_response_code(400);
    echo json_encode([
      "status" => "fail",
      "message" => "User ID tidak ditemukan"
    ]);
    exit;
  }

  $user = get_user_by_id($user_id);
  if ($user) {
    http_response_code(200);
    echo json_encode([
      "status" => "success",
      "data" => $user
    ]);
    exit;
  } else {
    http_response_code(404);
    echo json_encode([
      "status" => "fail",
      "message" => "User dengan ID '$user_id' tidak ditemukan"
    ]);
    exit;
  }
}
?>