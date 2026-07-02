<?php
require_once 'config.php';
$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $conn->real_escape_string(trim($_POST['username']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];

    if (empty($username)) {
        $errors[] = "Username is required.";
    }

    if (empty($email)) {
        $errors[] = "Email is required.";
    }

    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    if (empty($confirmpassword)) {
        $errors[] = "Confirm Password is required.";
    }

    if (!empty($username) && strlen($username) < 3) {
        $errors[] = "Username must be at least 3 characters.";
    }

    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (!empty($password) && strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    if ($password !== $confirmpassword) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($errors)) {

        $stmt = $conn->prepare(
            "SELECT userID FROM users WHERE username = ? OR email = ?"
        );

        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $errors[] = "Username or email already exists.";
        }

        $stmt->close();
    }

    if (empty($errors)) {

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare(
            "INSERT INTO users (username, email, password_hash)
             VALUES (?, ?, ?)"
        );

        $stmt->bind_param(
            "sss",
            $username,
            $email,
            $password_hash
        );

        if ($stmt->execute()) {
            $success = "Registration successful! You can now log in.";
            $_POST = [];
        } else {
            $errors[] = "Something went wrong. Please try again.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Registration</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="authContainer">

        <div class="authCard">

            <div class="authLogo">

                💧

            </div>

            <h1 class="authTitle">Create Account</h1>

            <p class="authSubtitle">Water Refilling Station</p>

            <?php if (!empty($errors)): ?>

                <div class="errorBox">

                    <ul>

                        <?php foreach ($errors as $error): ?>

                            <li><?= $error ?></li>

                        <?php endforeach; ?>

                    </ul>

                </div>

            <?php endif; ?>

            <?php if (!empty($success)): ?>

                <div class="successBox">

                    <?= $success ?>

                </div>

            <?php endif; ?>

            <form method="POST" class="authForm">

                <label>Username</label>
                <input type="text" name="username"
                    value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>

                <label>Email</label>
                <input type="email" name="email"
                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>

                <label>Password</label>
                <input type="password" name="password" required>

                <label>Confirm Password</label>
                <input type="password" name="confirmpassword" required>

                <button type="submit" class="authButton">Register</button>

            </form>

            <div class="authLink">

                Already have an account?

                <a href="login.php">Login</a>

            </div>

        </div>

    </div>

</body>

</html>