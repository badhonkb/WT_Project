<?php
session_start();
include "../db/medicineModel.php";

if (!isset($_SESSION["admin"])) {
    header("location: login.php");
    exit();
}

$medicines = getAllMedicines();
$updateMedicine = null;
if(isset($_GET['update_id'])) {
    $updateMedicine = getMedicineById($_GET['update_id']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Medicine Stock</title>
<link rel="stylesheet" href="../css/medicine.css">
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
    <h2>Medicine Stock Management</h2>

    <div class="add-medicine-form">
    <h3><?php echo $updateMedicine ? 'Update Medicine' : 'Add New Medicine'; ?></h3>
    <form method="post" action="../php/medicineController.php">
        <input type="hidden" name="id" value="<?php echo $updateMedicine['id'] ?? ''; ?>">

        <label for="name">Medicine Name</label>
        <input type="text" id="name" name="name" placeholder="Medicine Name" value="<?php echo $updateMedicine['name'] ?? ''; ?>" required>

        <label for="generic_name">Generic Name</label>
        <input type="text" id="generic_name" name="generic_name" placeholder="Generic Name" value="<?php echo $updateMedicine['generic_name'] ?? ''; ?>">

        <label for="price">Price</label>
        <input type="number" step="0.01" id="price" name="price" placeholder="Price of each unit" value="<?php echo $updateMedicine['price'] ?? ''; ?>" required>

        <label for="expiry">Expiry Date</label>
        <input type="date" id="expiry" name="expiry" placeholder="Expiry Date" value="<?php echo $updateMedicine['expiry_date'] ?? ''; ?>" required>

        <label for="quantity">Quantity</label>
        <input type="number" id="quantity" name="quantity" placeholder="Quantity" value="<?php echo $updateMedicine['quantity'] ?? ''; ?>" required>

        <label for="company_name">Company Name</label>
        <input type="text" id="company_name" name="company_name" placeholder="Company Name" value="<?php echo $updateMedicine['company_name'] ?? ''; ?>">

        <input type="submit" name="addMedicine" value="<?php echo $updateMedicine ? 'Update Medicine' : 'Add Medicine'; ?>">
    </form>
</div>


    <h3>Medicine List</h3>
    <table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Generic Name</th>
        <th>Price</th>
        <th>Expiry Date</th>
        <th>Quantity</th>
        <th>Company Name</th>
        <th>Action</th>
    </tr>
    <?php while($row = $medicines->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['generic_name']; ?></td>
        <td><?php echo $row['price']; ?></td>
        <td><?php echo $row['expiry_date']; ?></td>
        <td><?php echo $row['quantity']; ?></td>
        <td><?php echo $row['company_name']; ?></td>
        <td>
            <a href="medicine.php?update_id=<?php echo $row['id']; ?>">Update</a> 
            <a href="../php/medicineController.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
    </table>

</div>
</body>
</html>
