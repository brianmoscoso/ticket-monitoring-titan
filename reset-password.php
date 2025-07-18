<?php
require_once './src/Database.php';
require_once './src/user.php';


if (!isset($_GET['uid']) || !is_numeric($_GET['uid'])) {
    die("Invalid user.");
}

$uid = (int)$_GET['uid'];

if (User::adminReset($uid)) {
    header("Location: users.php?msg=reset-success"); // 🔴 Must be before output
    exit;
} else {
    die("Password reset failed.");
}
?>
