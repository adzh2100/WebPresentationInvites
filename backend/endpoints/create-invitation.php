
<?php
require_once(realpath(dirname(__FILE__) . '/../services/invitations_service.php'));

$invitationService = new InvitationService();

$data = file_get_contents("php://input");
$invitation_data = null;

if (strlen($data) > 0) {
    $invitation_data = json_decode($data, true);
} else {
    exit(json_encode(["success" => false, "message" => "Дължината е нула!"]));
}

$presentation_theme = $invitation_data["theme"];
$date = $invitation_data["presentationDate"];
$time = $invitation_data["presentationTime"];
$description = $invitation_data["description"];
$faculty_number = $invitation_data["facultyNumber"];
$auto_generated = $invitation_data["autoGenerated"];
$image = array_key_exists('image', $invitation_data) ? $invitation_data["image"] : null;
$user_id = array_key_exists('user', $invitation_data) ? $invitation_data["user"] : null;

if ($image) {
    $image = str_replace('data:image/png;base64,', '', $image);
    $image = str_replace(' ', '+', $image);
    $image = base64_decode($image, true);
}

try {
    $response = $invitationService->createInvitation([
        "presentation_theme" => $presentation_theme,
        "date" => $date,
        "time" => $time,
        "description" => $description,
        "faculty_number" => $faculty_number,
        "auto_generated" => $auto_generated,
        "image" => $image,
        "user_id" => $user_id
    ]);

    if ($response["success"] == true) {
        exit(json_encode(["success" => true, "message" => "Успешно записване на покyна!", "data" => json_encode($response["data"])]));
    } else {
        exit(json_encode(["success" => false, "error" => $response["error"]]));
    }
} catch (PDOException $exc) {
    exit(json_encode(["success" => false, "error" => "Connection failed: " . $exc->getMessage()]));
}
