<?php
require_once 'auth.php';
requireLogin();
require_once 'config.php';

if (!isAdmin()) {

    header("Location: index.php");
    exit();
}

$userID = (int)($_GET['id'] ?? 0);

$stmt = $conn->prepare("
SELECT
    userID,
    username,
    email,
    role
FROM users
WHERE userID = ?
");

$stmt->bind_param("i", $userID);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {

    header("Location: users.php");
    exit();
}

$user = $result->fetch_assoc();

/* Update Role */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $role = $conn->real_escape_string($_POST['role']);

    $stmt = $conn->prepare("
    UPDATE users
    SET role = ?
    WHERE userID = ?
    ");

    $stmt->bind_param(
        "si",
        $role,
        $userID
    );

    if ($stmt->execute()) {

        $_SESSION['success'] = "User role updated successfully.";

        header("Location: users.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Edit User</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container">

        <div class="pageHeader">

            <div>

                <h1 class="pageTitle">Edit User Role</h1>

                <p class="pageSubtitle">Update the user's access level.</p>

            </div>

        </div>

        <div class="formCard">

            <form method="POST">

                <div class="formGroup">

                    <label>Username</label>
                    <input type="text"
                        value="<?= htmlspecialchars($user['username']) ?>" readonly>

                </div>

                <div class="formGroup">

                    <label>Email</label>

                    <input type="email"
                        value="<?= htmlspecialchars($user['email']) ?>" readonly>

                </div>

                <div class="formGroup">

                    <label>Role</label>

                    <select name="role" required>

                        <option value="admin"
                            <?= $user['role'] == "admin" ? "selected" : "" ?>>Admin</option>

                        <option value="staff"
                            <?= $user['role'] == "staff" ? "selected" : "" ?>>Staff</option>

                    </select>

                </div>

                <div class="formButtons">

                    <button type="submit" class="addButton"> Save Changes</button>

                    <a href="users.php" class="cancelButton">Cancel</a>

                </div>

            </form>

        </div>

    </div>

</body>

</html>