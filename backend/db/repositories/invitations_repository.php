<?php
require_once(realpath(dirname(__FILE__) . '/../db_connection.php'));

class InvitationsRepository
{
  private $database;

  public function __construct()
  {
    $this->database = new Database();
  }

  public function getInvitations()
  {
    $this->database->getConnection()->beginTransaction();

    try {
      $sql = "SELECT presentation_theme, date, time, description, first_name, last_name, academical_number, image, invitations.created_at FROM invitations JOIN users on invitations.user_id = users.id";
      $getInvitations = $this->database->getConnection()->prepare($sql);
      $getInvitations->execute();
      $this->database->getConnection()->commit();
      return ["success" => true, "data" => $getInvitations];
    } catch (PDOException $e) {
      $this->database->getConnection()->rollBack();
      return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    }
  }

  public function getInvitationsForCSV()
  {
    $this->database->getConnection()->beginTransaction();

    try {
      $sql = "SELECT presentation_theme, date, time, description, first_name, last_name, academical_number, auto_generated, invitations.created_at FROM invitations JOIN users on invitations.user_id = users.id";
      $getInvitations = $this->database->getConnection()->prepare($sql);
      $getInvitations->execute();
      $this->database->getConnection()->commit();
      return ["success" => true, "data" => $getInvitations];
    } catch (PDOException $e) {
      $this->database->getConnection()->rollBack();
      return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    }
  }

  public function getInvitationsWithTerm($term)
  {
    $this->database->getConnection()->beginTransaction();

    try {
      $sql = "SELECT presentation_theme, date, time, description, first_name, last_name, academical_number, image, invitations.created_at
              FROM invitations JOIN users on invitations.user_id = users.id
              WHERE presentation_theme LIKE '%{$term}%'";
      $getInvitations = $this->database->getConnection()->prepare($sql);
      $getInvitations->execute();
      $this->database->getConnection()->commit();
      return ["success" => true, "data" => $getInvitations];
    } catch (PDOException $e) {
      $this->database->getConnection()->rollBack();
      return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    }
  }

  public function getInvitationsDetailed()
  {
    $this->database->getConnection()->beginTransaction();

    try {
      $sql = "SELECT presentation_theme, date, time, description, first_name, last_name, academical_number, auto_generated, image, invitations.created_at FROM invitations JOIN users on invitations.user_id = users.id";
      $getInvitations = $this->database->getConnection()->prepare($sql);
      $getInvitations->execute();
      $this->database->getConnection()->commit();
      return ["success" => true, "data" => $getInvitations];
    } catch (PDOException $e) {
      $this->database->getConnection()->rollBack();
      return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    }
  }

  public function getInvitationsWithTermDetailed($term)
  {
    $this->database->getConnection()->beginTransaction();

    try {
      $sql = "SELECT presentation_theme, date, time, description, first_name, last_name, academical_number, auto_generated, image, invitations.created_at
      FROM invitations JOIN users on invitations.user_id = users.id
      WHERE presentation_theme LIKE '%{$term}%'";
      $getInvitations = $this->database->getConnection()->prepare($sql);
      $getInvitations->execute();
      $this->database->getConnection()->commit();
      return ["success" => true, "data" => $getInvitations];
    } catch (PDOException $e) {
      $this->database->getConnection()->rollBack();
      return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    }
  }

  public function getInvitationsByDateAndTime($data)
  {
    $this->database->getConnection()->beginTransaction();

    try {
      $sql = "SELECT * from invitations where date=:date and time=:time and user_id <> :user_id";
      $getInvitations = $this->database->getConnection()->prepare($sql);
      $getInvitations->execute([
        "date" => $data["date"],
        "time" => $data["time"],
        "user_id" => $data["user_id"]
      ]);
      $this->database->getConnection()->commit();
      return ["success" => true, "data" => $getInvitations];
    } catch (PDOException $e) {
      $this->database->getConnection()->rollBack();
      return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    }
  }

  public function createInvitations($data)
  {
    $this->database->getConnection()->beginTransaction();
    try {
      $sql = "INSERT INTO invitations(presentation_theme, date, time, description, user_id, auto_generated, image)
      VALUES(:presentation_theme, :date, :time, :description, :user_id, :auto_generated, :image)";
      $this->createInvitations = $this->database->getConnection()->prepare($sql);
      $this->createInvitations->execute(
        [
          "presentation_theme" => $data["presentation_theme"],
          "date" => $data["date"],
          "time" => $data["time"],
          "description" => $data["description"],
          "user_id" => $data["user_id"],
          "auto_generated" => (int)$data["auto_generated"],
          "image" => base64_encode($data["image"])
        ]
      );
      $this->database->getConnection()->commit();
      $invitationId = $this->database->getConnection()->lastInsertId();
      return ["success" => true, "data" => $data];
    } catch (PDOException $exception) {
      $this->database->getConnection()->rollBack();
      return ["success" => false, "error" => "Connection failed: " . $exception->getMessage()];
    }
  }

  public function getInvitationByUserId($user_id)
  {
    $this->database->getConnection()->beginTransaction();
    try {
      $sql = "SELECT presentation_theme, date, time, description FROM invitations where user_id={$user_id}";
      $this->createInvitations = $this->database->getConnection()->prepare($sql);
      $this->createInvitations->execute();
      $this->database->getConnection()->commit();
      return ["success" => true, "data" => $this->createInvitations];
    } catch (PDOException $exception) {
      $this->database->getConnection()->rollBack();
      return ["success" => false, "error" => "Connection failed: " . $exception->getMessage()];
    }
  }
}
