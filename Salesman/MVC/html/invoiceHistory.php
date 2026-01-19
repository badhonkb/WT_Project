<?php
session_start();
if(!isset($_SESSION['staff']) || $_SESSION['role'] != 'Salesman') {
    header("Location: ../Admin/MVC/html/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Invoice History</title>
    <link rel="stylesheet" href="../css/invoice_history.css">
</head>
<body>

<div class="header">Salesman Dashboard</div>

<div class="container">
    <div class="sidebar">
    <a href="billing.php">Billing</a>
    <a href="customers.php">Customer Management</a>
    <a href="invoiceHistory.php">Invoice History</a>
    <a href="medicine_return.php">Return Medicines</a>
    <a href="top_selling.php">Top Selling Item</a>
    <a href="../php/profileController.php">My Profile</a>
    <a href="../../../Admin/MVC/php/logout.php" class="logout">Logout</a>
    </div>

    <div class="content">
        <h2>Invoice History</h2>
        <div class="filter-search">
            <input type="text" id="search" placeholder="Search by customer name or phone">
            <select id="filter">
                <option value="today">Today</option>
                <option value="7days">Last 7 Days</option>
                <option value="30days">Last 30 Days</option>
                <option value="all">All</option>
            </select>
        </div>
        <table id="invoice-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Phone</th>
                    <th>Date & Time</th>
                    <th>Total</th>
                    <th>Discount</th>
                    <th>Grand Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
               
            </tbody>
        </table>
    </div>
</div>


<div id="invoice-modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div id="invoice-details"></div>
    </div>
</div>

<script src="../js/invoice.js"></script>
</body>
</html>
