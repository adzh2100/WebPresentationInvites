<?php
require_once(realpath(dirname(__FILE__) . '/../services/user_service.php'));

$userService = new UserService();

$data = file_get_contents("php://input");

$user_data = null;
if (strlen($data) > 0) $user_data = json_decode($data, true);
else exit(json_encode(["success" => false, "message" => "Дължината е нула!"]));

$username = $user_data["username"];
$password = $user_data["password"];

try {
  $userId = $userService->checkUser($username, $password);
  $_SESSION['user_id'] = $userId;

  $info = $userService->getCurrentUser()["data"]->fetch(PDO::FETCH_ASSOC);

  $_SESSION['username'] = $info["username"];
  $_SESSION["first_name"] = $info["first_name"];
  $_SESSION["last_name"] = $info["last_name"];
  $_SESSION["email"] = $info["email"];
  $_SESSION["faculty_number"] = $info["faculty_number"];
  $_SESSION["specification"] = $info["specification"];
  $_SESSION["year"] = $info["year"];

  exit(json_encode(["success" => true, "message" => "Успешен вход!", "data" => json_encode($info)]));
} catch (PDOException $e) {
  exit(json_encode(["success" => false, "error" => "Connection failed: " . $e->getMessage()]));
}
