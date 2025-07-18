<?php
require_once './team-member.php';
require_once './comment.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 400, 'message' => 'Invalid request']);
    exit();
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 401, 'message' => 'Unauthorized']);
    exit();
}

$ticket_id = isset($_POST['ticket_id']) ? intval($_POST['ticket_id']) : null;
$remark = trim($_POST['remark'] ?? '');

if (!$ticket_id || !$remark) {
    echo json_encode(['status' => 400, 'message' => 'Invalid input. Ticket ID and remark are required.']);
    exit();
}

// ✅ Get the user's name from the team-member table
$user_id = $_SESSION['user_id'];
$teamMember = TeamMember::find($user_id);

if (!$teamMember) {
    echo json_encode(['status' => 403, 'message' => 'User not found']);
    exit();
}

$author_name = $teamMember->name;

// ✅ Handle Screenshot Upload (if provided)
$upload_dir = 'src/uploads/';
$screenshot_filename = '';

if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true); // Ensure upload directory exists
}

if (!empty($_FILES['screenshot']['name'])) {
    $original_filename = basename($_FILES['screenshot']['name']);
    $screenshot_filename = time() . '_' . $original_filename; // Ensure unique filename
    $target_file = $upload_dir . $screenshot_filename;
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($file_type, $allowed_types)) {
        if (move_uploaded_file($_FILES['screenshot']['tmp_name'], $target_file)) {
            // ✅ Debugging: Log success
            error_log("File uploaded successfully: " . $screenshot_filename);
        } else {
            error_log("File upload failed for: " . $screenshot_filename);
            echo json_encode(['status' => 500, 'message' => 'File upload failed']);
            exit();
        }
    } else {
        error_log("Invalid file type attempted: " . $file_type);
        echo json_encode(['status' => 400, 'message' => 'Invalid file type']);
        exit();
    }
}

// ✅ Store only the relative path for security
$screenshot_path = !empty($screenshot_filename) ? 'src/src/uploads/' . $screenshot_filename : '';

try {
    $comment = new Comment([
        'ticket' => $ticket_id,
        'team_member' => $user_id,
        'author' => $author_name,
        'body' => $remark,
        'screenshot_path' => $screenshot_path, // ✅ Pass the correct path
        'created_at' => date('Y-m-d H:i:s')
    ]);

    if ($comment->save()) {
        echo json_encode([
            'status' => 200,
            'message' => 'Worknote added successfully',
            'author' => $author_name,
            'created_at' => date('Y-m-d H:i:s'),
            'body' => $remark,
            'screenshot_path' => $screenshot_path, // ✅ Return correct relative path
            'filename' => $screenshot_filename // ✅ Include filename
        ]);
    } else {
        echo json_encode(['status' => 500, 'message' => 'Database error while saving worknote!']);
    }
} catch (Exception $e) {
    error_log("Database Error: " . $e->getMessage());
    echo json_encode(['status' => 500, 'message' => 'Error: ' . $e->getMessage()]);
}
?>
