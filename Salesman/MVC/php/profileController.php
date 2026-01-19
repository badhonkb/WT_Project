<?php
session_start();


if(!isset($_SESSION['staff']) || $_SESSION['role'] != 'Salesman'){
    header("Location: ../html/login.php");
    exit();
}


include __DIR__ . '/../db/profileModel.php';


$message = '';
$type = '';


$email = $_SESSION['staff'];
$staff = getStaffByEmail($email);

if(!$staff){
    $message = "Staff not found!";
    $type = "error";
}  


if(isset($_POST['changePassword']) && $staff){
    $current = $_POST['current_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    if($new !== $confirm){
        $message = "New password and confirm password do not match!";
        $type = "error";
    } elseif(!password_verify($current, $staff['password'])){
        $message = "Current password is incorrect!";
        $type = "error";
    } else {
        $hashed = password_hash($new, PASSWORD_DEFAULT);
        if(updateStaffPassword($staff['id'], $hashed)){
            $message = "Password updated successfully!";
            $type = "success";
        } else {
            $message = "Failed to update password!";
            $type = "error";
        }
    }
}


include __DIR__ . '/../html/myProfile.php';
?>
