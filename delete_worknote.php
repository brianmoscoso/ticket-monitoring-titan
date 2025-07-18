<?php
require_once __DIR__ . '/src/Database.php';
require_once __DIR__ . '/src/comment.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $id = $_POST["id"];

    if (Comment::deleteById($id)) {
        echo json_encode(["success" => true, "message" => "Worknote deleted successfully"]);
    } else {
        echo json_encode(["success" => false, "error" => "Failed to delete worknote"]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Invalid request"]);
}
?>
