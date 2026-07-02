<?php
require_once 'auth.php';
requireLogin();
require_once 'config.php';

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
    WHERE deliveryType = 'Delivery'
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
LIMIT 5
");
?>

<!DOCTYPE html>
<html>

<head>

    <title>Dashboard</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container">

        <div class="dashboardHeader">

            <h1 class="dashboardTitle">Dashboard</h1>

            <p class="dashboardSubtitle">Welcome back,
                <strong><?= htmlspecialchars(getUsername()) ?></strong>!
            </p>

        </div>

        <div class="dashboardButtons">

            <a href="addCustomer.php" class="addButton">Add Customer</a>
            <a href="addOrder.php" class="addButton">Add Order</a>

            <?php if (isAdmin()): ?>
                <a href="reports.php" class="addButton">View Reports</a>
            <?php endif; ?>

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
                        <th>Delivery Type</th>
                        <th>Status</th>
                        <th>Staff</th>
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

                            <td colspan="6" class="textCenter">No recent orders yet.</td>

                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</body>

</html>