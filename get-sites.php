<?php
require_once './src/sites.php';
header('Content-Type: application/json');

// ✅ Ensure only JSON is returned (no extra HTML)
$teams = Sites::findAll();
echo json_encode($teams);
?>
