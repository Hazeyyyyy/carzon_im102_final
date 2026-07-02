<?php
require_once 'auth.php';
requireLogin();
require_once 'config.php';

$id = (int) ($_GET['id'] ?? 0);

$sql = "SELECT * FROM customers WHERE customerID = $id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Customer not found.");
}

$customer = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $customerName = $conn->real_escape_string($_POST['customerName']);
    $contactNumber = $conn->real_escape_string($_POST['contactNumber']);
    $address = $conn->real_escape_string($_POST['address']);

    $sql = "
        UPDATE customers
        SET
            customerName = '$customerName',
            contactNumber = '$contactNumber',
            address = '$address'
        WHERE customerID = $id
    ";

    if ($conn->query($sql)) {

        $_SESSION['success'] = "Customer updated successfully.";
        header("Location: customers.php");
        exit();
    } else {

        $error = "Failed to update customer.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Edit Customer</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container">

        <div class="pageHeader">

            <div>

                <h1 class="pageTitle">Edit Customer</h1>

                <p class="pageSubtitle"> Update customer information.</p>

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

                    <input type="text" name="customerName"
                        value="<?= htmlspecialchars($customer['customerName']) ?>" required>

                </div>

                <div class="formGroup">

                    <label>Contact Number</label>

                    <input type="text" name="contactNumber"
                        value="<?= htmlspecialchars($customer['contactNumber']) ?>" required>

                </div>

                <div class="formGroup">

                    <label>Address</label>

                    <textarea name="address" rows="4"
                        required><?= htmlspecialchars($customer['address']) ?></textarea>

                </div>

                <div class="formButtons">

                    <button type="submit" class="addButton">Update Customer</button>

                    <a href="customers.php" class="cancelButton">Cancel</a>

                </div>

            </form>

        </div>

    </div>

</body>

</html>