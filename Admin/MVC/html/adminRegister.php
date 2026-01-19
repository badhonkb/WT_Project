<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Registration</title>
<link rel="stylesheet" href="../css/Register.css">
</head>
<body>

<div class="register-container">
    <h2>Admin Registration</h2>  

   
    <?php
    if (isset($_SESSION['reg_success'])) {
        echo '<p class="success-msg">'.$_SESSION['reg_success'].'</p>';
        unset($_SESSION['reg_success']);
    }
    if (isset($_SESSION['reg_error'])) {
        echo '<p class="error-msg">'.$_SESSION['reg_error'].'</p>';
        unset($_SESSION['reg_error']);
    }

   
    ?>

    <form method="post" action="../php/registrationController.php">
        <label>Name</label>
        <input type="text" name="name" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <label>Confirm Password</label>
        <input type="password" name="confirm_password" required>

        <input type="submit" name="register" value="Register ">
    </form>

    <p class="login-link">
        Already registered? <a href="login.php">Login</a>
    </p>
</div>

</body>
</html>
