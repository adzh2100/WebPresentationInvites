<?php
require_once(realpath(dirname(__FILE__) . '/../db_connection.php'));
require_once(realpath(dirname(__FILE__) . '/../../entities/user.php'));

class UserRepository
{

  private $database;
  private $createUser;
  private $getByUsername;

  public function __construct()
  {
    $this->database = new Database();
  }

  public function createUser($data)
  {
    $this->database->getConnection()->beginTransaction();

    try {
      $sql = "INSERT INTO users(username, password, first_name, last_name, email, role, faculty_number)
      VALUES(:username, :password, :first_name, :last_name, :email, :role, :faculty_number)";
      $this->createUser = $this->database->getConnection()->prepare($sql);
      $this->createUser->execute(
        [
          "username" => $data["username"],
          "password" => $data["password"],
          "first_name" => $data["firstName"],
          "last_name" => $data["lastName"],
          "email" => $data["email"],
          "role" => $data["role"],
          "faculty_number" => $data["facultyNumber"]
        ]
      );

      $this->database->getConnection()->commit();
      $userId = $this->database->getConnection()->lastInsertId();

      return ["success" => true, "data" => $userId];
    } catch (PDOException $e) {
      $this->database->getConnection()->rollBack();
      return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    }
  }

  public function getUserByUsername($username)
  {
    $this->database->getConnection()->beginTransaction();

    try {
      $sql = "SELECT * FROM users WHERE username=:username";
      $this->getByUsername = $this->database->getConnection()->prepare($sql);
      $this->getByUsername->execute(["username" => $username]);
      $this->database->getConnection()->commit();
      return ["success" => true, "data" => $this->getByUsername];
    } catch (PDOException $e) {
      $this->database->getConnection()->rollBack();
      return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    }
  }

  public function getUserById($id)
  {
    $this->database->getConnection()->beginTransaction();

    try {
      $sql = "SELECT username, first_name, last_name, faculty_number, email, role FROM users WHERE id=:id";
      $currentUserData = $this->database->getConnection()->prepare($sql);
      $currentUserData->execute(["id" => $id]);
      $this->database->getConnection()->commit();
      return ["success" => true, "data" => $currentUserData];
    } catch (PDOException $e) {
      $this->database->getConnection()->rollBack();
      return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    }
  }
}
