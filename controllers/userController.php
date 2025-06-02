<?php
require_once BASE_PATH . "/model/user.php";

function get_all_users_controller()
{
  $users = get_all_users();
  if (count($users) > 0) {
    http_response_code(200);
    echo json_encode([
      "status" => "success",
      "message" => "Users berhasil ditemukan",
      "data" => $users
    ]);
    exit;
  } else {
    http_response_code(404);
    echo json_encode([
      "status" => "fail",
      "message" => "Users not found"
    ]);
    exit;
  }
}

function get_pemilik_controller()
{
  $users = get_users_by_role(1);
  if ($users) {
    http_response_code(200);
    echo json_encode([
      "status" => "success",
      "message" => "Owner users found",
      "data" => $users
    ]);
    exit;
  } else {
    http_response_code(404);
    echo json_encode([
      "status" => "fail",
      "message" => "No owner users found"
    ]);
    exit;
  }
}

function get_admin_controller()
{
  $users = get_users_by_role(2);
  if (count($users) > 0) {
    http_response_code(200);
    echo json_encode([
      "status" => "success",
      "message" => "Admin users found",
      "data" => $users
    ]);
    exit;
  } else {
    http_response_code(404);
    echo json_encode([
      "status" => "fail",
      "message" => "No admin users found"
    ]);
    exit;
  }
}

function get_kasir_controller()
{
  $users = get_users_by_role(3);
  if (count($users) > 0) {
    http_response_code(200);
    echo json_encode([
      "status" => "success",
      "message" => "Kasir users found",
      "data" => $users
    ]);
    exit;
  } else {
    http_response_code(404);
    echo json_encode([
      "status" => "fail",
      "message" => "No kasir users found"
    ]);
    exit;
  }
}

function create_user_controller()
{
  $data = json_decode(file_get_contents("php://input"), true);

  if (!isset($data['username']) || !isset($data['password'])) {
    http_response_code(400);
    echo json_encode([
      "status" => "fail",
      "message" => "Incomplete data"
    ]);
    exit;
  }

  $username = empty($data['username']) ? null : $data['username'];
  $password = empty($data['password']) ? null : $data['password'];
  $gender = empty($data['gender']) ? null : $data['gender'];
  $phone_number = empty($data['phone_number']) ? null : $data['phone_number'];
  $tahun_masuk = empty($data['tahun_masuk']) ? null : $data['tahun_masuk'];
  $kelas = empty($data['kelas']) ? null : $data['kelas'];
  $role_id = empty($data['role_id']) ? 3 : $data['role_id'];
  $status = empty($data['status']) ? null : $data['status'];
  $is_active = empty($data['is_active']) ? null : $data['is_active'];

  if ($role_id == 2) {
    $status = "accepted";
  }

  if (create_user($username, $password, $gender,  $phone_number,$tahun_masuk, $kelas, $role_id, $status, $is_active)) {
    http_response_code(201);
    echo json_encode([
      "status" => "success",
      "message" => "User created successfully"
    ]);
    exit;
  } else {
    http_response_code(500);
    echo json_encode([
      "status" => "fail",
      "message" => "Failed to create user"
    ]);
    exit;
  }
}

function update_user_controller($user_id)
{
  $data = json_decode(file_get_contents("php://input"), true);

  if (!isset($data['username'])) {
    http_response_code(400);
    echo json_encode([
      "status" => "fail",
      "message" => "Incomplete data"
    ]);
    exit;
  }

  if (!isset($user_id)) {
    http_response_code(400);
    echo json_encode([
      "status" => "fail",
      "message" => "User ID not found"
    ]);
    exit;
  }

  $username = empty($data['username']) ? null : $data['username'];
  $password = empty($data['password']) ? null : $data['password'];
  $gender = empty($data['gender']) ? null : $data['gender'];
  $phone_number = empty($data['phone_number']) ? null : $data['phone_number'];
  $tahun_masuk = empty($data['tahun_masuk']) ? null : $data['tahun_masuk'];
  $kelas = empty($data['kelas']) ? null : $data['kelas'];
  $role_id = empty($data['role_id']) ? 3 : $data['role_id'];
  $status = empty($data['status']) ? null : $data['status'];
  $is_active = empty($data['is_active']) ? null : $data['is_active'];

  if (update_user($user_id, $username, $password, $gender,  $phone_number, $tahun_masuk, $kelas, $role_id, $status, $is_active)) {
    http_response_code(200);
    echo json_encode([
      "status" => "success",
      "message" => "User updated successfully"
    ]);
    exit;
  } else {
    http_response_code(500);
    echo json_encode([
      "status" => "fail",
      "message" => "Failed to update user"
    ]);
    exit;
  }
}

function delete_user_controller($user_id)
{
  if (!isset($user_id)) {
    http_response_code(400);
    echo json_encode([
      "status" => "fail",
      "message" => "User ID not found"
    ]);
    exit;
  }

  if (delete_user($user_id)) {
    http_response_code(200);
    echo json_encode([
      "status" => "success",
      "message" => "User deleted successfully"
    ]);
    exit;
  } else {
    http_response_code(500);
    echo json_encode([
      "status" => "fail",
      "message" => "Failed to delete user"
    ]);
    exit;
  }
}

function get_user_by_id_controller($user_id)
{
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
      "message" => "User not found"
    ]);
    exit;
  }
}
?>