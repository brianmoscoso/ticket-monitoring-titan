<?php
require_once __DIR__ . '/comment.php';

if (!isset($_GET['ticket_id']) || !ctype_digit($_GET['ticket_id'])) {
    exit();
}

$ticket_id = $_GET['ticket_id'];
$worknotes = Comment::findByTicket($ticket_id);

foreach ($worknotes as $note) {
    echo "<li><strong>{$note->author}</strong> ({$note->created_at}): <br>{$note->body}";
    if (!empty($note->screenshot_path)) {
        echo "<br><img src='src/uploads/" . basename(htmlspecialchars($note->screenshot_path)) . "' class='worknote-img' alt='Screenshot'>";
    }
    echo "</li>";
}
?>
