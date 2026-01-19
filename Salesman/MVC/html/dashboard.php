<?php
session_start();

if (!isset($_SESSION['staff']) || $_SESSION['role'] != 'Salesman') {
    header("Location: ../../Admin/MVC/html/login.php");
    exit();
}

include "../db/dashboardModel.php";

$todaySale   = getTodayTotalSale();
$todayBills  = getTodayTotalBills();
$topMedicines = getTopSellingMedicinesToday();


?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Salesman Dashboard</title>
<link rel="stylesheet" href="../css/dashboard.css">


</head>

<body>

<div class="header"> Salesman Dashboard</div>

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

<h2>Welcome, <?php echo $_SESSION['staff']; ?> </h2>

<div class="card-box">
    <div class="card">
        <h3>Today's Total Sale</h3>
        <p>৳ <?php echo number_format($todaySale,2); ?></p>
    </div>

    <div class="card">
        <h3>Total Bills Today</h3>
        <p><?php echo $todayBills; ?></p>
    </div>
</div>

<div class="table-box">
    <h3 style="margin-bottom:15px;color:#1e3c72;">
         Top 5 Selling Medicines (Today)
    </h3>

    <table>
        <tr>
            <th>#</th>
            <th>Medicine Name</th>
            <th>Sold Quantity</th>
        </tr>

        <?php 
        $i=1;
        while($row = $topMedicines->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['total_qty']; ?></td>
        </tr>
        <?php } ?>

        <?php if($i==1){ ?>
        <tr>
            <td colspan="3">No sales today</td>
        </tr>
        <?php } ?>
    </table>
</div>

<br>
 <a href="../../../Admin/MVC/php/logout.php" class="logout">Logout</a>

</div>
</div>

</body>
</html>
