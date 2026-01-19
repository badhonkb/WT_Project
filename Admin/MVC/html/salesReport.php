<!DOCTYPE html>
<html>
<head>
<title>Admin Sales Report</title>
<link rel="stylesheet" href="../css/salesReport.css">
</head>
<body>

<div class="header">📊 Admin Sales Report</div>

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

   
    <form method="get" class="filter-box">
        <select name="filter">
            <option value="today">Today</option>
            <option value="7days">Last 7 Days</option>
            <option value="month">This Month</option>
        </select>
        <button>Apply</button>
    </form>

    <div class="overview-cards">
        <div class="card">
            <h3>Total Sales</h3>
            <p>৳ <?= number_format($summary['total_sales'] ?? 0,2); ?></p>
        </div>
        <div class="card">
            <h3>Total Bills</h3>
            <p><?= $summary['total_bills'] ?? 0; ?></p>
        </div>
    </div>

   
    <div class="welcome-box">
        <h3>Salesman Performance</h3>
        <table>
            <tr>
                <th>Rank</th>
                <th>Salesman</th>
                <th>Total Bills</th>
                <th>Total Sales (৳)</th>
            </tr>

            <?php $rank=1; foreach($chartData as $row): ?>
            <tr>
                <td><?= $rank==1 ? '🏆' : $rank; ?></td>
                <td><?= $row['salesman_email']; ?></td>
                <td><?= $row['total_bills']; ?></td>
                <td><?= number_format($row['total_sales'],2); ?></td>
            </tr>
            <?php $rank++; endforeach; ?>
        </table>
    </div>

    <div class="welcome-box">
        <h3>Salesman Bills Comparison</h3>
        <canvas id="salesChart"></canvas>
    </div>

</div>

<script>
const chartData = <?= json_encode($chartData); ?>;
</script>
<script src="../js/salesReportChart.js"></script>
</body>
</html>
