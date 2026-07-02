<?php
require_once 'auth.php';
requireLogin();
require_once 'config.php';

if (!isAdmin()) {

    header("Location: index.php");
    exit();
}

/* Get User ID */
$userID = (int)($_GET['id'] ?? 0);

/* Prevent deleting yourself */
if ($userID == $_SESSION['user_id']) {

    $_SESSION['error'] = "You cannot delete your own account.";

    header("Location: users.php");
    exit();
}

/* Delete User */
$stmt = $conn->prepare("
DELETE
FROM users
WHERE userID = ?
");

$stmt->bind_param("i", $userID);

if ($stmt->execute()) {

    $_SESSION['success'] = "User deleted successfully.";
} else {

    $_SESSION['error'] = "Failed to delete user.";
}

header("Location: users.php");
exit();
