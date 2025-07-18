<?php
session_start();
require_once '../src/Database.php';

header('Content-Type: application/json');

// 1. Make sure the user is authenticated
if (!isset($_SESSION['logged-in']) || $_SESSION['logged-in'] !== true) {
    echo json_encode(["status" => "error", "message" => "User not logged in"]);
    exit();
}

$db      = Database::getInstance();
$team_id = $_SESSION['team_id'] ?? 0;
$user_id = $_SESSION['user_id'] ?? 0;

if ($team_id == 0 && $user_id == 0) {
    echo json_encode(["status" => "error", "message" => "Missing identifiers"]);
    exit();
}

/* 2. Fetch notifications for this user OR their team
      –  also pull site_name so we can build a site URL.
*/
$sql = "
    SELECT n.id,
           n.message,
           n.ticket_id,
           n.site_name,      -- NEW
           n.is_read
    FROM   notifications n
    WHERE  (n.team_id = ? OR n.user_id = ?)
    ORDER  BY n.created_at DESC
";

$stmt = $db->prepare($sql);
$stmt->bind_param("ii", $team_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

$notifications = [];

/* 3. Build a single 'url' for each notification */
while ($row = $result->fetch_assoc()) {

    // Decide where the link should go
    $url = "#";
    if (!empty($row['ticket_id'])) {
        $url = "ticket-details.php?id=" . $row['ticket_id'];
    } elseif (!empty($row['site_name'])) {
        $url = "site-tickets.php?site=" . urlencode($row['site_name']);
    }

    $notifications[] = [
        "id"         => $row['id'],
        "message"    => htmlspecialchars($row['message']),
        "is_read"    => $row['is_read'],
        "url"        => $url,                     // unified link
        "ticket_id"  => $row['ticket_id'],        // optional: keep raw values
        "site_name"  => $row['site_name']         // optional: keep raw values
    ];
}

$stmt->close();

echo json_encode([
    "status"        => "success",
    "notifications" => $notifications
]);
