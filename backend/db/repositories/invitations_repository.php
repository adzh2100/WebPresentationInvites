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
      $sql = "SELECT presentation_theme, date, time, description, first_name, last_name, academical_number FROM invitations JOIN users on invitations.user_id = users.id";
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
      $sql = "SELECT presentation_theme, date, time, description, first_name, last_name, academical_number
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
      $sql = "SELECT presentation_theme, date, time, description, first_name, last_name, academical_number, auto_generated FROM invitations JOIN users on invitations.user_id = users.id";
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
      $sql = "SELECT presentation_theme, date, time, description, first_name, last_name, academical_number, auto_generated
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
      $sql = "SELECT * from invitations where date=:date and time=:time";
      $getInvitations = $this->database->getConnection()->prepare($sql);
      $getInvitations->execute([
        "date" => $data["date"],
        "time" => $data["time"]
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
      $sql = "INSERT INTO invitations(presentation_theme, date, time, description, user_id, auto_generated)
      VALUES(:presentation_theme, :date, :time, :description, :user_id, :auto_generated)";
      $this->createInvitations = $this->database->getConnection()->prepare($sql);
      $this->createInvitations->execute(
        [
          "presentation_theme" => $data["presentation_theme"],
          "date" => $data["date"],
          "time" => $data["time"],
          "description" => $data["description"],
          "user_id" => $data["user_id"],
          "auto_generated" => (int)$data["auto_generated"],
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
}
