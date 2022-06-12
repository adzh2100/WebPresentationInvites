<?php
require_once(realpath(dirname(__FILE__) . '/../db/repositories/user_repository.php'));

class MailService
{

  private $userRepository;

  function __construct()
  {
    $this->userRepository = new UserRepository();
  }


  public function sendMail($data, $user_id)
  {
    $emails = $this->userRepository->getUserEmails($user_id);
    $recipients = '';
    while ($email = $emails["data"]->fetch(PDO::FETCH_ASSOC)) {
      $recipients .= $email["email"] . ', ';
    }

    $subject = "Покана за презентация по уеб";
    $message = $data["message"];
    $sender = "From: webinvitations2022@gmail.com";

    return ["success" => mb_send_mail($recipients, $subject, $message, $sender), "data" => $recipients];
  }
}
