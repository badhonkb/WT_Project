<?php
session_start();
include "../db/adminModel.php";

if (isset($_POST['register'])) {

    $name            = $_POST['name'];
    $email           = $_POST['email'];
    $password        = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    
    if (empty($name) || empty($email) || empty($password)) {
        $_SESSION['reg_error'] = " All fields are required";
        header("Location: ../html/adminRegister.php");
        exit();
    }

  
    if ($password !== $confirmPassword) {
        $_SESSION['reg_error'] = "Password does not match";
        header("Location: ../html/adminRegister.php");
        exit();
    }

    
    if (adminEmailExists($email)->num_rows > 0) {
        $_SESSION['reg_error'] = "Email already registered";
        header("Location: ../html/adminRegister.php");
        exit();
    }

 
    if (insertAdmin($name, $email, $password)) {
        $_SESSION['reg_success'] = " Admin registered successfully";
        header("Location: ../html/adminRegister.php");
        exit();
    } else {
        $_SESSION['reg_error'] = " Registration failed";
        header("Location: ../html/adminRegister.php");
        exit();
    }
}
?>
