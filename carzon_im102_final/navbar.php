<?php
require_once 'auth.php';
?>

<div class="navbar">

    <div class="navLogo">

        💧 <span>Water Refilling Station</span>

    </div>

    <div class="navLinks">

        <a href="index.php">Dashboard</a>
        <a href="customers.php">Customers</a>
        <a href="orders.php">Orders</a>
        <a href="deliveries.php">Deliveries</a>

        <?php if (isAdmin()): ?>
            <a href="reports.php">Reports</a>
            <a href="users.php">Users</a>
        <?php endif; ?>

    </div>

    <div class="navUser">

        <span class="userTag">
            <?= getUsername(); ?>
            (<?= ucfirst($_SESSION['role']); ?>)
        </span>

        <a href="logout.php" class="logout">Logout</a>

    </div>

</div>