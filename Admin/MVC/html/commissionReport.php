<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Commission Report</title>
    <link rel="stylesheet" href="../css/commission.css">
</head>
<body>


<div class="header"> Salesman Commission Dashboard</div>


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

 
    <div class="filters">
        <select id="dayFilter">
            <option value="7">Last 7 Days</option>
            <option value="15">Last 15 Days</option>
            <option value="30">Last 30 Days</option>
        </select>

        <select id="salesmanFilter">
            <option value="">All Salesmen</option>
        </select>
    </div>

    
    <table>
        <thead>
            <tr>
                <th>SL</th>
                <th>Salesman</th>
                <th>Total Amount (৳)</th>
                <th>Commission (5%)</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody id="commissionBody"></tbody>
    </table>

</div>

<script src="../js/commission.js"></script>
</body>
</html>
