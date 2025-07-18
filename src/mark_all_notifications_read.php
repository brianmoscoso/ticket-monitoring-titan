<?php
session_start();
require_once './Database.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['logged-in']) || $_SESSION['logged-in'] == false) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit();
}

$db = Database::getInstance();

$team_id = $_SESSION['team_id'] ?? 0;
$user_id = $_SESSION['user_id'] ?? 0;

if ($team_id == 0 && $user_id == 0) {
    echo json_encode(["status" => "error", "message" => "Missing team or user ID"]);
    exit();
}

$sql = "UPDATE notifications 
        SET is_read = 1 
        WHERE (team_id = ? OR user_id = ?)";

$stmt = $db->prepare($sql);
$stmt->bind_param("ii", $team_id, $user_id);

if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to update notifications"]);
}

$stmt->close();
