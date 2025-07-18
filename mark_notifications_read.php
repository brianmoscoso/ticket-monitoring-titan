<?php
session_start();
require_once './src/Database.php';

$db = Database::getInstance();

// Ensure user is logged in
if (!isset($_SESSION['logged-in']) || $_SESSION['logged-in'] == false) {
    http_response_code(403);
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}

// Get the logged-in team ID
$logged_in_team_id = $_SESSION['team_id'] ?? null;

if (!$logged_in_team_id) {
    http_response_code(400);
    echo json_encode(["error" => "Missing team_id"]);
    exit();
}

// Update notifications to mark them as read
$sql = "UPDATE notifications SET is_read = 1 WHERE team_id = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $logged_in_team_id);

if ($stmt->execute()) {
    echo json_encode(["success" => "Notifications marked as read"]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "Database error"]);
}
