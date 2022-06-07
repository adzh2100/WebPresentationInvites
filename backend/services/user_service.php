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

    $query = $this->userRepository->createUser([
      "username" => $user->username,
      "password" => $user->password,
      "firstName" => $user->fullName,
      "lastName" => $user->fullName,
      "email" => $user->email,
      "role" => $user->role,
      "facultyNumber" => $user->facultyNumber,
    ]);

    // do sth with the result
  }
}
