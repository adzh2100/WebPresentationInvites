<?php

require_once(realpath(dirname(__FILE__) . '/../services/invitations_service.php'));

$userService = new UserService();

try {
  $response = $userService->getUsersWithoutInvitation();

  if ($response["success"]) {
    exit(json_encode(["success" => true, "data" => $response["data"], "count" => $response["count"]]));
  } else {
    exit(json_encode(["success" => false, "message" => "Възникна проблем при взимането на поканите!"]));
  }
} catch (Exception $e) {
  exit(json_encode(["success" => false, "message" => $e->getMessage()]));
}
