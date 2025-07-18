<?php
require_once __DIR__ . "/src/Database.php";
require_once __DIR__ . "/src/comment.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ticket_id"])) {
    $ticketId = $_POST["ticket_id"];
    $query = isset($_POST["query"]) ? trim($_POST["query"]) : "";

    if (empty($ticketId)) {
        echo json_encode(["success" => false, "error" => "Invalid Ticket ID."]);
        exit;
    }

    $worknotes = Comment::searchByTicket($ticketId, $query);
    echo json_encode(["success" => true, "worknotes" => $worknotes]);
} else {
    echo json_encode(["success" => false, "error" => "Invalid request."]);
}
?>
