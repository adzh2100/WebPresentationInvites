<?php

require_once(realpath(dirname(__FILE__) . '/../db/repositories/user_repository.php'));

class UserService
{
  private $userRepository;

  public function __construct()
  {
    $this->userRepository = new UserRepository();
  }

  public function createUser($user)
  {
    // Validate

    return $this->userRepository->createUser([
      "username" => $user["username"],
      "password" => $user["password"],
      "firstName" => $user["firstName"],
      "lastName" => $user["lastName"],
      "email" => $user["email"],
      "role" => $user["role"],
      "facultyNumber" => $user["facultyNumber"],
    ]);
  }

  public function checkUser($username, $password)
  {
    $user = $this->userRepository->getUserByUsername($username);

    $resultData = $user["data"]->fetch(PDO::FETCH_ASSOC);
    if (!$user["success"] || empty($resultData)) {
      throw new Exception("Грешно потребителско име или парола.");
    }

    if (strcmp(md5($password), $resultData["password"]) != 0) {
      throw new Exception("Грешно потребителско име или паролa.");
    }

    session_start();
    return $resultData["id"];
  }

  public function getCurrentUser()
  {
    $id = $_SESSION['user_id'];
    return $this->userRepository->getUserById($id);
  }
}
