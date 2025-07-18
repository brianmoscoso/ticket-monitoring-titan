<?php
require_once './src/Database.php';
require_once './src/user.php';
session_start();

$isAdmin       = ($_SESSION['role'] ?? '') === 'admin';
$currentUserId = $_SESSION['user_id'] ?? 0;

$userId          = (int)($_POST['user_id']           ?? 0);
$currentPassword =       $_POST['current_password']  ?? '';
$newPassword     =       $_POST['new_password']      ?? '';
$confirmPassword =       $_POST['confirm_password']  ?? '';

if (!$userId)   die('Invalid Request');
if ($newPassword !== $confirmPassword)  die('Passwords do not match');

$user = User::findById($userId);
if (!$user) die('User not found');

// ───────── verify old password (unless admin resetting) ─────────
if (!$isAdmin || $userId == $currentUserId) {
    if (!password_verify($currentPassword, $user->password)) {
        die('Current password incorrect');
    }
}

// ───────── save new hash ─────────
$hash = password_hash($newPassword, PASSWORD_BCRYPT);
if (User::updatePassword($userId, $hash)) {
    // if the user changed own pw → force re‑login (optional)
    if ($userId == $currentUserId && !$isAdmin) {
        session_destroy();
        header("Location: login.php?success=Password+changed%2C+please+log+in");
    } else {
        header("Location: users.php?success=Password+updated");
    }
    exit;
}

die('Update failed; please try again.');
