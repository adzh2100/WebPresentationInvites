
<?php
require_once(realpath(dirname(__FILE__) . '/../services/invitations_service.php'));
$invitationService = new InvitationService();
$data = file_get_contents("php://input");
$invitation_data = null;
if (strlen($data) > 0) {
    $invitation_data = json_encode($data, true);
} else {
    exit(json_encode(["success" => false, "message" => "Дължината е нула!"]));
}

$presentation_theme = $invitation_data["presentation_theme"];
$date = $invitation_data["date"];
$time = $invitation_data["time"];
$description = $invitation_data["description"];
$first_name = $invitation_data["first_name"];
$last_name = $invitation_data["last_name"];
$faculty_number = $invitation_data["faculty_number"];

try {
    $response = $invitationService->createInvitation([
        "presentation_theme" => $presentation_theme,
        "date" => $date,
        "time" => $time,
        "description" => $description,
        "first_name" => $first_name,
        "last_name" => $last_name,
        "faculty_number" => $faculty_number,
    ]);

    if ($response["success"] == true) {
        $invitation_id = $response["data"];

        session_start();
        $invitation = array(
            "presentation_theme" => $presentation_theme,
            "date" => $date,
            "time" => $time,
            "description" => $description,
            "first_name" => $first_name,
            "last_name" => $last_name,
            "faculty_number" => $faculty_number,
        );
        $_SESSION["invitation"] = $invitation;

        exit(json_encode(["success" => true, "message" => "Успешно записване на покана!", "data" => json_encode($invitation)]));
    } else {
        exit(json_encode(["success" => false, "error" => $response["error"]]));
    }
} catch (PDOException $exc) {
    exit(json_encode(["success" => false, "error" => "Connection failed: " . $exc->getMessage()]));
}
