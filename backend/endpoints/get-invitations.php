<?php

require_once(realpath(dirname(__FILE__) . '/../services/invitations_service.php'));

$invitationsService = new InvitationService();

$data = file_get_contents("php://input");
$invitation_data = null;

if (strlen($data) > 0) {
  $invitation_data = json_decode($data, true);
} else {
  exit(json_encode(["success" => false, "message" => "Дължината е нула!"]));
}

$role = $invitation_data["role"];

session_start();


try {
  $response = $invitationsService->getAllInvitations($role);

  if ($response["success"]) {
    exit(json_encode(["success" => true, "data" => $response["data"]]));
  } else {
    exit(json_encode(["success" => false, "message" => "Възникна проблем при взимането на поканите!"]));
  }
} catch (Exception $e) {
  exit(json_encode(["success" => false, "message" => $e->getMessage()]));
}
