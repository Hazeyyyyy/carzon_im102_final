<?php
require_once 'auth.php';
requireLogin();
require_once 'config.php';

$pricePerGallon = 30.00;
$error = "";

/* Get Order ID */
$orderID = (int) ($_GET['id'] ?? 0);

if ($orderID <= 0) {

    header("Location: orders.php");
    exit();
}

/* Load Customers */
$customers = $conn->query("
    SELECT customerID, customerName
    FROM customers
    ORDER BY customerName ASC
");

/* Load Selected Order */
$stmt = $conn->prepare("
    SELECT *
    FROM orders
    WHERE orderID = ?
");

$stmt->bind_param("i", $orderID);
$stmt->execute();

$order = $stmt->get_result()->fetch_assoc();

if (!$order) {

    header("Location: orders.php");
    exit();
}

/* Update Order */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $customerID = (int) $_POST["customerID"];
    $quantity = (int) $_POST["quantity"];

    $deliveryType = $conn->real_escape_string($_POST["deliveryType"]);
    $orderStatus = $conn->real_escape_string($_POST["orderStatus"]);

    $totalPrice = $quantity * $pricePerGallon;

    $stmt = $conn->prepare("
        UPDATE orders
        SET
            customerID = ?,
            quantity = ?,
            pricePerGallon = ?,
            totalPrice = ?,
            deliveryType = ?,
            orderStatus = ?
        WHERE orderID = ?
    ");

    $stmt->bind_param(
        "iiddssi",
        $customerID,
        $quantity,
        $pricePerGallon,
        $totalPrice,
        $deliveryType,
        $orderStatus,
        $orderID
    );

    if ($stmt->execute()) {

        $_SESSION["success"] = "Order updated successfully.";

        header("Location: orders.php");
        exit();
    } else {

        $error = "Failed to update order.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Edit Order</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container">

        <div class="pageHeader">

            <div>

                <h1 class="pageTitle">Edit Order</h1>

                <p class="pageSubtitle">Update the order information below.</p>

            </div>

        </div>

        <div class="formCard">

            <?php if (!empty($error)): ?>

                <p style="color:red; margin-bottom:20px;">

                    <?= $error ?>

                </p>

            <?php endif; ?>

            <form method="POST">

                <div class="formGroup">

                    <label>Customer</label>

                    <select name="customerID" required>

                        <?php while ($customer = $customers->fetch_assoc()): ?>

                            <option
                                value="<?= $customer['customerID'] ?>"
                                <?= $customer['customerID'] == $order['customerID'] ? 'selected' : '' ?>>

                                <?= htmlspecialchars($customer['customerName']) ?>

                            </option>

                        <?php endwhile; ?>

                    </select>

                </div>

                <div class="formGroup">

                    <label>Quantity</label>
                    <input type="number" name="quantity" id="quantity"
                        min="1" value="<?= $order['quantity'] ?>" required>

                </div>

                <div class="formGroup">

                    <label>Price Per Gallon</label>
                    <input type="number" id="pricePerGallon"
                        value="<?= number_format($order['pricePerGallon'], 2) ?>"
                        readonly>

                </div>

                <div class="formGroup">

                    <label>Delivery Type</label>

                    <select name="deliveryType" required>

                        <option value="Pickup"
                            <?= $order['deliveryType'] == 'Pickup' ? 'selected' : '' ?>>Pickup</option>

                        <option value="Delivery"
                            <?= $order['deliveryType'] == 'Delivery' ? 'selected' : '' ?>>Delivery</option>

                    </select>

                </div>

                <div class="formGroup">

                    <label>Order Status</label>

                    <select name="orderStatus" required>

                        <option value="Pending"
                            <?= $order['orderStatus'] == 'Pending' ? 'selected' : '' ?>>Pending</option>

                        <option value="Delivered"
                            <?= $order['orderStatus'] == 'Delivered' ? 'selected' : '' ?>>Delivered</option>

                    </select>

                </div>

                <div class="formGroup">

                    <label>Total Price</label>

                    <input type="text" id="totalPrice"
                        value="₱<?= number_format($order['totalPrice'], 2) ?>" readonly>

                </div>

                <div class="formButtons">

                    <button type="submit" class="addButton">Update Order</button>

                    <a href="orders.php" class="cancelButton">Cancel</a>

                </div>

            </form>

        </div>

    </div>

    <script>
        const quantity = document.getElementById("quantity");
        const price = document.getElementById("pricePerGallon");
        const total = document.getElementById("totalPrice");

        function calculateTotal() {
            const qty = Number(quantity.value);
            const gallonPrice = Number(price.value);
            const totalPrice = qty * gallonPrice;
            total.value = "₱" + totalPrice.toFixed(2);

        }

        calculateTotal();
        quantity.addEventListener("input", calculateTotal);
    </script>

</body>

</html>