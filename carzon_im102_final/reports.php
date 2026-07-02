<?php
require_once 'auth.php';
requireLogin();
require_once 'config.php';

if (!isAdmin()) {

    header("Location: index.php");
    exit();
}

$totalCustomers = $conn->query("
SELECT COUNT(*) AS total
FROM customers
")->fetch_assoc()['total'];

$totalOrders = $conn->query("
SELECT COUNT(*) AS total
FROM orders
")->fetch_assoc()['total'];

$totalDeliveries = $conn->query("
SELECT COUNT(*) AS total
FROM orders
WHERE deliveryType='Delivery'
")->fetch_assoc()['total'];

$totalPickup = $conn->query("
SELECT COUNT(*) AS total
FROM orders
WHERE deliveryType='Pickup'
")->fetch_assoc()['total'];

$sales = $conn->query("
SELECT SUM(totalPrice) AS total
FROM orders
")->fetch_assoc();

$totalSales = $sales['total'] ?? 0;

$recentOrders = $conn->query("
SELECT
    c.customerName,
    o.quantity,
    o.totalPrice,
    o.deliveryType,
    o.orderStatus,
    u.username,
    o.created_at
FROM orders o
INNER JOIN customers c
ON o.customerID = c.customerID
INNER JOIN users u
ON o.added_by = u.userID
ORDER BY o.orderID DESC
LIMIT 10
");
?>

<!DOCTYPE html>
<html>

<head>

    <title>Reports</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container">

        <div class="pageHeader">

            <div>

                <h1 class="pageTitle">Reports</h1>

            </div>

        </div>

        <div class="dashboardCards">

            <div class="card">

                <h3>Customers</h3>

                <p><?= $totalCustomers ?></p>

            </div>

            <div class="card">

                <h3>Orders</h3>

                <p><?= $totalOrders ?></p>

            </div>

            <div class="card">

                <h3>Deliveries</h3>

                <p><?= $totalDeliveries ?></p>

            </div>

            <div class="card">

                <h3>Pickups</h3>

                <p><?= $totalPickup ?></p>

            </div>

        </div>

        <br>

        <div class="dashboardCards">

            <div class="card">

                <h3>Total Sales</h3>

                <p>₱<?= number_format($totalSales, 2) ?></p>

            </div>

        </div>

        <div class="recentOrders">

            <h2>Recent Orders</h2>

            <br>

            <table class="dataTable">

                <thead>

                    <tr>
                        <th>Customer</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Delivery</th>
                        <th>Status</th>
                        <th>Added By</th>
                        <th>Date</th>
                    </tr>

                </thead>

                <tbody>

                    <?php if ($recentOrders->num_rows > 0): ?>

                        <?php while ($row = $recentOrders->fetch_assoc()): ?>

                            <tr>

                                <td>
                                    <?= htmlspecialchars($row['customerName']) ?>
                                </td>

                                <td>
                                    <?= $row['quantity'] ?>
                                </td>

                                <td>
                                    ₱<?= number_format($row['totalPrice'], 2) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($row['deliveryType']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($row['orderStatus']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($row['username']) ?>
                                </td>

                                <td>
                                    <?= date("M d, Y", strtotime($row['created_at'])) ?>
                                </td>

                            </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="7">No reports available.</td>

                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</body>

</html>