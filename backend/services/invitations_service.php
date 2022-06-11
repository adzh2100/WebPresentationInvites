<?php
require_once(realpath(dirname(__FILE__) . '/../db/repositories/invitations_repository.php'));

class InvitationService
{

  private $invitationsRepository;

  function __construct()
  {
    $this->invitationsRepository = new InvitationsRepository();
  }


  public function getAllInvitations()
  {
    try {
      $result = $this->invitationsRepository->getInvitations();
      $invitations = [];

      while ($data = $result["data"]->fetch(PDO::FETCH_ASSOC)) {
        array_push($invitations, $data);
      }

      return ["success" => true, "data" => json_encode($invitations)];
    } catch (PDOException $e) {
      return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    }
  }

  public function createInvitation($invitation)
  {
    if ($this->isDateAndTimeUnique($invitation["date"], $invitation["time"]) == false) {
      return ["success" => false, "error" => "Този слот от дата и час вече е зает! Опитай с друг!"];
    } elseif ($this->isFacultyNumberValid($invitation["faculty_number"]) == false) {
      return ["success" => false, "error" => "Този факултетен номер не е валиден!"];
    } elseif ($this->isFacultyNumberUnique($invitation["faculty_number"]) == false) {
      return ["success" => false, "error" => "Този факултетен номер се използва от друг човек с покана в системата!"];
    }
    return $this->invitationsRepository->createInvitations([
      "presentation_theme" => $invitation["presentation_theme"],
      "date" => $invitation["date"],
      "time" => $invitation["time"],
      "description" => $invitation["description"],
      "first_name" => $invitation["first_name"],
      "last_name" => $invitation["last_name"],
      "faculty_number" => $invitation["faculty_number"],
    ]);
  }

  private function isDateAndTimeUnique($date, $time)
  {
    return empty($this->invitationsRepository->getInvitations($date)["data"]->fetch(PDO::FETCH_ASSOC)) and empty($this->invitationsRepository->getInvitations($time)["data"]->fetch(PDO::FETCH_ASSOC));
  }

  private function isFacultyNumberValid($faculty_number)
  {
    $fn_regex = '^[\d]{5,10}$';
    if (!preg_match($fn_regex, $faculty_number)) {
      return false;
    }
  }

  private function isFacultyNumberUnique($faculty_number)
  {
    return empty($this->invitationsRepository->getInvitations($faculty_number)["data"]->fetch(PDO::FETCH_ASSOC));
  }
}
