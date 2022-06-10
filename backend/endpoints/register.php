<?php
require_once(realpath(dirname(__FILE__) . '/../services/user_service.php'));

$userService = new UserService();

$data = file_get_contents("php://input");

$user_data = null;
if (strlen($data) > 0) $user_data = json_decode($data, true);
else exit(json_encode(["success" => false, "message" => "Дължината е нула!"]));

$username = $user_data["username"];
$email = $user_data["email"];
$firstname = $user_data["firstName"];
$lastname = $user_data["lastName"];
$fn = $user_data["facultyNumber"];
$password = $user_data["password"];
$repeated_password = $user_data["rePassword"];
$role = $user_data["role"];
$md5_password = md5($password);

if ($password != $repeated_password) {
  exit(json_encode(["success" => false, "message" => "Паролите не съвпадат!"]));
}

try {
  $db = new Database();
  $connection = $db->getConnection();

  // make a func for this in the user service
  $sql = "SELECT * FROM users WHERE email = :email";

  $statement = $connection->prepare($sql);
  $statement->execute(["email" => $email]);

  if ($statement->rowCount() != 0) {
    exit(json_encode(["success" => false, "error" => "Потребител с този имейл адрес вече съществува!"]));
  }
} catch (PDOException $e) {
  return json_encode(["success" => false, "error" => "Connection failed: " . $e->getMessage()]);
}

try {
  // use the function from the user service????

  $response = $userService->createUser([
    "username" => $username,
    "password" => $md5_password,
    "firstName" => $firstname,
    "lastName" => $lastname,
    "email" => $email,
    "role" => $role,
    "facultyNumber" => $fn,
  ]);

  if ($response["success"] == true) {
    exit(json_encode(["success" => true, "message" => "Успешна регистрация!", "response" => $response]));
  } else {
    exit(json_encode(["success" => false, "error" => "Connection failed: " . $e->getMessage()]));
  }
} catch (PDOException $e) {
  exit(json_encode(["success" => false, "error" => "Connection failed: " . $e->getMessage()]));
}
