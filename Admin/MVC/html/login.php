

 <?php
session_start();
$error = $_SESSION["error"] ?? "";
unset($_SESSION["error"]);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>

<div class="login-box">
    <h2>Medical Shop Login</h2>

    <?php if($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="post" action="../php/authController.php">
        <label>Email</label>
        <input type="email" name="email" value="<?php echo $_COOKIE['remember_email'] ?? ''; ?>" required>
        

        <label>Password</label>
        <input type="password" name="password" required>
        <label>
        <input type="checkbox" name="remember"> Remember Me
        </label>


        <input type="submit" name="login" value="Login ">
    </form>
     <p class="register-link">
        Not registered? 
        <a href="adminRegister.php">Register as Admin</a> 
    </p>
</div>

</body>
</html>

