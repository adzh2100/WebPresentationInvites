<?php

require_once(realpath(dirname(__FILE__) . '/../services/invitations_service.php'));

$invitationsService = new InvitationService();

session_start();


try {
  $response = $invitationsService->getAllInvitations();

  if ($response["success"]) {
    exit(json_encode(["success" => true, "data" => $response["data"]]));
  } else {
    exit(json_encode(["success" => false, "message" => "Възникна проблем при взимането на поканите!"]));
  }
} catch (Exception $e) {
  exit(json_encode(["success" => false, "message" => $e->getMessage()]));
}
