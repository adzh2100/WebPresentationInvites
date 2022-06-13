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
    $email_regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
    $username_regex = '/^[a-zA-Z_0-9-]*$/';

    if ($this->isUsernameUnique($user["username"]) == false) {
      return ["success" => false, "error" => "Съществува потребител със същото потребителско име!"];
    }
    if ($this->isAcademicalNumberUnique($user["academicalNumber"]) == false) {
      return ["success" => false, "error" => "Съществува потребител със същия факултетен номер!"];
    }
    if ($this->isEmailUnique($user["email"]) == false) {
      return ["success" => false, "error" => "Съществува потребител със същия имейл!"];
    }

    if (strlen($user["username"]) > 30 || strlen($user["username"]) < 5 || !preg_match($username_regex, $user["username"])) {
      return ["success" => false, "error" => "Невалидно потребителско име!"];
    }
    if (
      !preg_match($email_regex, $user["email"]) ||
      $user["email"] > 70
    ) {
      return ["success" => false, "error" => "Невалиден имейл!"];
    }
    if (strlen($user["firstName"]) > 20) {
      return ["success" => false, "error" => "Името трябва да бъде по- малко от 20 символа и да съдържа само букви!"];
    }
    if (strlen($user["lastName"]) > 20) {
      return ["success" => false, "error" => "Името трябва да бъде по- малко от 20 символа и да съдържа само букви!"];
    }
    if (strlen(strval($user["academicalNumber"])) > 10) {
      return ["success" => false, "error" => "Невалиден факултетен номер!"];
    }

    return $this->userRepository->createUser([
      "username" => $user["username"],
      "password" => $user["password"],
      "firstName" => $user["firstName"],
      "lastName" => $user["lastName"],
      "email" => $user["email"],
      "specification" => $user["specification"],
      "year" => $user["year"],
      "academicalNumber" => $user["academicalNumber"],
      "role" => $user["role"]
    ]);
  }

  public function checkUser($username, $password)
  {
    $user = $this->userRepository->getUserByUsername($username);

    $resultData = $user["data"]->fetch(PDO::FETCH_ASSOC);
    if (!$user["success"] || empty($resultData) || strcmp(md5($password), $resultData["password"]) != 0) {
      return ["success" => false, "error" => "Грешно потребителско име или парола."];
    }

    session_start();
    return ["success" => true, "data" => $resultData["id"]];
  }

  public function getCurrentUser()
  {
    $id = $_SESSION['user_id'];
    return $this->userRepository->getUserById($id);
  }

  public function getUsersWithoutInvitation()
  {
    try {
      $result = $this->userRepository->getUsersWithoutInvitation();
      $countResult = $this->userRepository->getTotalUsersCount();

      $users = [];

      while ($data = $result["data"]->fetch(PDO::FETCH_ASSOC)) {
        array_push($users, $data);
      }

      $count = $result["data"]->fetch(PDO::FETCH_ASSOC);

      return ["success" => true, "data" => json_encode($users), "count" => $count];
    } catch (PDOException $e) {
      return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    }
  }

  private function isUsernameUnique($username)
  {
    return empty($this->userRepository->getUserByUsername($username)["data"]->fetch(PDO::FETCH_ASSOC));
  }

  private function isEmailUnique($email)
  {
    return empty($this->userRepository->getUserByEmail($email)["data"]->fetch(PDO::FETCH_ASSOC));
  }

  private function isAcademicalNumberUnique($fn)
  {
    return empty($this->userRepository->getUserByAcademicalNumber($fn)["data"]->fetch(PDO::FETCH_ASSOC));
  }
}
