<?php
require_once 'auth.php';
requireLogin();
require_once 'config.php';

$search = $_GET['search'] ?? '';
$search = $conn->real_escape_string($search);

/* Load Deliveries */
$sql = "
SELECT
    d.deliveryID,
    d.orderID,
    d.driverName,
    d.deliveryDate,
    d.remarks,
    d.created_at
FROM deliveries d
WHERE
    d.driverName LIKE '%$search%'
OR
    d.remarks LIKE '%$search%'
ORDER BY d.deliveryID ASC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>

    <title>Deliveries</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container">

        <div class="pageHeader">

            <div>

                <h1 class="pageTitle">Deliveries</h1>

            </div>

        </div>

        <div class="contentCard">

            <form method="GET" class="searchForm">

                <input type="text" name="search" placeholder="Search driver..." value="<?= htmlspecialchars($search) ?>">
                <button type="submit" class="addButton">Search</button>

            </form>

            <table class="dataTable">

                <thead>

                    <tr>
                        <th>Delivery ID</th>
                        <th>Order ID</th>
                        <th>Driver</th>
                        <th>Delivery Date</th>
                        <th>Remarks</th>
                        <th>Created At</th>
                    </tr>

                </thead>

                <tbody>

                    <?php if ($result->num_rows > 0): ?>

                        <?php while ($row = $result->fetch_assoc()): ?>

                            <tr>

                                <td>
                                    <?= $row['deliveryID'] ?>
                                </td>

                                <td>
                                    <?= $row['orderID'] ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($row['driverName']) ?>
                                </td>

                                <td>
                                    <?= date("M d, Y", strtotime($row['deliveryDate'])) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($row['remarks']) ?>
                                </td>

                                <td>
                                    <?= date("M d, Y", strtotime($row['created_at'])) ?>
                                </td>

                            </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="6" class="textCenter">No deliveries found.</td>
                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</body>

</html>