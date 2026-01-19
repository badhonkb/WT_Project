<?php 
session_start();


if (!isset($_SESSION['staff']) || $_SESSION['role'] != 'Salesman') {
    header("Location: ../../Admin/MVC/html/login.php");
    exit();
}

include "../db/customerModel.php";

$customers = getAllCustomers();
$updateCustomer = null;
if(isset($_GET['update_id'])) {
    $updateCustomer = getCustomerById($_GET['update_id']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../css/customers.css">
<title>Customer Management</title>
</head>
<body>

<div class="header">👥 Customer Management</div>

<div class="container">
    <div class="sidebar">
    <a href="billing.php">Billing</a>
    <a href="customers.php">Customer Management</a>
    <a href="invoiceHistory.php">Invoice History</a>
    <a href="medicine_return.php">Return Medicines</a>
    <a href="top_selling.php">Top Selling Item</a>
    <a href="../php/profileController.php">My Profile</a>
        <a href="../../Admin/MVC/html/logout.php">Logout</a>
    </div>

    <div class="content">

        <?php if(isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <div class="add-customer-form">
            <h3><?= $updateCustomer ? "Update Customer" : "Add New Customer"; ?></h3>
            <form method="post" action="../php/customerController.php">
                <input type="hidden" name="id" value="<?= $updateCustomer['id'] ?? ''; ?>">

                <p>Full Name *</p>
                <input type="text" name="name" placeholder="Full Name" value="<?= $updateCustomer['name'] ?? ''; ?>" required>

                <p>Email *</p>
                <input type="email" name="email" placeholder="Email" value="<?= $updateCustomer['email'] ?? ''; ?>" required>

                <p>Phone Number *</p>
                <input type="text" name="phone" placeholder="Phone Number" value="<?= $updateCustomer['phone'] ?? ''; ?>" required>

                <button type="submit" name="<?= $updateCustomer ? 'updateCustomer' : 'addCustomer'; ?>">
                    <?= $updateCustomer ? "Update Customer" : "Add Customer"; ?>
                </button>
            </form>
        </div>

        <h3>Customer List</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Action</th>
            </tr>
            <?php while($row = $customers->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= $row['name']; ?></td>
                <td><?= $row['email']; ?></td>
                <td><?= $row['phone']; ?></td>
                <td>
                    <a href="customers.php?update_id=<?= $row['id']; ?>">Edit</a> |
                    <a href="../php/customerController.php?delete_id=<?= $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>

    </div>
</div>

</body>
</html>
