<?php

require_once(realpath(dirname(__FILE__) . '/../services/mail_service.php'));



$mailService = new MailService();

session_start();

$data = file_get_contents("php://input");

$user_data = null;
if (strlen($data) > 0) $user_data = json_decode($data, true);
else exit(json_encode(["success" => false, "message" => "Дължината е нула!"]));

try {
  $send = $mailService->sendMail($user_data, $_SESSION["user_id"]);
  if ($send["success"]) {
    exit(json_encode(["success" => true, "message" => "Успешно изпратихте e-mail!", "data" => $send["data"]]));
  } else {
    exit(json_encode(["success" => false, "message" => "Неуспешно изпращане", "data" => $send["data"]]));
  }
} catch (Exception $e) {
  exit(json_encode(["success" => false, "message" => $e->getMessage()]));
}
