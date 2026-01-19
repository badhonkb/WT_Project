<?php
session_start();
include "../db/alertModel.php";

if (!isset($_SESSION["admin"])) {
    header("location: login.php");
    exit();
}

$expired = getExpiredMedicines();
$nearExpiry = getNearExpiryMedicines();
$outStock = getOutOfStockMedicines();
$lowStock = getLowStockMedicines();
?>

<!DOCTYPE html>
<html>
<head>
<title>Smart Alerts</title>
<link rel="stylesheet" href="../css/alerts.css">
</head>
<body>

<div class="header">Smart Alert System</div>

<div class="content">

<h2>🚨 Expiry Alerts</h2>

<h3>Expired Medicines</h3>
<table>
<tr><th>Name</th><th>Expiry Date</th></tr>
<?php while($m = $expired->fetch_assoc()): ?>
<tr class="danger">
<td><?= $m['name']; ?></td>
<td><?= $m['expiry_date']; ?></td>
</tr>
<?php endwhile; ?>
</table>

<h3>Near Expiry (Next 30 Days)</h3>
<table>
<tr><th>Name</th><th>Expiry Date</th></tr>
<?php while($m = $nearExpiry->fetch_assoc()): ?>
<tr class="warning">
<td><?= $m['name']; ?></td>
<td><?= $m['expiry_date']; ?></td>
</tr>
<?php endwhile; ?>
</table>

<hr>

<h2>Stock Alerts</h2>

<h3>Out of Stock</h3>
<table>
<tr><th>Name</th><th>Quantity</th></tr>
<?php while($m = $outStock->fetch_assoc()): ?>
<tr class="danger">
<td><?= $m['name']; ?></td>
<td><?= $m['quantity']; ?></td>
</tr>
<?php endwhile; ?>
</table>

<h3>Low Stock (≤10)</h3>
<table>
<tr><th>Name</th><th>Quantity</th></tr>
<?php while($m = $lowStock->fetch_assoc()): ?>
<tr class="warning">
<td><?= $m['name']; ?></td>
<td><?= $m['quantity']; ?></td>
</tr>
<?php endwhile; ?>
</table>

</div>
<div class="sidebar"> 
    <a href="dashboard.php"> Overview</a>
    <a href="staff.php">Staff Management</a>
    <a href="medicine.php"> Medicine Stock</a>
    <a href="../php/salesReportController.php">Sales Reports</a>
    <a href="commissionReport.php">Commissions</a>
    <a href="alerts.php">Smart Alerts</a>
     <a href="../php/logout.php" >Logout </a>
</div>
</body>
</html>
