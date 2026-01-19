<?php
include "config.php";


function getSaleById($sale_id) {
    global $conn;
    $sale_id = (int)$sale_id;

    $sql = "SELECT s.*, c.name as customer_name, c.phone, c.id as customer_id
            FROM sales s
            JOIN customers c ON s.customer_id = c.id
            WHERE s.id = $sale_id";
    $sale = $conn->query($sql)->fetch_assoc();

    $sql_items = "SELECT si.*, m.name, m.price, m.quantity as stock
                  FROM sale_items si
                  JOIN medicine m ON si.medicine_id = m.id
                  WHERE si.sale_id = $sale_id";
    $items = $conn->query($sql_items);

    return ['sale' => $sale, 'items' => $items];
}


function createReturn($sale_id, $customer_id, $reason, $total_return) {
    global $conn;
    $sql = "INSERT INTO medicine_returns (sale_id, customer_id, reason, total_return)
            VALUES ($sale_id, $customer_id, '$reason', $total_return)";
    if($conn->query($sql)) {
        return $conn->insert_id;
    }
    return false;
}


function addReturnItem($return_id, $medicine_id, $quantity, $price, $subtotal) {
    global $conn;
    $sql = "INSERT INTO medicine_return_items (return_id, medicine_id, quantity, price, subtotal)
            VALUES ($return_id, $medicine_id, $quantity, $price, $subtotal)";
    return $conn->query($sql);
}

function increaseStock($medicine_id, $qty) {
    global $conn;
    $sql = "UPDATE medicine SET quantity = quantity + $qty WHERE id=$medicine_id";
    return $conn->query($sql);
}


function getReturnHistory() {
    global $conn;
    $sql = "SELECT mr.*, c.name as customer_name, c.phone
            FROM medicine_returns mr
            JOIN customers c ON mr.customer_id = c.id
            ORDER BY mr.id DESC";
    return $conn->query($sql);
}
?>
