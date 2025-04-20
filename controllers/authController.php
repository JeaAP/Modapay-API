<?php
require_once BASE_PATH . "/model/auth.php";

function auth_login_controller()
{
  $data = json_decode(file_get_contents("php://input"), true);

  $username = $data['username'];
  $password = $data['password'];

  if (!isset($data['username']) || !isset($data['password'])) {
    http_response_code(400);
    echo json_encode([
      "success" => "fail",
      "message" => "Username dan password harus diisi"
    ]);
    exit;
  }

  $result = login($username, $password);

  if ($result && isset($result['success'])) {
    http_response_code(200);
    echo json_encode([
      "status" => "success",
      "message" => "Login berhasil",
      "data" => [
        "user_id" => $result['user_id'],
        "username" => $result['username'],
        "role_id" => $result['role_id'],
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

  if ($result && isset($result['success'])) {
    http_response_code(201);
    echo json_encode([
      "status" => "success",
      "message" => "Register berhasil"
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
?>