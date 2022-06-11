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
}
