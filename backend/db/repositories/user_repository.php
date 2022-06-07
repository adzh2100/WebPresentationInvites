<?php
require_once(realpath(dirname(__FILE__) . '/../dbConnection.php'));
require_once(realpath(dirname(__FILE__) . '/../../entities/user.php'));

class UserRepository
{

  private $database;
  private $createUser;

  public function __construct()
  {
    $this->database = new Database();
  }

  public function createUser($data)
  {
    $this->database->getConnection()->beginTransaction();

    try {
      $sql = "INSERT INTO USERS VALUES(:username, :password, :fullName, :fullName, :email, :role, :facultyNumber)";
      $this->createUser = $this->database->getConnection()->prepare($sql);
      $this->createUser->execute($data);
      $this->database->getConnection()->commit();
      return ["success" => true];
    } catch (PDOException $e) {
      $this->database->getConnection()->rollBack();
      return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    }
  }
}
