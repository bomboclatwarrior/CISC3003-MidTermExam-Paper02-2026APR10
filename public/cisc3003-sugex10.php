<?php
include 'includes/book-utilities.inc.php';

// Define data file paths (adjust if needed; place customers.txt and orders.txt in same folder as this script)
$customersFile = 'data/customers.txt';
$ordersFile    = 'data/orders.txt';

// Load all customers
$customers = readCustomers($customersFile);

// Determine selected customer from query string
$selectedCustomerId = isset($_GET['id']) ? $_GET['id'] : null;
$selectedCustomer = null;
if ($selectedCustomerId !== null) {
    foreach ($customers as $c) {
        if ($c['id'] == $selectedCustomerId) {
            $selectedCustomer = $c;
            break;
        }
    }
}

// Fetch orders for selected customer
$customerOrders = [];
if ($selectedCustomer !== null) {
    $customerOrders = readOrders($selectedCustomer['id'], $ordersFile);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Replace with your actual Student ID and Full Name -->
    <title>CISC3003: 2025123456 Alex Johnson</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.1.3/material.blue_grey-orange.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/demo-styles.css">
    <link rel="stylesheet" href="css/material.min.css">
    
    <script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
    <script src="https://code.getmdl.io/1.1.3/material.min.js"></script>
    <script src="js/jquery.sparkline.2.1.2.js"></script>
</head>
<body>
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
    <?php include 'includes/header.inc.php'; ?>
    <?php include 'includes/left-nav.inc.php'; ?>
    
    <main class="mdl-layout__content mdl-color--grey-50">
        <section class="page-content">
            <div class="mdl-grid">
                <!-- Customers Table Card (left column) -->
                <div class="mdl-cell mdl-cell--7-col card-lesson mdl-card mdl-shadow--2dp">
                    <div class="mdl-card__title mdl-color--orange">
                        <h2 class="mdl-card__title-text">Customers</h2>
                    </div>
                    <div class="mdl-card__supporting-text">
                        <table class="mdl-data-table mdl-shadow--2dp">
                            <thead>
                                <tr>
                                    <th class="mdl-data-table__cell--non-numeric">Name</th>
                                    <th class="mdl-data-table__cell--non-numeric">University</th>
                                    <th class="mdl-data-table__cell--non-numeric">City</th>
                                    <th>Sales (12-month)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($customers as $customer): ?>
                                <tr>
                                    <td class="mdl-data-table__cell--non-numeric">
                                        <a href="?id=<?= urlencode($customer['id']) ?>">
                                            <?= htmlspecialchars($customer['first_name'] . ' ' . $customer['last_name']) ?>
                                        </a>
                                    </td>
                                    <td class="mdl-data-table__cell--non-numeric">
                                        <?= htmlspecialchars($customer['university']) ?>
                                    </td>
                                    <td class="mdl-data-table__cell--non-numeric">
                                        <?= htmlspecialchars($customer['city']) ?>
                                    </td>
                                    <td>
                                        <span class="sparkline" data-sales="<?= htmlspecialchars($customer['sales']) ?>"></span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div> <!-- / Customers Card -->

                <!-- Right column: Customer Details & Order Details -->
                <div class="mdl-grid mdl-cell--5-col">
                    <!-- Customer Details Card -->
                    <div class="mdl-cell mdl-cell--12-col card-lesson mdl-card mdl-shadow--2dp">
                        <div class="mdl-card__title mdl-color--deep-purple mdl-color-text--white">
                            <h2 class="mdl-card__title-text">Customer Details</h2>
                        </div>
                        <div class="mdl-card__supporting-text">
                            <?php if ($selectedCustomer !== null): ?>
                                <h4><?= htmlspecialchars($selectedCustomer['first_name'] . ' ' . $selectedCustomer['last_name']) ?></h4>
                                <p><strong>Email:</strong> <?= htmlspecialchars($selectedCustomer['email']) ?><br>
                                <strong>University:</strong> <?= htmlspecialchars($selectedCustomer['university']) ?><br>
                                <strong>Address:</strong> <?= htmlspecialchars($selectedCustomer['address']) ?><br>
                                <strong>City:</strong> <?= htmlspecialchars($selectedCustomer['city']) ?><br>
                                <strong>State:</strong> <?= htmlspecialchars($selectedCustomer['state']) ?><br>
                                <strong>Country:</strong> <?= htmlspecialchars($selectedCustomer['country']) ?><br>
                                <strong>Zip/Postal:</strong> <?= htmlspecialchars($selectedCustomer['zip']) ?><br>
                                <strong>Phone:</strong> <?= htmlspecialchars($selectedCustomer['phone']) ?></p>
                            <?php else: ?>
                                <p>No customer selected. Please click a customer name from the table.</p>
                            <?php endif; ?>
                        </div>
                    </div> <!-- / Customer Details Card -->

                    <!-- Order Details Card -->
                    <div class="mdl-cell mdl-cell--12-col card-lesson mdl-card mdl-shadow--2dp">
                        <div class="mdl-card__title mdl-color--deep-purple mdl-color-text--white">
                            <h2 class="mdl-card__title-text">Order Details</h2>
                        </div>
                        <div class="mdl-card__supporting-text">
                            <?php if ($selectedCustomer !== null): ?>
                                <?php if (count($customerOrders) > 0): ?>
                                    <table class="mdl-data-table mdl-shadow--2dp">
                                        <thead>
                                            <tr>
                                                <th class="mdl-data-table__cell--non-numeric">Cover</th>
                                                <th class="mdl-data-table__cell--non-numeric">ISBN</th>
                                                <th class="mdl-data-table__cell--non-numeric">Title</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($customerOrders as $order): ?>
                                            <tr>
                                                <td class="mdl-data-table__cell--non-numeric">
                                                    <i class="material-icons">menu_book</i>
                                                </td>
                                                <td class="mdl-data-table__cell--non-numeric">
                                                    <?= htmlspecialchars($order['isbn']) ?>
                                                </td>
                                                <td class="mdl-data-table__cell--non-numeric">
                                                    <?= htmlspecialchars($order['title']) ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php else: ?>
                                    <p>No order information found for this customer.</p>
                                <?php endif; ?>
                            <?php else: ?>
                                <p>Select a customer to view orders.</p>
                            <?php endif; ?>
                        </div>
                    </div> <!-- / Order Details Card -->
                </div> <!-- / right column -->
            </div> <!-- / mdl-grid -->
        </section>

        <!-- Footer with required text (must match exactly as required) -->
        <footer style="padding: 16px; text-align: center; background-color: #ececec; width: 100%;">
            <p>CISC3003 Web Programming: 2025123456 Alex Johnson 2026</p>
        </footer>
    </main>
</div> <!-- / mdl-layout -->

<!-- Sparkline initialization -->
<script>
$(document).ready(function() {
    $('.sparkline').each(function() {
        var salesStr = $(this).data('sales');
        if (salesStr) {
            var values = salesStr.split(',').map(Number);
            $(this).sparkline(values, {
                type: 'bar',
                barColor: '#f39c12',
                height: '30px',
                barWidth: 5,
                barSpacing: 2
            });
        }
    });
});
</script>
</body>
</html>