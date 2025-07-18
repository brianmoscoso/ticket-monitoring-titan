<?php
require_once __DIR__ . '/src/Database.php';  // ✅ Ensure correct path
require_once __DIR__ . '/src/comment.php';   // ✅ Ensure correct path

header('Content-Type: application/json'); // ✅ Ensure JSON response

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"]) && isset($_POST["body"])) {
    $id = $_POST["id"];
    $body = trim($_POST["body"]);

    // ✅ Find existing worknote
    $comment = Comment::findById($id);
    if (!$comment) {
        echo json_encode(["success" => false, "error" => "Worknote not found"]);
        exit;
    }

    // ✅ Update the worknote
    $comment->body = $body;
    if ($comment->update()) {
        echo json_encode(["success" => true, "message" => "Worknote updated successfully"]);
    } else {
        echo json_encode(["success" => false, "error" => "Failed to update worknote"]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Invalid request"]);
}
?>
