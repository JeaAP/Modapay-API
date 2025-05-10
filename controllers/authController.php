<?php
require_once BASE_PATH . "/model/auth.php";

function auth_login_controller()
{
  $data = json_decode(file_get_contents("php://input"), true);

  if (!isset($data['username']) || !isset($data['password'])) {
    http_response_code(400);
    echo json_encode([
      "success" => "fail",
      "message" => "Username dan password harus diisi"
    ]);
    exit;
  }

  $username = $data['username'];
  $password = $data['password'];
  $result = login($username, $password);

  if ($result && isset($result['success']) && $result['success']) {
    http_response_code(200);
    echo json_encode([
      "status" => "success",
      "message" => "Login berhasil",
      "data" => [
        "user_id" => $result['user_id'],
        "username" => $result['username'],
        "phone_number" => $result['phone_number'],
        "gender" => $result['gender'],
        "tahun_masuk" => $result['tahun_masuk'],
        "kelas" => $result['kelas'],
        "role_id" => $result['role_id'],
        "created_at" => $result['created_at'],
        "status" => $result['status'],
        "is_active" => $result['is_active']
      ]
    ]);
    exit;
  } else {
    http_response_code(401);
    echo json_encode([
      "status" => "fail",
      "message" => $result['message'] ?? "Login gagal"
    ]);
    exit;
  }
}

function auth_register_controller()
{
  $data = json_decode(file_get_contents("php://input"), true);

  $username = $data['username'];
  $password = $data['password'];

  if (!isset($data['username']) || !isset($data['password'])) {
    http_response_code(400);
    echo json_encode([
      "success" => false,
      "message" => "Username dan password harus diisi"
    ]);
    exit;
  }

  $result = register($username, $password);

  if ($result) {
    http_response_code(201);
    echo json_encode([
      "status" => "success",
      "message" => "Register berhasil",
      "data" => [
        "user_id" => $result["user_id"]
      ]
    ]);
    exit;
  } else {
    http_response_code(400);
    echo json_encode([
      "status" => "fail",
      "message" => $result['message'] ?? "Register gagal"
    ]);
    exit;
  }
}

function kasir_personal_data_controller()
{
  $data = json_decode(file_get_contents("php://input"), true);

  $user_id = $data['user_id'];
  $gender = $data['gender'];
  $tahun_masuk = $data['tahun_masuk'];
  $kelas = $data['kelas'];
  $phone_number = $data['phone_number'];

  if (!isset($data['user_id']) || !isset($data['gender']) || !isset($data['tahun_masuk']) || !isset($data['kelas']) || !isset($data['phone_number'])) {
    http_response_code(400);
    echo json_encode([
      "success" => false,
      "message" => "Data harus diisi"
    ]);
    exit;
  }

  $result = personal_data($user_id, $gender, $tahun_masuk, $kelas, $phone_number);

  if ($result) {
    http_response_code(201);
    echo json_encode([
      "status" => "success",
      "message" => "Data berhasil disimpan"
    ]);
    exit;
  } else {
    http_response_code(400);
    echo json_encode([
      "status" => "fail",
      "message" => "Data gagal disimpan"
    ]);
    exit;
  }
}
?>
