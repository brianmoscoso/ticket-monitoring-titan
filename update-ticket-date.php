<?php
// Read JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Debugging logs
error_log("Received data: " . print_r($data, true));

// Extract values
$id = isset($data['id']) ? $data['id'] : null;
$new_date_from = isset($data['new_date_from']) ? $data['new_date_from'] : null;
$new_date_to = isset($data['new_date_to']) ? $data['new_date_to'] : null;

// Debugging logs
error_log("Extracted ID: " . $id);
error_log("Extracted New Start Date: " . $new_date_from);
error_log("Extracted New End Date: " . $new_date_to);

// Validate fields
if (!$id || !$new_date_from || !$new_date_to) {
    error_log("❌ Missing required fields.");
    echo json_encode(["success" => false, "error" => "Missing required fields."]);
    exit;
}

// Proceed with database update
require_once './src/Database.php';
$db = Database::getInstance();

try {
    // ✅ Update schedule_date to match schedule_date_from
    $stmt = $db->prepare("UPDATE ticket SET schedule_date = ?, schedule_date_from = ?, schedule_date_to = ? WHERE id = ?");
    $stmt->bind_param("sssi", $new_date_from, $new_date_from, $new_date_to, $id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            error_log("✅ Ticket ID $id updated successfully.");
            echo json_encode(["success" => true]);
        } else {
            error_log("⚠️ No rows affected. Either ticket ID does not exist or date is the same.");
            echo json_encode(["success" => false, "error" => "No changes detected."]);
        }
    } else {
        throw new Exception("Execution failed: " . $stmt->error);
    }
} catch (Exception $e) {
    error_log("❌ Database update failed: " . $e->getMessage());
    echo json_encode(["success" => false, "error" => "Database update error: " . $e->getMessage()]);
}
