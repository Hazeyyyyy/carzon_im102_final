<?php
require_once 'auth.php';
requireLogin();
require_once 'config.php';

if (!isAdmin()) {
    header("Location: customers.php");
    exit();
}

$id = (int) ($_GET['id'] ?? 0);

if ($id <= 0) {
    header("Location: customers.php");
    exit();
}

$sql = "DELETE FROM customers WHERE customerID = $id";

if ($conn->query($sql)) {

    $_SESSION['success'] = "Customer deleted successfully.";
} else {

    $_SESSION['success'] = "Failed to delete customer.";
}

header("Location: customers.php");
exit();
