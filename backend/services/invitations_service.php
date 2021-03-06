<?php
require_once(realpath(dirname(__FILE__) . '/../db/repositories/invitations_repository.php'));
require_once(realpath(dirname(__FILE__) . '/../db/repositories/user_repository.php'));


class InvitationService
{

  private $invitationsRepository;
  private $userRepository;

  function __construct()
  {
    $this->invitationsRepository = new InvitationsRepository();
    $this->userRepository = new UserRepository();
  }


  public function getAllInvitations($role, $term)
  {
    if ($term == "") {
      try {
        $result = null;

        if ($role == "student") {
          $result = $this->invitationsRepository->getInvitations();
        } else {
          $result = $this->invitationsRepository->getInvitationsDetailed();
        }

        $invitations = [];

        while ($data = $result["data"]->fetch(PDO::FETCH_ASSOC)) {
          array_push($invitations, $data);
        }

        return ["success" => true, "data" => json_encode($invitations)];
      } catch (PDOException $e) {
        return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
      }
    } else {
      try {
        $result = null;

        if ($role == "student") {
          $result = $this->invitationsRepository->getInvitationsWithTerm($term);
        } else {
          $result = $this->invitationsRepository->getInvitationsWithTermDetailed($term);
        }

        $invitations = [];

        while ($data = $result["data"]->fetch(PDO::FETCH_ASSOC)) {
          array_push($invitations, $data);
        }

        return ["success" => true, "data" => json_encode($invitations)];
      } catch (PDOException $e) {
        return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
      }
    }
  }

  public function getAllInvitationsForCsv()
  {
    try {
      $result = null;
      $result = $this->invitationsRepository->getInvitationsForCSV();
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
    if ($this->isDateAndTimeUnique($invitation["date"], $invitation["time"], $invitation["user_id"]) == false) {
      return ["success" => false, "error" => "???????? ???????? ???? ???????? ?? ?????? ???????? ?? ????????! ???????????? ?? ????????!"];
    } elseif ($this->isFacultyNumberValid($invitation["faculty_number"]) == false) {
      return ["success" => false, "error" => "???????? ???????????????????? ?????????? ???? ?? ??????????????!"];
    }

    $response = $this->userRepository->getUserByAcademicalNumber($invitation["faculty_number"]);
    $belongs_to = $response["data"]->fetch(PDO::FETCH_ASSOC);


    return $this->invitationsRepository->createInvitations([
      "presentation_theme" => $invitation["presentation_theme"],
      "user_id" => $belongs_to["id"],
      "date" => $invitation["date"],
      "time" => $invitation["time"],
      "description" => $invitation["description"],
      "auto_generated" => $invitation["auto_generated"],
      "image" => $invitation["image"]
    ]);
  }

  private function isDateAndTimeUnique($date, $time, $user_id)
  {
    $data = [
      "date" => $date,
      "time" => $time,
      "user_id" => $user_id
    ];
    return empty($this->invitationsRepository->getInvitationsByDateAndTime($data)["data"]->fetch(PDO::FETCH_ASSOC));
  }

  private function isFacultyNumberValid($faculty_number)
  {
    $fn_regex = '/^[0-9]{5,10}$/';
    if (!preg_match($fn_regex, $faculty_number)) {
      return false;
    }
    return true;
  }

  public function getInvitationByUserId($user_id)
  {
    try {
      $result = $this->invitationsRepository->getInvitationByUserId($user_id);
      $invitation = $result["data"]->fetch(PDO::FETCH_ASSOC);
      return ["success" => true, "data" => json_encode($invitation)];
    } catch (PDOException $e) {
      return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    }
  }
}
