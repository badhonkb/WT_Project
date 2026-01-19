<?php
session_start();
include "../db/medicineModel.php";

if (!isset($_SESSION["admin"])) {
    header("location: login.php");
    exit();
}


$updateMedicine = null;
if(isset($_GET['update_id'])) {
    $updateMedicine = getMedicineById($_GET['update_id']);
}


if (isset($_POST['addMedicine'])) {
    $id = $_POST['id'] ?? null;
    $name = $_POST['name'];
    $generic = $_POST['generic_name'];
    $price = $_POST['price'];
    $expiry = $_POST['expiry'];
    $quantity = $_POST['quantity'];
    $company = $_POST['company_name'];

    if($id) {
        updateMedicine($id, $name, $generic, $price, $expiry, $quantity, $company);
    } else {
        addMedicine($name, $generic, $price, $expiry, $quantity, $company);
    }
    header("location: ../html/medicine.php");
}


if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    deleteMedicine($id);
    header("location: ../html/medicine.php");
}
?>
