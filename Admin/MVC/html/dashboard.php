<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("location: login.php");
    exit();
}

include "../db/config.php"; 




$staffRes = $conn->query("SELECT COUNT(*) AS total FROM staff WHERE role='Salesman'");
$totalStaff = $staffRes->fetch_assoc()['total'] ?? 0;

$medRes = $conn->query("SELECT COUNT(*) AS total FROM medicine");
$totalMedicines = $medRes->fetch_assoc()['total'] ?? 0;


$todaySaleRes = $conn->query("
    SELECT IFNULL(SUM(grand_total),0) AS total 
    FROM sales 
    WHERE DATE(created_at) = CURDATE()
");
$dailySales = $todaySaleRes->fetch_assoc()['total'] ?? 0;


$monthlyRes = $conn->query("
    SELECT IFNULL(SUM(grand_total),0) AS total 
    FROM sales 
    WHERE MONTH(created_at) = MONTH(CURDATE())
      AND YEAR(created_at) = YEAR(CURDATE())
");
$monthlyRevenue = $monthlyRes->fetch_assoc()['total'] ?? 0;


$alertRes = $conn->query("SELECT COUNT(*) AS total FROM medicine WHERE quantity <= 10");
$alerts = $alertRes->fetch_assoc()['total'] ?? 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
<link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>

<div class="header">Admin Dashboard</div>


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

    <div class="welcome-box">
        <h2>Welcome, Admin </h2>
        <p>You are logged in as <strong><?php echo htmlspecialchars($_SESSION["admin"]); ?></strong></p>
        <a href="../php/logout.php" class="logout-btn">Logout </a>
    </div>

  
    <div class="overview-cards">

        <div class="card">
            <h3>Total Salesmen</h3>
            <p><?php echo $totalStaff; ?></p>
        </div>

        <div class="card">
            <h3>Total Medicines</h3>
            <p><?php echo $totalMedicines; ?></p>
        </div>

        <div class="card">
            <h3>Today's Sales</h3>
            <p>৳ <?php echo number_format($dailySales, 2); ?></p>
        </div>

        <div class="card">
            <h3>Monthly Revenue</h3>
            <p>৳ <?php echo number_format($monthlyRevenue, 2); ?></p>
        </div>

        <div class="card">
            <h3>Low Stock Alerts</h3>
            <p><?php echo $alerts; ?></p>
        </div>

    </div>

</div>

</body>
</html>
