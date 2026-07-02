<?php
require_once 'auth.php';
requireLogin();
require_once 'config.php';

$search = $_GET['search'] ?? '';
$search = $conn->real_escape_string($search);

$sql = "
SELECT *
FROM customers
WHERE customerName LIKE '%$search%'
ORDER BY customerID ASC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>

    <title>Customers</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container">

        <div class="pageHeader">

            <div>

                <h1 class="pageTitle">Customers</h1>

            </div>

            <a href="addCustomer.php" class="addButton">Add Customer</a>

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
                        <th>Customer Name</th>
                        <th>Contact Number</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>

                </thead>

                <tbody>

                    <?php if ($result->num_rows > 0): ?>

                        <?php while ($row = $result->fetch_assoc()): ?>

                            <tr>

                                <td>
                                    <?= $row['customerID'] ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($row['customerName']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($row['contactNumber']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($row['address']) ?>
                                </td>

                                <td>

                                    <div class="actionButtons">

                                        <a href="editCustomer.php?id=<?= $row['customerID'] ?>"
                                            class="editButton">Edit</a>

                                        <?php if (isAdmin()): ?>

                                            <a href="deleteCustomer.php?id=<?= $row['customerID'] ?>"
                                                class="deleteButton"
                                                onclick="return confirm('Delete this customer?')">Delete</a>

                                        <?php endif; ?>

                                    </div>

                                </td>

                            </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="5" class="textCenter">
                                No customers found.
                            </td>

                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</body>

</html>