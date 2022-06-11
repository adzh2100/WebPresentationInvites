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
}
