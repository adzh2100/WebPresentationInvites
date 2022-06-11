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
$facultyNumber = $user_data["facultyNumber"];
$password = $user_data["password"];
$repeated_password = $user_data["rePassword"];
$specification = $user_data["specification"];
$year = $user_data["year"];
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
    "facultyNumber" => $facultyNumber,
  ]);

  if ($response["success"] == true) {
    $user_id = $response["data"];

    session_start();
    $user = array("id" => $user_id, "username" => $username, "first_name" => $firstName, "last_name" => $lastName,  "faculty_number" => $facultyNumber, "email" => $email, "password" => $md5_password, "specification" => $specification, "year" => $year);
    $_SESSION["user"] = $user;
    exit(json_encode(["success" => true, "message" => "Успешна регистрация!", "response" => $response]));
  } else {
    exit(json_encode(["success" => false, "error" => $response["error"]]));
  }
} catch (PDOException $e) {
  exit(json_encode(["success" => false, "error" => "Connection failed: " . $e->getMessage()]));
}
