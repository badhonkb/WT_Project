<?php
session_start();
include "../db/staffModel.php";

if (!isset($_SESSION["admin"])) {
    header("location: login.php");
    exit();
}



if (isset($_POST['addStaff'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = $_POST['rolePassword']; 
    addStaff($name, $email, $role, $password); 
    header("location: ../html/staff.php");
}



if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    deleteStaff($id);
    header("location: ../html/staff.php");
}



if (isset($_POST['addStaff'])) {
    $id = $_POST['id'] ?? null; 
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = $_POST['rolePassword'];

    if($id) {
        
        updateStaff($id, $name, $email, $role);
    } else {
        
        addStaff($name, $email, $role, $password);
    }
    header("location: ../html/staff.php");
}


if(isset($_GET['update_id'])) {
    $updateStaff = getStaffById($_GET['update_id']); 
}

?>
