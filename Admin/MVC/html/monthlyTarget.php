<?php 
session_start();
if (!isset($_SESSION["admin"])) {
    header("location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Monthly Target</title>
<link rel="stylesheet" href="../css/target.css">
</head>
<body>

<div class="header">💼 Admin | Monthly Target</div>
<div class="container">
    <div class="sidebar">
    <a href="dashboard.php"> Overview</a>
    <a href="staff.php">Staff Management</a>
    <a href="medicine.php"> Medicine Stock</a>
    <a href="../php/salesReportController.php">Sales Reports</a>
    <a href="commissionReport.php">Commissions</a>
    <a href="alerts.php">Smart Alerts</a>
    <a href="../php/logout.php" >Logout </a>
    </div>

    <div class="content">
        <h2>Set Monthly Target</h2>
        <div class="set-target">
            <input type="text" id="emailInput" placeholder="Select Salesman">
            <input type="number" id="amountInput" placeholder="Target Amount">
            <button id="setTargetBtn">Set Target</button>
            <p id="message"></p>
        </div>

        <h3>Current Targets</h3>
        <div id="progressContainer"></div>
    </div>
</div>

<script src="../js/target.js"></script>
</body>
</html>
