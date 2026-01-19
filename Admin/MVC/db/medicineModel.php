<?php
include "config.php";


function getAllMedicines() {
    global $conn;
    $sql = "SELECT * FROM medicine ORDER BY id DESC";
    return $conn->query($sql);
}


function addMedicine($name, $generic, $price, $expiry, $quantity, $company) {
    global $conn;
    $sql = "INSERT INTO medicine (name, generic_name, price, expiry_date, quantity, company_name) 
            VALUES ('$name', '$generic', '$price', '$expiry', '$quantity', '$company')";
    return $conn->query($sql);
}


function deleteMedicine($id) {
    global $conn;
    $sql = "DELETE FROM medicine WHERE id=$id";
    return $conn->query($sql);
}


function getMedicineById($id) {
    global $conn;
    $sql = "SELECT * FROM medicine WHERE id=$id";
    $result = $conn->query($sql);
    return $result->fetch_assoc();
}


function updateMedicine($id, $name, $generic, $price, $expiry, $quantity, $company) {
    global $conn;
    $sql = "UPDATE medicine SET 
            name='$name', 
            generic_name='$generic', 
            price='$price', 
            expiry_date='$expiry', 
            quantity='$quantity', 
            company_name='$company' 
            WHERE id=$id";
    return $conn->query($sql);
}
?>
