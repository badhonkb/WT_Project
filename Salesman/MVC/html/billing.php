<?php
session_start();
if(!isset($_SESSION['staff']) || $_SESSION['role'] != 'Salesman'){
    header("Location: ../../../Admin/MVC/html/login.php");
    exit();
}

include "../db/billingModel.php";
$customers = getAllCustomers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Salesman Billing</title>
<link rel="stylesheet" href="../css/billing.css">
</head>
<body>

<div class="header">
     Medical Shop | Salesman |
    <a href="../../../Admin/MVC/php/logout.php" class="logout">Logout</a>
</div>

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
        <h2>Billing</h2>

        
        <div id="notification" class="notification"></div>

        
        <div class="customer-section">
            <div class="customer-box">
                <label>Customer</label>
                <select id="customerSelect">
                    <option value="">Select Customer</option>
                    <?php while($c = $customers->fetch_assoc()): ?>
                        <option value="<?= $c['id'] ?>">
                            <?= $c['name'] ?> (<?= $c['phone'] ?>)
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="customer-btn-box">
               <button id="addCustomerBtn">
    <img src="../images/plus.png" width="16"> Add Customer
</button>

            </div>
        </div>

      
        <div class="medicine-section">
            <label>Search Medicine</label>
            <input type="text" id="medicineSearch" placeholder="Type medicine name...">
            <div id="searchResults" class="search-results"></div>
        </div>

       
        <h3>Cart</h3>
        <table id="cartTable">
            <thead>
                <tr>
                    <th>Medicine</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

       
        <div class="billing-summary">
            <div>
                <label>Discount (%)</label>
                <input type="number" id="discount" value="0" min="0" max="100">
            </div>

            <div>
                <p>Total: ৳ <div id="total">0.00</div></p>
            </div>

            <div>
                <p>Grand Total: ৳ <div id="grandTotal">0.00</div></p>
            </div>

            <div>
                <button id="payBtn"> Pay</button>
                <button id="printBtn"> Print</button>
            </div>
        </div>

    </div>
</div>

<script src="../js/billing.js"></script>
</body>
</html>
