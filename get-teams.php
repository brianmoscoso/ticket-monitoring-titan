<?php
require_once './src/team.php';
header('Content-Type: application/json');

// ✅ Ensure only JSON is returned (no extra HTML)
$teams = Team::findAll();
echo json_encode($teams);
?>
