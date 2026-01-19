<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("location: login.php");
    exit();
}

include "../db/staffModel.php";
$staffs = getAllStaff();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Staff Management</title>
<link rel="stylesheet" href="../css/staff.css">
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
    <h2>Staff Management</h2>

    <div class="add-staff-form">
        <h3>Add New Staff</h3>
        <form method="post" action="../php/staffController.php">
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <select name="role" required>
                <option value="">Select Role</option>
                <option value="Salesman">Salesman</option>
               
            </select>
            <input type="text" name="rolePassword" placeholder="Set Password for Role" required>
            <input type="submit" name="addStaff" value="Add Staff">
        </form>
    </div>

    <h3>Staff List</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
        <?php while($row = $staffs->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['role']; ?></td>
            <td>
                <a href="../php/staffController.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
               
            
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

</div>

</body>
</html>

