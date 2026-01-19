<?php
include "config.php";


function getAllCustomers() {
    global $conn;
    $sql = "SELECT * FROM customers ORDER BY id DESC";
    return $conn->query($sql);
}


function getCustomerById($id) {
    global $conn;
    $sql = "SELECT * FROM customers WHERE id=$id";
    $result = $conn->query($sql);
    return $result->fetch_assoc();
}


function addCustomer($name, $email, $phone) {
    global $conn;
    $sql = "INSERT INTO customers (name, email, phone) VALUES ('$name','$email','$phone')";
    return $conn->query($sql);
}

function updateCustomer($id, $name, $email, $phone) {
    global $conn;
    $sql = "UPDATE customers SET name='$name', email='$email', phone='$phone' WHERE id=$id";
    return $conn->query($sql);
}


function deleteCustomer($id) {
    global $conn;
    $sql = "DELETE FROM customers WHERE id=$id";
    return $conn->query($sql);
}
?>
