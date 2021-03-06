<?php
require_once(realpath(dirname(__FILE__) . '/../services/user_service.php'));

$userService = new UserService();

$data = file_get_contents("php://input");

$user_data = null;
if (strlen($data) > 0) $user_data = json_decode($data, true);
else exit(json_encode(["success" => false, "message" => "Дължината е нула!"]));

$username = $user_data["username"];
$email = $user_data["email"];
$firstName = $user_data["firstName"];
$lastName = $user_data["lastName"];
$academicalNumber = array_key_exists("facultyNumber", $user_data) ? $user_data["facultyNumber"] : $user_data["teacherNumber"];
$password = $user_data["password"];
$repeated_password = $user_data["rePassword"];
$specification = array_key_exists("specification", $user_data) ? $user_data["specification"] : null;
$year = array_key_exists("year", $user_data) ? $user_data["year"] : null;
$role = $user_data["role"];
$md5_password = md5($password);

if ($password != $repeated_password) {
  exit(json_encode(["success" => false, "message" => "Паролите не съвпадат!"]));
}

try {
  $response = $userService->createUser([
    "username" => $username,
    "password" => $md5_password,
    "firstName" => $firstName,
    "lastName" => $lastName,
    "email" => $email,
    "specification" => $specification,
    "year" => $year,
    "academicalNumber" => $academicalNumber,
    "role" => $role
  ]);

  if ($response["success"] == true) {
    $user_id = $response["data"];

    session_start();
    $user = array("id" => $user_id, "username" => $username, "first_name" => $firstName, "last_name" => $lastName,  "academical_number" => $academicalNumber, "email" => $email, "password" => $md5_password, "specification" => $specification, "year" => $year, "role" => $role);
    $_SESSION["user"] = $user;

    unset($user["password"]);
    exit(json_encode(["success" => true, "message" => "Успешна регистрация!", "data" => json_encode($user)]));
  } else {
    exit(json_encode(["success" => false, "error" => $response["error"]]));
  }
} catch (PDOException $e) {
  exit(json_encode(["success" => false, "error" => "Connection failed: " . $e->getMessage()]));
}
