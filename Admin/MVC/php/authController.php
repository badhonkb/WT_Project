
<?php
session_start();
require_once "../db/authModel.php";

if (isset($_POST["login"])) {

    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

  
    $adminResult = checkAdminLogin($email);
    if ($adminResult && $adminResult->num_rows == 1) {
        $admin = $adminResult->fetch_assoc();

        if (password_verify($password, $admin["password"])) {
            $_SESSION["admin"] = $admin["email"];
            $_SESSION["role"] = "Admin";

            
            if (isset($_POST["remember"])) {
                setcookie("remember_email", $email, time() + (86400 * 7), "/");
                setcookie("remember_password", $password, time() + (86400 * 7), "/"); 
            } else {
                setcookie("remember_email", "", time() - 3600, "/"); 
                setcookie("remember_password", "", time() - 3600, "/");
            }
            

            
            
            header("Location: ../html/dashboard.php");
            exit();
        }
    } 

   
    $staffResult = checkStaffLogin($email);
    if ($staffResult && $staffResult->num_rows == 1) {
        $staff = $staffResult->fetch_assoc();

        if (password_verify($password, $staff["password"])) {
            $_SESSION["staff"] = $staff["email"];
            $_SESSION["role"] = $staff["role"];

         
            if (isset($_POST["remember"])) {
                setcookie("remember_email", $email, time() + (86400 * 7), "/");
            } else {
                setcookie("remember_email", "", time() - 3600, "/");
            }

           
            switch ($staff["role"]) {
                case "Salesman":
                    header("Location: ../../../Salesman/MVC/html/dashboard.php");
                    break;

                default:
                    header("Location: ../html/login.php"); 
            }
            exit();
        }
    }

   
    $_SESSION["error"] = "Invalid Email or Password";
    header("Location: ../html/login.php");
    exit();
}
