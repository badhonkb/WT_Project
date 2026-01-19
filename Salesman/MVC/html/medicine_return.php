<?php
session_start();
if(!isset($_SESSION['staff']) || $_SESSION['role'] != 'Salesman') {
    header("Location: ../Admin/MVC/html/login.php");
    exit();
}

include "../db/medicineReturnModel.php";

$sale = null;
$items = null;


if(isset($_POST['fetch_invoice'])) {
    $sale_id = (int)$_POST['sale_id'];
    $data = getSaleById($sale_id);
    $sale = $data['sale'];
    $items = $data['items'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Medicine Return</title>
    <link rel="stylesheet" href="../css/medicine_return.css">
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
        <h2>Medicine Return</h2>

        <?php if(isset($_GET['success'])): ?>
            <p style="color:green;"><?=$_GET['success']?></p>
        <?php endif; ?>

        <form method="POST">
            <label>Invoice ID:</label>
            <input type="number" name="sale_id" required>
            <button type="submit" name="fetch_invoice">Fetch Invoice</button>
        </form>

        <?php if($sale): ?>
            <h3>Invoice #<?=$sale['id']?> - Customer: <?=$sale['customer_name']?> | <?=$sale['phone']?></h3>
            <form method="POST" action="../php/medicineReturnController.php">
                <input type="hidden" name="sale_id" value="<?=$sale['id']?>">
                <input type="hidden" name="customer_id" value="<?=$sale['customer_id']?>">
                <label>Reason for Return:</label>
                <input type="text" name="reason" required>

                <table>
                    <tr><th>Medicine</th><th>Qty Sold</th><th>Return Qty</th></tr>
                    <?php while($row = $items->fetch_assoc()): ?>
                        <tr>
                            <td><?=$row['name']?></td>
                            <td><?=$row['quantity']?></td>
                            <td>
                                <input type="number" name="medicines[<?=$row['medicine_id']?>]" min="0" max="<?=$row['quantity']?>" value="0">
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
                <button type="submit" name="submit_return">Process Return</button>
            </form>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
