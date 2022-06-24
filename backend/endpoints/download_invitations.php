<?php

require_once(realpath(dirname(__FILE__) . '/../services/invitations_service.php'));

$invitationsService = new InvitationService();

$invitation_data = null;
$data = file_get_contents("php://input");

if (strlen($data) > 0) {
    $invitation_data = json_decode($data, true);
} else {
    exit(json_encode(["success" => false, "message" => "Дължината е нула!"]));
}

try {
    $response = $invitationsService->getAllInvitationsForCsv();
    if ($response["success"]) {
        $f = fopen('php://memory', 'w');
        $output_file_name = "export.csv";

        $header = [
            "Тема",
            "Дата",
            "Час",
            "Описание",
            "Представящ",
            "Факултетен номер",
            "Автоматично генерирано",
            "Качена"
        ];

        fputcsv($f, (array)$header, ':');

        foreach (json_decode($response['data']) as $line) {
            fputcsv($f, (array)$line, ':');
        }
        fseek($f, 0);
        header('Content-Type: application/csv; charset=UTF-8;');
        header('Content-Disposition: attachement; filename="' . $output_file_name . '";');
        fpassthru($f);
    }
} catch (Exception $e) {
    return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
}
