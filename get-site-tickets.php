<?php
require_once './src/Database.php';

// Set JSON header
header('Content-Type: application/json');

if (!isset($_GET['site']) || empty($_GET['site'])) {
    echo json_encode(["error" => "Site parameter is missing"]);
    exit;
}

$site = $_GET['site'];

try {
    $db = Database::getInstance();
    $stmt = $db->prepare("SELECT id, project, status, team_assigned, priority FROM ticket WHERE site_name = ?");
    
    if (!$stmt) {
        echo json_encode(["error" => "Database error: " . $db->error]);
        exit;
    }

    $stmt->bind_param("s", $site);
    $stmt->execute();
    $result = $stmt->get_result();

    $tickets = [];
    while ($row = $result->fetch_assoc()) {
        $tickets[] = $row;
    }

    echo json_encode(["tickets" => $tickets]);
} catch (Exception $e) {
    echo json_encode(["error" => "Error fetching tickets: " . $e->getMessage()]);
}
