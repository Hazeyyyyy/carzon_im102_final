<?php
require_once 'auth.php';
requireLogin();
require_once 'config.php';

if (!isAdmin()) {

    header("Location: orders.php");
    exit();
}

/* Get Order ID */
$orderID = (int) ($_GET['id'] ?? 0);

if ($orderID <= 0) {

    header("Location: orders.php");
    exit();
}

/* Delete Order*/
$stmt = $conn->prepare("
    DELETE
    FROM orders
    WHERE orderID = ?
");

$stmt->bind_param("i", $orderID);

if ($stmt->execute()) {

    $_SESSION['success'] = "Order deleted successfully.";
} else {

    $_SESSION['error'] = "Failed to delete order.";
}

header("Location: orders.php");
exit();
