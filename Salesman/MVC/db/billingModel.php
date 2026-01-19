<?php
include "config.php";


function getAllCustomers() {
    global $conn;
    $sql = "SELECT * FROM customers ORDER BY name ASC";
    return $conn->query($sql);
}


function searchMedicines($keyword) {
    global $conn;
    $keyword = $conn->real_escape_string($keyword);
    $sql = "SELECT * FROM medicine 
            WHERE name LIKE '%$keyword%' AND quantity > 0
            ORDER BY name ASC
            LIMIT 10";
    return $conn->query($sql);
}


function getMedicineById($id) {
    global $conn;
    $sql = "SELECT * FROM medicine WHERE id=$id";
    $res = $conn->query($sql);
    return $res->fetch_assoc();
}


function reduceStock($medicine_id, $qty) {
    global $conn;
    $sql = "UPDATE medicine SET quantity = quantity - $qty WHERE id=$medicine_id";
    return $conn->query($sql);
}


function createSale($customer_id, $salesman_email, $total, $discount, $grand_total) {
    global $conn;
    $sql = "INSERT INTO sales (customer_id, salesman_email, total, discount, grand_total)
            VALUES ($customer_id, '$salesman_email', $total, $discount, $grand_total)";
    if($conn->query($sql)) {
        return $conn->insert_id; 
    }
    return false;
}


function addSaleItem($sale_id, $medicine_id, $quantity, $price, $subtotal) {
    global $conn;
    $sql = "INSERT INTO sale_items (sale_id, medicine_id, quantity, price, subtotal)
            VALUES ($sale_id, $medicine_id, $quantity, $price, $subtotal)";
    return $conn->query($sql);
}



function getAvailableStock($medicine_id){
    global $conn;
    $sql = "SELECT quantity FROM medicine WHERE id = $medicine_id";
    $res = $conn->query($sql);
    if($row = $res->fetch_assoc()){
        return (int)$row['quantity'];
    }
    return 0;
}

?>
