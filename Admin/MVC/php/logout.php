
<?php
session_start();


session_unset();
session_destroy();


if (isset($_COOKIE['remember_email'])) {
    setcookie('remember_email', '', time() - 3600, '/');
}

if (isset($_COOKIE['remember_password'])) {
    setcookie('remember_password', '', time() - 3600, '/');
}


header("Location: ../html/login.php");
exit();

