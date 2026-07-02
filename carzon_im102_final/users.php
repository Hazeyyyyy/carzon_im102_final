<?php
require_once 'auth.php';
requireLogin();
require_once 'config.php';

if (!isAdmin()) {

    header("Location: index.php");
    exit();
}

$search = $_GET['search'] ?? '';
$search = $conn->real_escape_string($search);

$sql = "
SELECT
    userID,
    username,
    email,
    role,
    created_at
FROM users
WHERE
    username LIKE '%$search%'
OR
    email LIKE '%$search%'
ORDER BY userID ASC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>

    <title>Users</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container">

        <div class="pageHeader">

            <div>

                <h1 class="pageTitle">Users</h1>

            </div>

        </div>

        <?php if (isset($_SESSION['success'])): ?>

            <div class="successBox">

                <?= $_SESSION['success'] ?>

            </div>

            <?php unset($_SESSION['success']); ?>

        <?php endif; ?>

        <div class="contentCard">

            <form method="GET" class="searchForm">

                <input type="text" name="search"
                    placeholder="Search user..."
                    value="<?= htmlspecialchars($search) ?>">

                <button type="submit" class="addButton">Search</button>

            </form>

            <table class="dataTable">

                <thead>

                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>

                </thead>

                <tbody>

                    <?php if ($result->num_rows > 0): ?>

                        <?php while ($row = $result->fetch_assoc()): ?>

                            <tr>

                                <td>
                                    <?= $row['userID'] ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($row['username']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($row['email']) ?>
                                </td>

                                <td>
                                    <?= ucfirst($row['role']) ?>
                                </td>

                                <td>
                                    <?= date("M d, Y", strtotime($row['created_at'])) ?>
                                </td>

                                <td>

                                    <div class="userButtons">
                                        <a href="editUser.php?id=<?= $row['userID'] ?>"
                                            class="editButton">Edit Role</a>

                                        <?php if ($row['userID'] != $_SESSION['user_id']): ?>

                                            <a href="deleteUser.php?id=<?= $row['userID'] ?>"
                                                class="deleteButton"
                                                onclick="return confirm('Delete this user?')">Delete</a>

                                        <?php else: ?>

                                            <span class="userTag">Current User</span>

                                        <?php endif; ?>

                                    </div>

                                </td>

                            </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="6" class="textCenter">No users found.</td>

                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</body>

</html>