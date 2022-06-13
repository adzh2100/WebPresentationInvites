<?php

require_once(realpath(dirname(__FILE__) . '/../services/user_service.php'));

$userService = new UserService();
$data = file_get_contents("php://input");
$user_data = null;

if (strlen($data) > 0) {
  $user_data = json_decode($data, true);
} else {
  exit(json_encode(["success" => false, "message" => "Дължината е нула!"]));
}

$term = $user_data["term"];

try {
  $response = $userService->getUsersWithoutInvitation($term);

  if ($response["success"]) {
    exit(json_encode(["success" => true, "data" => $response["data"], "count" => $response["count"]]));
  } else {
    exit(json_encode(["success" => false, "message" => "Възникна проблем при взимането на поканите!"]));
  }
} catch (Exception $e) {
  exit(json_encode(["success" => false, "message" => $e->getMessage()]));
}
