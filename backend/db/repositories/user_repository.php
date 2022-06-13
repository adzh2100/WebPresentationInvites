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
      $sql = "INSERT INTO users(username, password, first_name, last_name, email, specification, year, academical_number, role)
      VALUES(:username, :password, :first_name, :last_name, :email, :specification, :year, :academical_number, :role)";
      $this->createUser = $this->database->getConnection()->prepare($sql);
      $this->createUser->execute(
        [
          "username" => $data["username"],
          "password" => $data["password"],
          "first_name" => $data["firstName"],
          "last_name" => $data["lastName"],
          "email" => $data["email"],
          "academical_number" => $data["academicalNumber"],
          "specification" => $data["specification"],
          "year" => $data["year"],
          "role" => $data["role"]
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
      $sql = "SELECT username, first_name, last_name, academical_number, email, specification, year, role FROM users WHERE id=:id";
      $currentUserData = $this->database->getConnection()->prepare($sql);
      $currentUserData->execute(["id" => $id]);
      $this->database->getConnection()->commit();
      return ["success" => true, "data" => $currentUserData];
    } catch (PDOException $e) {
      $this->database->getConnection()->rollBack();
      return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    }
  }

  public function getUserByAcademicalNumber($academical_number)
  {
    $this->database->getConnection()->beginTransaction();

    try {
      $sql = "SELECT * FROM users WHERE academical_number=:academical_number";
      $userData = $this->database->getConnection()->prepare($sql);
      $userData->execute(["academical_number" => $academical_number]);
      $this->database->getConnection()->commit();
      return ["success" => true, "data" => $userData];
    } catch (PDOException $e) {
      $this->database->getConnection()->rollBack();
      return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    }
  }

  public function getUserByEmail($email)
  {
    $this->database->getConnection()->beginTransaction();

    try {
      $sql = "SELECT * FROM users WHERE email=:email";
      $userData = $this->database->getConnection()->prepare($sql);
      $userData->execute(["email" => $email]);
      $this->database->getConnection()->commit();
      return ["success" => true, "data" => $userData];
    } catch (PDOException $e) {
      $this->database->getConnection()->rollBack();
      return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    }
  }

  public function getUserEmails($data)
  {
    $this->database->getConnection()->beginTransaction();

    try {
      $sql = "SELECT email FROM users WHERE id <> :user_id";
      $userData = $this->database->getConnection()->prepare($sql);
      $userData->execute(["user_id" => $data]);
      $this->database->getConnection()->commit();
      return ["success" => true, "data" => $userData];
    } catch (PDOException $e) {
      $this->database->getConnection()->rollBack();
      return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    }
  }

  public function getUsersWithoutInvitation($term)
  {
    $this->database->getConnection()->beginTransaction();

    try {
      $sql = "SELECT username, email, first_name, last_name, academical_number, specification, year FROM `users` WHERE id not in (SELECT user_id from `invitations`) and role <> 'teacher' and academical_number like '%{$term}%'";
      $userData = $this->database->getConnection()->prepare($sql);
      $userData->execute();
      $this->database->getConnection()->commit();
      return ["success" => true, "data" => $userData];
    } catch (PDOException $e) {
      $this->database->getConnection()->rollBack();
      return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    }
  }

  public function getTotalUsersCount()
  {
    $this->database->getConnection()->beginTransaction();

    try {
      $sql = "SELECT count(id) FROM `users` where role <> 'teacher'";
      $userData = $this->database->getConnection()->prepare($sql);
      $userData->execute();
      $this->database->getConnection()->commit();
      return ["success" => true, "data" => $userData];
    } catch (PDOException $e) {
      $this->database->getConnection()->rollBack();
      return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    }
  }
}
