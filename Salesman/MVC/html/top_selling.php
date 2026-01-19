<?php
session_start();

if (!isset($_SESSION['staff']) || $_SESSION['role'] !== 'Salesman') {
    header("Location: ../../Admin/MVC/html/login.php");
    exit();
}

require_once "../db/TopSellingReportModel.php";

$filter = 'today'; 
if (isset($_GET['filter'])) {
    $filter = $_GET['filter'];
}

$topMedicines = getTopSellingMedicines($filter);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Top Selling Medicines</title>
    <link rel="stylesheet" href="../css/top_selling.css">
</head>
<body>

<div class="header">Salesman Dashboard</div>

<div class="container">
    
    <div class="sidebar">
       <a href="billing.php">Billing</a>
    <a href="customers.php">Customer Management</a>
    <a href="invoiceHistory.php">Invoice History</a>
    <a href="medicine_return.php">Return Medicines</a>
    <a href="top_selling.php" class="active">Top Selling Item</a>
    <a href="../php/profileController.php">My Profile</a>
    <a href="../../../Admin/MVC/php/logout.php" class="logout">Logout</a>
    </div>

    
    <div class="content">
        <h2>Top Selling Medicines</h2>

        <form method="get" class="filter-box">
            <select name="filter">
                <option value="today" <?php if($filter=='today') echo 'selected'; ?>>Today</option>
                <option value="month" <?php if($filter=='month') echo 'selected'; ?>>This Month</option>
                <option value="all" <?php if($filter=='all') echo 'selected'; ?>>All Time</option>
            </select>
            <button type="submit">Filter</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Medicine</th>
                    <th>Generic</th>
                    <th>Company</th>
                    <th>Total Sold (Units)</th>
                </tr>
            </thead>
            <tbody>
                <?php if($topMedicines->num_rows > 0): ?>
                    <?php while($row = $topMedicines->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['medicine_name']; ?></td>
                            <td><?= $row['generic_name']; ?></td>
                            <td><?= $row['company_name']; ?></td>
                            <td><?= $row['total_sold']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="4">No medicines sold in this period.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
