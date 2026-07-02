<?php
require_once 'config.php';
require_once 'auth.php';

if (isLoggedIn()) {
    header("Location: index.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $conn->real_escape_string(
        trim($_POST['username'])
    );

    $password = $_POST['password'];

    if (empty($username) || empty($password)) {

        $error = "Please fill in all fields.";
    } else {

        $stmt = $conn->prepare(
            "SELECT * FROM users WHERE username = ?"
        );

        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();

        $user = $result->fetch_assoc();

        if (
            $user &&
            password_verify($password, $user['password_hash'])
        ) {

            $_SESSION['user_id'] = $user['userID'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            header("Location: index.php");
            exit;
        } else {

            $error = "Invalid username or password.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="authContainer">

        <div class="authCard">

            <div class="authLogo">

                💧

            </div>

            <h1 class="authTitle">Water Refilling Station</h1>

            <p class="authSubtitle">Management System</p>

            <?php if (!empty($error)): ?>

                <div class="errorBox">

                    <?= $error ?>

                </div>

            <?php endif; ?>

            <form method="POST" class="authForm">

                <label>Username</label>
                <input type="text" name="username" required>

                <label>Password</label>
                <input type="password" name="password" required>

                <button type="submit" class="authButton">Login</button>

            </form>

            <div class="authLink">

                Don't have an account?

                <a href="register.php">Register</a>

            </div>

        </div>

    </div>

</body>

</html>