<?php
require_once './src/Database.php';
require_once './src/team.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teamId = $_POST['team_id'];
    $memberId = $_POST['member_id'];

    if (Team::removeMember($teamId, $memberId)) {
        header("Location: team-members.php?team-id=$teamId&success=Member removed");
    } else {
        header("Location: team-members.php?team-id=$teamId&error=Failed to remove member");
    }
    exit();
}
