<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Profile | Salesman</title>
<link rel="stylesheet" href="../css/profile.css">
</head>
<body>

<div class="header"> Medical Shop | Salesman |</div>

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
        <h2>My Profile</h2>

        <?php if(isset($message) && $message != ''): ?>
            <div class="notification <?= htmlspecialchars($type) ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <div class="profile-info">
            <p><b>Name:</b> <?= isset($staff['name']) ? htmlspecialchars($staff['name']) : 'N/A' ?></p>
            <p><b>Email:</b> <?= isset($staff['email']) ? htmlspecialchars($staff['email']) : 'N/A' ?></p>
        </div>

        <div class="change-password">
            <h3>Change Password</h3>
            <form method="post">
                <label>Current Password</label>
                <input type="password" name="current_password" required>
                
                <label>New Password</label>
                <input type="password" name="new_password" required>
                
                <label>Confirm New Password</label>
                <input type="password" name="confirm_password" required>

                <button type="submit" name="changePassword">Update Password</button>
            </form>
        </div>
    </div>

</div>

</body>
</html>
