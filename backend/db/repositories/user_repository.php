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
      $sql = "INSERT INTO users(username, password, first_name, last_name, email, specification, year, faculty_number)
      VALUES(:username, :password, :first_name, :last_name, :email, :specification, :year, :faculty_number)";
      $this->createUser = $this->database->getConnection()->prepare($sql);
      $this->createUser->execute(
        [
          "username" => $data["username"],
          "password" => $data["password"],
          "first_name" => $data["firstName"],
          "last_name" => $data["lastName"],
          "email" => $data["email"],
          "faculty_number" => $data["facultyNumber"],
          "specification" => $data["specification"],
          "year" => $data["year"]
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
      $sql = "SELECT username, first_name, last_name, faculty_number, email, specification, year FROM users WHERE id=:id";
      $currentUserData = $this->database->getConnection()->prepare($sql);
      $currentUserData->execute(["id" => $id]);
      $this->database->getConnection()->commit();
      return ["success" => true, "data" => $currentUserData];
    } catch (PDOException $e) {
      $this->database->getConnection()->rollBack();
      return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    }
  }

  public function getUserByFacultyNumber($faculty_number)
  {
    $this->database->getConnection()->beginTransaction();

    try {
      $sql = "SELECT * FROM users WHERE faculty_number=:faculty_number";
      $userData = $this->database->getConnection()->prepare($sql);
      $userData->execute(["faculty_number" => $faculty_number]);
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
}
