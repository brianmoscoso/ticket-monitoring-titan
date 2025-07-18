<?php
session_start();
require_once './src/Database.php';

if (!isset($_SESSION['logged-in']) || $_SESSION['logged-in'] == false) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit();
}

if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
    exit();
}

$db = Database::getInstance();
$notification_id = $_POST['id'];
$logged_in_team_id = $_SESSION['team_id'] ?? 0;

// Update only the selected notification
$update_sql = "UPDATE notifications SET is_read = 1 WHERE id = ? AND team_id = ?";
$update_stmt = $db->prepare($update_sql);
$update_stmt->bind_param("ii", $notification_id, $logged_in_team_id);

if ($update_stmt->execute() && $update_stmt->affected_rows > 0) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to update notification"]);
}

$update_stmt->close();
?>
