<?php
require_once 'auth.php';
requireLogin();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $customerName = $conn->real_escape_string($_POST["customerName"]);
    $contactNumber = $conn->real_escape_string($_POST["contactNumber"]);
    $address = $conn->real_escape_string($_POST["address"]);

    $sql = "
        INSERT INTO customers
        (customerName, contactNumber, address)
        VALUES
        ('$customerName', '$contactNumber', '$address')
    ";

    if ($conn->query($sql)) {

        $_SESSION['success'] = "Customer added successfully.";
        header("Location: customers.php");
        exit();
    } else {

        $error = "Failed to add customer.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Add Customer</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container">

        <div class="pageHeader">

            <div>

                <h1 class="pageTitle">Add Customer</h1>

                <p class="pageSubtitle">Enter the customer's information below.</p>

            </div>

        </div>

        <div class="formCard">

            <?php if (isset($error)): ?>

                <p style="color:red; margin-bottom:20px;">

                    <?= $error ?>

                </p>

            <?php endif; ?>

            <form method="POST">

                <div class="formGroup">

                    <label>Customer Name</label>
                    <input type="text" name="customerName" required>

                </div>

                <div class="formGroup">

                    <label>Contact Number</label>
                    <input type="text" name="contactNumber" required>

                </div>

                <div class="formGroup">

                    <label>Address</label>
                    <textarea name="address" rows="4" required></textarea>

                </div>

                <div class="formButtons">

                    <button type="submit" class="addButton">Save Customer</button>
                    <a href="customers.php" class="cancelButton">Cancel</a>

                </div>

            </form>

        </div>

    </div>

</body>

</html>