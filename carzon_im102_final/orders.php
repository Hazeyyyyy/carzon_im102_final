<?php
require_once 'auth.php';
requireLogin();
require_once 'config.php';

$search = $_GET['search'] ?? '';
$search = $conn->real_escape_string($search);

$sql = "
SELECT
    o.orderID,
    c.customerName,
    o.quantity,
    o.pricePerGallon,
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
WHERE c.customerName LIKE '%$search%'
ORDER BY o.orderID ASC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>

    <title>Orders</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container">

        <div class="pageHeader">

            <div>

                <h1 class="pageTitle">Orders</h1>

            </div>

            <a href="addOrder.php" class="addButton">Add Order</a>

        </div>

        <div class="contentCard">

            <?php if (isset($_SESSION['success'])): ?>

                <div class="successMessage">

                    <?= $_SESSION['success']; ?>

                </div>

                <?php unset($_SESSION['success']); ?>

            <?php endif; ?>

            <form method="GET" class="searchForm">

                <input type="text" name="search"
                    placeholder="Search customer..."
                    value="<?= htmlspecialchars($search) ?>">

                <button type="submit" class="addButton">Search</button>

            </form>

            <table class="dataTable">

                <thead>

                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Delivery</th>
                        <th>Status</th>
                        <th>Added By</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>

                </thead>

                <tbody>

                    <?php if ($result->num_rows > 0): ?>

                        <?php while ($row = $result->fetch_assoc()): ?>

                            <tr>
                                <td><?= $row['orderID'] ?></td>
                                <td><?= htmlspecialchars($row['customerName']) ?></td>
                                <td><?= $row['quantity'] ?></td>
                                <td>₱<?= number_format($row['pricePerGallon'], 2) ?></td>
                                <td>₱<?= number_format($row['totalPrice'], 2) ?></td>
                                <td><?= htmlspecialchars($row['deliveryType']) ?></td>
                                <td><?= htmlspecialchars($row['orderStatus']) ?></td>
                                <td><?= htmlspecialchars($row['username']) ?></td>
                                <td><?= date("M d, Y", strtotime($row['created_at'])) ?></td>

                                <td>

                                    <div class="actionButtons">

                                        <a href="editOrder.php?id=<?= $row['orderID'] ?>"
                                            class="editButton">Edit</a>

                                        <?php if (isAdmin()): ?>

                                            <a href="deleteOrder.php?id=<?= $row['orderID'] ?>"
                                                class="deleteButton"
                                                onclick="return confirm('Delete this order?')">Delete</a>

                                        <?php endif; ?>

                                    </div>

                                </td>

                            </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="10" class="textCenter">No orders found.</td>

                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</body>

</html>